# 🇲🇽 Pulso Cívico

**Plataforma ciudadana y de código abierto para la transparencia política en México.**

Cruzamos **datos oficiales del gobierno** con **noticias** para mostrar el historial real de cada representante popular: qué iniciativas presentan, cómo votan en el pleno, su trayectoria partidista y el fenómeno del "chapulineo". Nuestro único objetivo: facilitar el **voto informado**.

> **Proyecto *Civic Tech* colaborativo, 100% neutral y auditable**: todo dato presentado proviene directamente de una fuente oficial enlazada. No publicamos opiniones, juicios de valor ni datos sin sustento.

---

## 🧭 Contexto y Misión: ¿Por qué existe este proyecto?

En México, la información legislativa y partidista está dispersa, enterrada en gacetas en formato PDF difícil de leer o en páginas gubernamentales poco accesibles para la ciudadanía. Esto genera:
- Desconexión entre los ciudadanos y el trabajo de sus representantes.
- Desconocimiento del sentido real de las votaciones en reformas clave.
- Pérdida de memoria histórica cuando los políticos cambian de partido ("chapulines") o de curul sin rendir cuentas.

**Pulso Cívico** busca cerrar esta brecha: consolidar la información en un portal rápido, claro y neutral donde cualquier persona pueda auditar a los legisladores de su distrito o estado en segundos.

---

## 💡 Filosofía Técnica: ¿Por qué está hecho así?

Muchos colaboradores llegan esperando stacks tradicionales con bases de datos relacionales (MySQL/PostgreSQL) o frameworks pesados (Laravel, Next.js, etc.). **Nuestra arquitectura es una decisión de diseño intencional:**

1. **PHP 8.1+ nativo (Zero-Framework, Zero-Composer)**:
   - Permite que cualquier voluntario descargue el proyecto y lo corra en 2 minutos con el servidor integrado de PHP o en XAMPP, sin lidiar con versiones rotas de paquetes ni configuraciones complejas de entorno.
2. **Archivos JSON como base de datos (`storage/data/json/`)**:
   - Todo el dataset vive directamente en el repositorio.
   - Permite versionar los datos con Git (podemos rastrear exactamente qué cambió, cuándo y en qué commit).
   - Elimina costos de base de datos en servidores: el sitio puede desplegarse en cualquier hosting económico o compartido.
3. **Frontend nativo con Bootstrap 5 (CDN) + Vanilla JS**:
   - Sin pasos de compilación ni `npm install` pesados. El código que ves es el código que se ejecuta.
4. **Respeto a los servidores públicos (Rate Limiting)**:
   - Nuestros scrapers operan de forma responsable: procesan datos con pausas (`rate_limit_ms >= 1000`) y almacenan copias locales en crudo (`storage/raw/`) para no saturar los sitios del gobierno.

---

## 🗺️ Flujo de Datos (Cómo funciona el sistema)

```
[Portales Oficiales (Diputados, Congresos)]
                   │
                   ▼ (Scrapers en PHP / Extracción asistida con IA)
    [storage/raw/] (Caché local de HTML/JSON/PDF)
                   │
                   ▼ (Normalización a contratos DTO)
    [storage/data/json/] (Datasets maestros versionados en Git)
                   │
                   ▼ (Router, Controllers & ViewHelper)
        [Vistas Web / Pulso Cívico (Bootstrap + Vanilla JS)]
```

---

## ✨ Qué hay disponible hoy

- **Legislatura Federal (LXVI 2024–2027)**:
  - Directorio completo de 500 diputados federales (trayectoria, comisiones, escolaridad y fotos).
  - Votaciones nominales de reformas y dictámenes en el pleno.
  - Registro de asistencias a sesiones ordinarias.
- **Visualización y Consulta**:
  - Mapa interactivo de la República Mexicana por estado.
  - Buscador rápido con atajo de teclado (`Ctrl+K`).
  - Exploración por comisiones legislativas y estudios estadísticos de integración partidista.

---

## 🎯 ¿Cómo puedes ayudar? (Rutas según tu perfil)

¡No necesitas ser un desarrollador senior para aportar! Consulta la matriz para encontrar la mejor forma de sumarte:

| Tu perfil | ¿En qué puedes colaborar hoy? | Guía de referencia |
|---|---|---|
| **💻 Desarrollador PHP / Web** | Construir scrapers para Congresos locales pendientes, mejorar vistas o afinar utilidades CLI. | [docs/COMO_CREAR_UN_SCRAPER.md](docs/COMO_CREAR_UN_SCRAPER.md) y [docs/ARQUITECTURA.md](docs/ARQUITECTURA.md) |
| **🤖 Usuario de Asistentes IA** (Cursor, Claude, Copilot, Codex) | Extraer datos de portales legislativos estatales siguiendo el Playbook guiado. | [AGENTS.md](AGENTS.md) y [docs/PLAYBOOK_LOCALES.md](docs/PLAYBOOK_LOCALES.md) |
| **📊 Investigador / Ciudadano** | Revisar los datos de los legisladores de tu estado, verificar fuentes o reportar datos erróneos. | [docs/FUENTES.md](docs/FUENTES.md) y [CONTRIBUTING.md](CONTRIBUTING.md) |
| **🎨 Diseñador / UX** | Mejorar la experiencia móvil (*mobile-first*), accesibilidad y visualizaciones interactivas. | [CONTRIBUTING.md](CONTRIBUTING.md) |
| **📰 Periodista** | Cruzar notas periodísticas verificadas con votaciones o trayectorias específicas. | [docs/DATA_SCHEMA.md](docs/DATA_SCHEMA.md) |

---

## 🚀 Instalación en 5 minutos

**Requisitos mínimos:** PHP 8.1+ con extensiones `curl`, `mbstring` y `json` habilitadas.

### Opción A — Servidor integrado de PHP (Linux, macOS o Windows)
```bash
git clone https://github.com/pulso-civico/pulso-civico.git
cd pulso-civico
cp .env.example .env
php -S localhost:8000
```
Abre tu navegador en: `http://localhost:8000`

### Opción B — XAMPP (Windows)
1. Clona el repositorio dentro de tu carpeta `htdocs`: `C:\xampp\htdocs\pulso-civico`.
2. Copia `.env.example` como `.env`.
3. Abre en tu navegador: `http://localhost/pulso-civico/`

---

## 🛠️ Comandos de Verificación (CLI)

El proyecto incluye un punto de entrada centralizado para validar la salud y sintaxis:

```bash
# Ayuda y lista de comandos disponibles
php tools/gateway.php help

# Validar sintaxis de archivos antes de un PR
php tools/gateway.php lint "src/Controllers/DiputadosController.php"

# Diagnóstico de salud general del proyecto
php tools/gateway.php health
```

> **En Windows (PowerShell):** Puedes usar el runner rápido:  
> `powershell -ExecutionPolicy Bypass -File .\tools\run.ps1 health`

---

## 📚 Mapa de Documentación

| Documento | Propósito |
|---|---|
| [CONTRIBUTING.md](CONTRIBUTING.md) | Guía de contribución, flujo de PRs y mensajes de commit |
| [AGENTS.md](AGENTS.md) | **Reglas críticas para IAs** (Cursor, Claude Code, Copilot, Gemini) |
| [docs/ARQUITECTURA.md](docs/ARQUITECTURA.md) | Estructura interna del código y separación de capas |
| [docs/DATA_SCHEMA.md](docs/DATA_SCHEMA.md) | Estructura y especificación de los archivos JSON |
| [docs/PLAYBOOK_LOCALES.md](docs/PLAYBOOK_LOCALES.md) | Metodología para extraer Congresos locales asistido con IA |
| [docs/FUENTES.md](docs/FUENTES.md) | Directorio de portales oficiales: estados cubiertos vs. pendientes |
| [docs/COMO_CREAR_UN_SCRAPER.md](docs/COMO_CREAR_UN_SCRAPER.md) | Tutorial paso a paso para programar un scraper nuevo |
| [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) | Código de conducta, neutralidad y convivencia |
| [SECURITY.md](SECURITY.md) | Política para el reporte responsable de vulnerabilidades |

---

## 🤝 Comunidad y Participación

- **Issues abiertos**: Revisa la pestaña de *Issues* en GitHub (busca la etiqueta `good first issue` o `fuente-nueva`).
- **Propuestas**: Si tienes una idea para mejorar el proyecto, abre un Issue para discutirla antes de enviar un cambio grande de código.

---

## ⚖️ Licencias

- **Código fuente:** [AGPL-3.0](LICENSE) — software libre con garantía de reciprocidad (si lo mejoras o lo ofreces en red, las mejoras deben ser abiertas).
- **Datasets y datos generados:** [CC BY 4.0](DATA_LICENSE.md) — datos abiertos para libre uso, citando a "Pulso Cívico" y la fuente oficial correspondiente.
