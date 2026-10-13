# Issue #16: data(scraper) - Scraper y dataset auditado del Congreso del Estado de Campeche (LXV Legislatura)

**Estado:** 🚧 EN PROGRESO  
**Proyecto GitHub:** Scrapers y Cobertura Estatal  
**Rama:** `data/congreso-campeche`  
**Responsable:** Scrapers / Extracción de Datos  

---

## 1. Contexto y Justificación
El Estado de Campeche es la entidad federativa 04 en la cobertura nacional de Pulso Cívico.
El H. Congreso del Estado de Campeche inició su **LXV Legislatura (2024–2027)** el 1 de octubre de 2024, conformada por **35 diputadas y diputados** (21 electos por Mayoría Relativa en los distritos uninominales I a XXI y 14 asignados por Representación Proporcional por el Instituto Electoral del Estado de Campeche, IEEC).

## 2. Requerimientos Técnicos
1. **Catálogo oficial verificado (`src/Services/CongresoCampecheCatalogoActual.php`):**
   - 35 diputados con nombres oficiales, principios (MR/RP), distritos/cabeceras, partidos políticos, correos y suplentes oficiales.
   - Fuentes de validación cruzada: Portal oficial `congresocam.gob.mx` y Acuerdo del Consejo General del IEEC **CG/116/2024**.
2. **Servicio Scraper (`src/Services/CongresoCampecheScraperService.php`):**
   - PHP nativo sin dependencias externas.
   - Rate limit >= 1000ms.
   - Generación de hashes de evidencia SHA-256 inmutables por cada registro.
   - Guardado en `storage/data/json/congreso_campeche_leg_65.json`.
3. **Registro CLI en `tools/core/ScraperRouter.php`:**
   - Comando `cam` / `campeche`: `powershell -ExecutionPolicy Bypass -File .\tools\run.ps1 scrape cam`.
4. **Actualización de documentación:**
   - Marcar Campeche como completado en `docs/ESTADOS_COBERTURA.md`.

## 3. Criterios de Aceptación
- [ ] Dataset generado con 35 diputados íntegros y válidos en `storage/data/json/congreso_campeche_leg_65.json`.
- [ ] 100% de los registros con `fuente_url` oficial (`congresocam.gob.mx` o `ieec.org.mx`).
- [ ] `powershell -File .\tools\run.ps1 lint "src/Services/CongresoCampecheScraperService.php,src/Services/CongresoCampecheCatalogoActual.php"` pasa sin errores (0 errores).
- [ ] PR sometido a GitHub sin mezclar código no relacionado.
