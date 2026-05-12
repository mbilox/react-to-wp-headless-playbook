## ADDED Requirements

### Requirement: Análisis completo del sitio React
El proceso SHALL analizar un sitio React estático y producir un documento de mapeo que identifique todas las secciones, texto estático, assets, listas dinámicas y animaciones.

#### Scenario: Listado de secciones
- **WHEN** un usuario ejecuta el análisis sobre un proyecto React
- **THEN** el sistema MUST listar todos los archivos en `src/sections/`, `src/pages/` y `src/components/`
- **AND** identificar cuáles son componentes de sección vs componentes UI

#### Scenario: Extracción de texto estático
- **WHEN** se identifican las secciones del sitio
- **THEN** el sistema MUST extraer todo texto hardcodeado (strings entre comillas)
- **AND** clasificar cada texto por componente y tipo (título, subtítulo, CTA, label)

#### Scenario: Detección de assets
- **WHEN** se analiza el proyecto
- **THEN** el sistema MUST detectar todas las imágenes, videos y SVGs
- **AND** clasificarlos por tipo (backgrounds, logos, icons, galerías)

#### Scenario: Identificación de listas dinámicas
- **WHEN** se examinan los componentes
- **THEN** el sistema MUST identificar todos los arrays de datos (servicios, pasos, proyectos, stats)
- **AND** documentar la estructura de cada elemento del array

#### Scenario: Documentación de animaciones
- **WHEN** se analizan las dependencias y el código
- **THEN** el sistema MUST identificar librerías de animación usadas (GSAP, Framer Motion, etc.)
- **AND** documentar qué animaciones dependen del contenido dinámico

### Requirement: Tabla de mapeo
El proceso SHALL producir una tabla de correspondencia entre texto estático y claves de meta campos.

#### Scenario: Mapeo completo
- **WHEN** se completan todos los pasos de análisis
- **THEN** el sistema MUST generar una tabla con: Componente | Texto Estático | Clave Meta | Tipo
- **AND** agrupar las claves meta en 3-5 campos principales por sección

#### Scenario: Estructura de meta campos definida
- **WHEN** se completa el mapeo
- **THEN** el sistema MUST definir la estructura JSON de cada meta campo
- **AND** especificar el tipo de cada propiedad (string, number, array, object)

## Validation Rules

- [ ] Todas las secciones del sitio están listadas
- [ ] Todo texto estático está extraído y clasificado
- [ ] Todos los assets están identificados y categorizados
- [ ] Todas las listas dinámicas están documentadas con su estructura
- [ ] Las animaciones están documentadas y se indica si dependen del contenido
- [ ] La tabla de mapeo tiene correspondencia 1:1 entre texto y clave meta
- [ ] Los meta campos están agrupados en 3-5 campos principales (no uno por string)

## Templates

- **Entregable:** `MAPPING.md` o tabla en el change de OpenSpec
- **Estructura esperada:** Ver `PHASES/PHASE-1-ANALYSIS.md`
- **Ejemplo:** Ver proyecto WE Digital (theme-wordpress2)