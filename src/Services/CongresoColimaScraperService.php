<?php
declare(strict_types=1);

namespace PulsoCivico\Services;

use PulsoCivico\Core\HttpClient;
use PulsoCivico\Core\Logger;
use PulsoCivico\Core\EvidenceHasher;

/**
 * Scraper oficial para el H. Congreso del Estado de Colima (LXI, LX y LIX).
 * Soporta sharding multi-nodo y consolidación con Merkle Root.
 */
class CongresoColimaScraperService
{
    public const BASE_URL = 'https://congresocol.gob.mx/web/www';
    public const INDEX_URL = 'https://congresocol.gob.mx/web/www/diputados/index.php?idt=';
    public const DETAIL_URL = 'https://congresocol.gob.mx/web/www/diputados/index2.php';

    private const LEGISLATURAS_CONFIG = [
        61 => ['romano' => 'LXI', 'periodo' => '2024-2027', 'toma_protesta' => '2024-10-01', 'ids' => [125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149]],
        60 => ['romano' => 'LX', 'periodo' => '2021-2024', 'toma_protesta' => '2021-10-01', 'ids' => [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 109, 110, 112, 113, 114, 115, 117, 118, 119, 120, 121, 122, 123, 124]],
        59 => ['romano' => 'LIX', 'periodo' => '2018-2021', 'toma_protesta' => '2018-10-01', 'ids' => [65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89]],
    ];

    private HttpClient $http;
    private Logger $logger;
    private string $storagePath;

    public function __construct(HttpClient $http, Logger $logger, string $storagePath)
    {
        $this->http = $http;
        $this->logger = $logger;
        $this->storagePath = rtrim($storagePath, '/\\');
    }

    public function scrapeLegislatura61(array $options = []): array
    {
        return $this->scrapeLegislatura(61, $options);
    }

    /**
     * Extrae legisladores de una legislatura del Congreso de Colima (61, 60 o 59).
     */
    public function scrapeLegislatura(int $legislatura = 61, array $options = []): array
    {
        $cfg = self::LEGISLATURAS_CONFIG[$legislatura] ?? self::LEGISLATURAS_CONFIG[61];
        $nodeId = isset($options['node_id']) && (int)$options['node_id'] > 0 ? (int)$options['node_id'] : null;
        $totalNodes = isset($options['total_nodes']) && (int)$options['total_nodes'] > 0 ? (int)$options['total_nodes'] : 2;
        $downloadPhotos = !empty($options['download_photos']);

        $this->logger->info("Iniciando scraper del Congreso de Colima ({$cfg['romano']} Legislatura {$cfg['periodo']})...", [
            'legislatura' => $legislatura,
            'node_id' => $nodeId ?? 'ALL',
            'total_nodes' => $totalNodes,
        ]);

        $targets = $this->discoverTargetsForLeg($legislatura, $cfg['ids']);
        $totalFound = count($targets);

        if ($nodeId !== null) {
            $targets = $this->partitionTargets($targets, $nodeId, $totalNodes);
            $this->logger->info("Partición asignada al Nodo {$nodeId}/{$totalNodes}: " . count($targets) . " de {$totalFound} diputados.");
        }

        $fechaExtraccion = date('Y-m-d H:i:s');
        $legisladores = [];
        $hashesEvidencia = [];

        foreach ($targets as $target) {
            $id = $target['id'];
            $logoHint = $target['logo'] ?? '';
            $url = self::DETAIL_URL . "?id={$id}&vlegis={$legislatura}";

            try {
                $response = $this->http->request('GET', $url, [], ['Referer: ' . self::INDEX_URL]);
                $html = $response['body'];
                if (!mb_check_encoding($html, 'UTF-8')) {
                    $html = mb_convert_encoding($html, 'UTF-8', 'ISO-8859-1');
                }

                $parsed = $this->parseDeputyDetail($id, $html, $logoHint, $legislatura);
                if ($parsed === null) {
                    $this->logger->warning("No se pudo estructurar el diputado ID: {$id} (Leg {$legislatura})");
                    continue;
                }

                $hashEvidencia = EvidenceHasher::hashContent($html);
                $hashesEvidencia[] = $hashEvidencia;

                $fotoLocalPath = null;
                if ($downloadPhotos && !empty($parsed['foto_oficial_url'])) {
                    $dest = $this->storagePath . "/raw/photos/colima_leg{$legislatura}_{$id}.jpg";
                    if ($this->http->downloadFile($parsed['foto_oficial_url'], $dest)) {
                        $fotoLocalPath = "storage/raw/photos/colima_leg{$legislatura}_{$id}.jpg";
                    }
                }

                $slugId = "col_leg{$legislatura}_" . str_pad((string)$id, 3, '0', STR_PAD_LEFT);

                $registro = [
                    'referencia_sil' => $slugId,
                    'nombre_completo' => $parsed['nombre_completo'],
                    'camara' => 'Congreso del Estado de Colima',
                    'legislatura' => $legislatura,
                    'partido' => $parsed['partido'],
                    'principio_eleccion' => $parsed['principio_eleccion'],
                    'entidad' => 'Colima',
                    'distrito' => $parsed['distrito'],
                    'tipo_cargo' => 'Propietario',
                    'suplente_nombre' => null,
                    'fecha_toma_protesta' => $cfg['toma_protesta'],
                    'fecha_nacimiento' => null,
                    'correo_institucional' => $parsed['correo'],
                    'telefono' => '(312) 31 2 1159',
                    'ubicacion_oficina' => 'Calzada Galván y los Regalado, Colima, Col.',
                    'ultimo_grado_estudios' => null,
                    'preparacion_academica' => null,
                    'experiencia_legislativa_resumen' => null,
                    'foto_oficial_url' => $parsed['foto_oficial_url'],
                    'foto_local_path' => $fotoLocalPath,
                    'curriculum_url' => $parsed['curriculum_url'],
                    'total_comisiones' => count($parsed['comisiones']),
                    'comisiones' => $parsed['comisiones'],
                    'trayectoria_politica' => [], 'trayectoria_legislativa' => [], 'trayectoria_administrativa' => [],
                    'escolaridad_detalle' => [], 'licencias' => [], 'iniciativas' => [], 'puntos_acuerdo' => [], 'redes_sociales' => [],
                    'metadata' => [
                        'fuente_url' => $url,
                        'sha256_evidencia' => $hashEvidencia,
                        'fecha_extraccion' => $fechaExtraccion,
                        'entidad_tipo' => 'Congreso Local',
                        'node_id' => $nodeId,
                    ],
                ];

                $legisladores[] = $registro;
            } catch (\Throwable $e) {
                $this->logger->error("Error procesando diputado ID {$id} en Leg {$legislatura}: " . $e->getMessage());
            }
        }

        $merkleRoot = EvidenceHasher::computeMerkleRoot($hashesEvidencia);

        $payload = [
            'metadata' => [
                'titulo' => "H. Congreso del Estado de Colima - {$cfg['romano']} Legislatura ({$cfg['periodo']})",
                'entidad' => 'Colima',
                'camara' => 'Congreso Local',
                'legislatura' => $legislatura,
                'periodo' => $cfg['periodo'],
                'generado_en' => date('c'),
                'fuente_url' => self::INDEX_URL,
                'node_id' => $nodeId,
                'total_nodes' => $totalNodes,
                'total_legisladores' => count($legisladores),
                'merkle_root_evidencia' => $merkleRoot,
            ],
            'legisladores' => $legisladores,
        ];

        $outputFile = $this->saveOutput($payload, $legislatura, $nodeId);

        return [
            'ok' => true,
            'legislatura' => $legislatura,
            'node_id' => $nodeId,
            'archivo' => $outputFile,
            'total_procesados' => count($legisladores),
            'merkle_root' => $merkleRoot,
        ];
    }

    /**
     * Consolida los datasets parciales generados por diferentes servidores/nodos.
     */
    public function consolidateNodes(int $legislatura = 61): array
    {
        $cfg = self::LEGISLATURAS_CONFIG[$legislatura] ?? self::LEGISLATURAS_CONFIG[61];
        $stagingDir = $this->storagePath . '/staging/inbox';
        $pattern = $stagingDir . "/congreso_colima_leg_{$legislatura}_node_*.json";
        $files = glob($pattern) ?: [];

        if (empty($files)) {
            return [
                'ok' => false,
                'error' => "No se encontraron archivos de staging para Colima leg {$legislatura} en: {$stagingDir}",
            ];
        }

        $mergedLegisladores = [];
        $allHashes = [];

        foreach ($files as $file) {
            $raw = json_decode((string)file_get_contents($file), true);
            if (!empty($raw['legisladores']) && is_array($raw['legisladores'])) {
                foreach ($raw['legisladores'] as $leg) {
                    $ref = $leg['referencia_sil'] ?? $leg['nombre_completo'];
                    $mergedLegisladores[$ref] = $leg;
                    if (!empty($leg['metadata']['sha256_evidencia'])) {
                        $allHashes[] = $leg['metadata']['sha256_evidencia'];
                    }
                }
            }
        }

        ksort($mergedLegisladores);
        $finalList = array_values($mergedLegisladores);
        $finalMerkle = EvidenceHasher::computeMerkleRoot($allHashes);

        $finalPayload = [
            'metadata' => [
                'titulo' => "H. Congreso del Estado de Colima - {$cfg['romano']} Legislatura ({$cfg['periodo']}) [Consolidado]",
                'entidad' => 'Colima',
                'camara' => 'Congreso Local',
                'legislatura' => $legislatura,
                'periodo' => $cfg['periodo'],
                'generado_en' => date('c'),
                'fuente_url' => self::INDEX_URL,
                'total_legisladores' => count($finalList),
                'nodos_fuente' => count($files),
                'merkle_root_evidencia' => $finalMerkle,
            ],
            'legisladores' => $finalList,
        ];

        $targetDir = $this->storagePath . '/data/json';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $finalFile = $targetDir . "/congreso_colima_leg_{$legislatura}.json";
        file_put_contents($finalFile, json_encode($finalPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $this->logger->info("Consolidación completada exitosamente en {$finalFile} (" . count($finalList) . " legisladores).");

        return [
            'ok' => true,
            'legislatura' => $legislatura,
            'archivo' => $finalFile,
            'total_legisladores' => count($finalList),
            'nodos_consolidados' => count($files),
            'merkle_root' => $finalMerkle,
        ];
    }

    /**
     * Descubre o retorna los IDs oficiales verificados para la legislatura indicada.
     */
    private function discoverTargetsForLeg(int $legislatura, array $fallbackIds): array
    {
        $targets = [];
        foreach ($fallbackIds as $id) {
            $targets[] = ['id' => $id, 'logo' => ''];
        }
        return $targets;
    }

    /**
     * Divide la lista de objetivos para el nodo correspondiente.
     */
    private function partitionTargets(array $targets, int $nodeId, int $totalNodes): array
    {
        $count = count($targets);
        $chunkSize = (int)ceil($count / $totalNodes);
        $offset = ($nodeId - 1) * $chunkSize;

        if ($offset >= $count) {
            return [];
        }

        return array_slice($targets, $offset, $chunkSize);
    }

    /**
     * Parsea el HTML del perfil de un legislador en Colima.
     */
    private function parseDeputyDetail(int $id, string $html, string $logoHint, int $legislatura): ?array
    {
        $nombre = null;
        if (preg_match('/<h4><strong>(?:Dip\.\s*)?([^<]+)<\/strong>/i', $html, $m)) {
            $nombre = trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        }

        if (empty($nombre)) {
            return null;
        }

        $principio = 'Mayoría Relativa';
        if (stripos($html, 'Representación Proporcional') !== false || stripos($html, 'Representaci') !== false) {
            $principio = 'Representación Proporcional';
        }

        $distrito = null;
        if (preg_match('/Distrito:\s*([^,<]+)(?:,\s*([^<]+))?/i', $html, $m)) {
            $distNum = trim($m[1]);
            $distCabecera = isset($m[2]) ? trim(html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5, 'UTF-8')) : '';
            if ($distNum !== '-' && $distNum !== '') {
                $distrito = "Distrito {$distNum}" . ($distCabecera !== '' && $distCabecera !== '-' ? " ({$distCabecera})" : '');
            }
        }

        $partido = $this->resolvePartido($html, $logoHint);

        $correo = null;
        if (preg_match('/class="icofont-email"[^>]*><\/span>\s*([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/i', $html, $m)) {
            $correo = strtolower(trim($m[1]));
        }

        $curriculumUrl = null;
        if (preg_match('/href="([^"]+\.pdf)"[^>]*>Curr&iacute;culum vitae<\/a>/i', $html, $m)) {
            $curriculumUrl = trim($m[1]);
        }

        $fotoUrl = "https://congresocol.gob.mx/web/Sistema/uploads/Diputados/{$id}.JPG";
        if (preg_match('/<img[^>]+id="partidos2"[^>]+src="([^"]+)"/i', $html, $imgM)) {
            $rawImg = trim($imgM[1]);
            if (str_starts_with($rawImg, 'http')) {
                $fotoUrl = $rawImg;
            } elseif (str_starts_with($rawImg, '/')) {
                $fotoUrl = "https://congresocol.gob.mx{$rawImg}";
            } else {
                $fotoUrl = "https://congresocol.gob.mx/web/www/diputados/{$rawImg}";
            }
        }

        $comisiones = [];
        if (preg_match('/<th><font[^>]*>Comisiones<\/font><\/th>.*?<tbody>(.*?)<\/tbody>/is', $html, $tableMatch)) {
            if (preg_match_all('/<tr><td><h4>([^<]+)<br><strong>([^<]+)<\/strong><\/h4><\/td><\/tr>/i', $tableMatch[1], $comMatches, PREG_SET_ORDER)) {
                foreach ($comMatches as $cm) {
                    $comisiones[] = [
                        'nombre' => trim(html_entity_decode($cm[1], ENT_QUOTES | ENT_HTML5, 'UTF-8')),
                        'cargo' => trim(html_entity_decode($cm[2], ENT_QUOTES | ENT_HTML5, 'UTF-8')),
                    ];
                }
            }
        }

        return [
            'nombre_completo' => $nombre,
            'partido' => $partido,
            'principio_eleccion' => $principio,
            'distrito' => $distrito,
            'correo' => $correo,
            'curriculum_url' => $curriculumUrl,
            'foto_oficial_url' => $fotoUrl,
            'comisiones' => $comisiones,
        ];
    }

    private function resolvePartido(string $html, string $logoHint): string
    {
        $src = $logoHint;
        if (preg_match('/<img[^>]+id=[\'"]partidos[\'"][^>]+src=[\'"]([^\'"]+)[\'"]/i', $html, $m)) {
            $src = $m[1];
        }
        $s = strtolower($src);
        if (str_contains($s, 'morena')) return 'MORENA';
        if (str_contains($s, 'verde') || str_contains($s, 'pvem')) return 'PVEM';
        if (str_contains($s, 'nuevaalianza') || str_contains($s, 'panal')) return 'NUEVA ALIANZA';
        if (str_contains($s, 'movimiento') || str_contains($s, 'mc')) return 'MC';
        if (str_contains($s, 'pt')) return 'PT';
        if (str_contains($s, 'pan')) return 'PAN';
        if (str_contains($s, 'pri')) return 'PRI';
        if (str_contains($s, 'pes')) return 'PES';
        if (str_contains($s, 'prd')) return 'PRD';
        return 'SIN PARTIDO';
    }

    private function saveOutput(array $payload, int $legislatura, ?int $nodeId): string
    {
        if ($nodeId !== null) {
            $dir = $this->storagePath . '/staging/inbox';
            $filename = "congreso_colima_leg_{$legislatura}_node_{$nodeId}.json";
        } else {
            $dir = $this->storagePath . '/data/json';
            $filename = "congreso_colima_leg_{$legislatura}.json";
        }

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $fullPath = $dir . '/' . $filename;
        $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents($fullPath, $json);

        $this->logger->info("Archivo guardado con éxito: {$fullPath}");
        return $fullPath;
    }
}
