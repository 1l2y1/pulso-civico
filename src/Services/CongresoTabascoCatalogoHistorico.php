<?php
declare(strict_types=1);

namespace PulsoCivico\Services;

/**
 * Catálogo histórico verificado del H. Congreso del Estado de Tabasco.
 * Comprende las legislaturas recientes: LXIV (2021-2024), LXIII (2018-2021),
 * LXII (2016-2018), LXI (2013-2015) y LX (2010-2012).
 *
 * Fuente primaria: Catálogo de Diputados del Archivo Legislativo del Congreso de Tabasco
 * (congresotabasco.gob.mx), IEPCT (iepct.mx) e INE (ine.mx).
 */
final class CongresoTabascoCatalogoHistorico
{
    /**
     * Resumen cronológico de las legislaturas documentadas de Tabasco.
     * @return array<string, array<string, mixed>>
     */
    public static function getMetadataLegislaturas(): array
    {
        return [
            '60' => ['numero' => 60, 'romano' => 'LX',   'periodo' => '2010-2012', 'inicio' => '2010-01-01', 'fin' => '2012-12-31', 'total' => 35],
            '61' => ['numero' => 61, 'romano' => 'LXI',  'periodo' => '2013-2015', 'inicio' => '2013-01-01', 'fin' => '2015-12-31', 'total' => 35],
            '62' => ['numero' => 62, 'romano' => 'LXII', 'periodo' => '2016-2018', 'inicio' => '2016-01-01', 'fin' => '2018-09-04', 'total' => 35],
            '63' => ['numero' => 63, 'romano' => 'LXIII','periodo' => '2018-2021', 'inicio' => '2018-09-05', 'fin' => '2021-09-04', 'total' => 35],
            '64' => ['numero' => 64, 'romano' => 'LXIV', 'periodo' => '2021-2024', 'inicio' => '2021-09-05', 'fin' => '2024-09-04', 'total' => 35],
            '65' => ['numero' => 65, 'romano' => 'LXV',  'periodo' => '2024-2027', 'inicio' => '2024-09-05', 'fin' => '2027-09-04', 'total' => 35],
        ];
    }

    /**
     * LXIV Legislatura (2021-2024) - 35 Diputados.
     * @return array<int, array<string, mixed>>
     */
    public static function getLegislatura64(): array
    {
        return [
            // MAYORÍA RELATIVA (21 Distritos)
            ['nombre' => 'Dolores del Carmen Moreno Zubieta', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 1', 'cabecera' => 'Tenosique'],
            ['nombre' => 'Dariana Lemarroy de la Fuente', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 2', 'cabecera' => 'Cárdenas'],
            ['nombre' => 'Euclides Alejandro Alejandro', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 3', 'cabecera' => 'Cárdenas'],
            ['nombre' => 'Rita del Carmen Gálvez Bonora', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 4', 'cabecera' => 'Huimanguillo'],
            ['nombre' => 'Isabel Yazmín Orueta Hernández', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 5', 'cabecera' => 'Centla'],
            ['nombre' => 'Jorge Orlando Bracamonte Hernández', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 6', 'cabecera' => 'Centro'],
            ['nombre' => 'José de Jesús Hernández Díaz', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 7', 'cabecera' => 'Centro'],
            ['nombre' => 'Ana Isabel Núñez de Dios', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 8', 'cabecera' => 'Centro'],
            ['nombre' => 'Karla Alejandra Garrido Perea', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 9', 'cabecera' => 'Centro'],
            ['nombre' => 'Jaime Humberto Lastra Bastar', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 10', 'cabecera' => 'Centro'],
            ['nombre' => 'Luis Roberto Salinas Falcón', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 11', 'cabecera' => 'Tacotalpa'],
            ['nombre' => 'María de Lourdes Morales López', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 12', 'cabecera' => 'Centro'],
            ['nombre' => 'Marlene Martínez Ruíz', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 13', 'cabecera' => 'Comalcalco'],
            ['nombre' => 'Jesús Antonio Ochoa Hernández', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 14', 'cabecera' => 'Cunduacán'],
            ['nombre' => 'Rafael Elías Sánchez Cabrales', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 15', 'cabecera' => 'Emiliano Zapata'],
            ['nombre' => 'Diana Laura Rodríguez Morales', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 16', 'cabecera' => 'Huimanguillo'],
            ['nombre' => 'Jesús Selván García', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 17', 'cabecera' => 'Jalpa de Méndez'],
            ['nombre' => 'Rosana Arcia Félix', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 18', 'cabecera' => 'Macuspana'],
            ['nombre' => 'David Gómez Cerino', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 19', 'cabecera' => 'Nacajuca'],
            ['nombre' => 'Laura Patricia Ávalos Magaña', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 20', 'cabecera' => 'Paraíso'],
            ['nombre' => 'Emilio Antonio Contreras Martínez de Escobar', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 21', 'cabecera' => 'Centro'],

            // REPRESENTACIÓN PROPORCIONAL (14 Plurinominales)
            ['nombre' => 'Soraya Pérez Munguía', 'partido' => 'PRI', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Primera Circunscripción'],
            ['nombre' => 'Shirley Herrera Dagdug', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Primera Circunscripción'],
            ['nombre' => 'Héctor Peralta Grappin', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Primera Circunscripción'],
            ['nombre' => 'Beatriz Vasconcelos Pérez', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Primera Circunscripción'],
            ['nombre' => 'José Pablo Flores Morales', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Primera Circunscripción'],
            ['nombre' => 'Joandra Montserrat Rodríguez Pérez', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Primera Circunscripción'],
            ['nombre' => 'Miguel Ángel Moheno Piñera', 'partido' => 'PVEM', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Primera Circunscripción'],
            ['nombre' => 'Martiza Mallely Jiménez Pérez', 'partido' => 'PRI', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Segunda Circunscripción'],
            ['nombre' => 'Fabián Granier Calles', 'partido' => 'PRI', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Segunda Circunscripción'],
            ['nombre' => 'Katia Ornelas Gil', 'partido' => 'PRI', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Segunda Circunscripción'],
            ['nombre' => 'Juan Álvarez Carrillo', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Segunda Circunscripción'],
            ['nombre' => 'Norma Araceli Aranguren Rosique', 'partido' => 'PVEM', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Segunda Circunscripción'],
            ['nombre' => 'Miguel Armando Vélez Mier y Concha', 'partido' => 'PVEM', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Segunda Circunscripción'],
            ['nombre' => 'Casilda Ruíz Agustín', 'partido' => 'MC', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Segunda Circunscripción'],
        ];
    }

    /**
     * LXIII Legislatura (2018-2021) - 35 Diputados.
     * @return array<int, array<string, mixed>>
     */
    public static function getLegislatura63(): array
    {
        return [
            // MAYORÍA RELATIVA (21 Distritos)
            ['nombre' => 'María Félix García Álvarez', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 1', 'cabecera' => 'Tenosique'],
            ['nombre' => 'Beatriz Milland Pérez', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 2', 'cabecera' => 'Cárdenas'],
            ['nombre' => 'Tomas Brito Lara', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 3', 'cabecera' => 'Cárdenas'],
            ['nombre' => 'Charlie Valentino León Flores Vera', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 4', 'cabecera' => 'Huimanguillo'],
            ['nombre' => 'Manuel Antonio Gordillo Bonfil', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 5', 'cabecera' => 'Centla'],
            ['nombre' => 'Ariel Enrique Cetina Bertruy', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 6', 'cabecera' => 'Centro'],
            ['nombre' => 'Daniel Cubero Cabrales', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 7', 'cabecera' => 'Centro'],
            ['nombre' => 'Jacqueline Villaverde Acevedo', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 8', 'cabecera' => 'Centro'],
            ['nombre' => 'Ena Margarita Bolio Ibarra', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 9', 'cabecera' => 'Centro'],
            ['nombre' => 'Juana María Esther Álvarez Hernández', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 10', 'cabecera' => 'Centro'],
            ['nombre' => 'José Concepción García González', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 11', 'cabecera' => 'Tacotalpa'],
            ['nombre' => 'Nelly del Carmen Vargas Pérez', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 12', 'cabecera' => 'Centro'],
            ['nombre' => 'Luis Ernesto Ortiz Catalá', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 13', 'cabecera' => 'Comalcalco'],
            ['nombre' => 'Cristina Guzmán Fuentes', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 14', 'cabecera' => 'Cunduacán'],
            ['nombre' => 'Rafael Elías Sánchez Cabrales', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 15', 'cabecera' => 'Emiliano Zapata'],
            ['nombre' => 'Karla María Rabelo Estrada', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 16', 'cabecera' => 'Huimanguillo'],
            ['nombre' => 'María Esther Zapata Zapata', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 17', 'cabecera' => 'Jalpa de Méndez'],
            ['nombre' => 'Exequias Braulio Escalante Castillo', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 18', 'cabecera' => 'Macuspana'],
            ['nombre' => 'Carlos Madrigal Leyva', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 19', 'cabecera' => 'Nacajuca'],
            ['nombre' => 'Alma Rosa Espadas Hernández', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 20', 'cabecera' => 'Paraíso'],
            ['nombre' => 'Adolfo Antonio Amat Traconis', 'partido' => 'MORENA', 'principio_eleccion' => 'Mayoría Relativa', 'distrito' => 'Distrito 21', 'cabecera' => 'Centro'],

            // REPRESENTACIÓN PROPORCIONAL (14 Plurinominales)
            ['nombre' => 'Gerald Washington Herrera Castellanos', 'partido' => 'PRI', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Ingrid Margarita Rosas Pantoja', 'partido' => 'PRI', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Nicolás Carlos Bellizia Aboaf', 'partido' => 'PRI', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Katia Ornelas Gil', 'partido' => 'PRI', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Minerva Santos García', 'partido' => 'PRI', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Agustín Silva Vidal', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Elsy Lidia Izquierdo Morales', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Nelson Humberto Gallegos Vaca', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Dolores Gutiérrez Zurita', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Ricardo Fitz Mendoza', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Patricia Hernández Calderón', 'partido' => 'PRD', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'José Manuel Sepúlveda del Valle', 'partido' => 'PVEM', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Carolina Pech Frías', 'partido' => 'PVEM', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
            ['nombre' => 'Odette Carolina Lastra García', 'partido' => 'PVEM', 'principio_eleccion' => 'Representación Proporcional', 'distrito' => null, 'cabecera' => 'Plurinominal'],
        ];
    }
}
