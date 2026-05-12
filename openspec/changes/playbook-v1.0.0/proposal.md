## Why

Los sitios React tienen todo el contenido hardcodeado. Cualquier cambio requiere un desarrollador. Este playbook documenta y automatiza el proceso de conectar cualquier sitio React con WordPress como CMS headless, permitiendo que equipos de marketing editen contenido sin tocar código.

**Problema que resolvemos:**
- Sitio React estático → WordPress admin editable
- 100% nativo (sin ACF)
- Animaciones preservadas
- Fallbacks para migración gradual

## What Changes

- [ ] Documentación completa del proceso (6 fases)
- [ ] Templates parametrizados (PHP, JS, CSS, TSX, TS)
- [ ] Starters listos para copiar
- [ ] Specs OpenSpec para cada fase como capability
- [ ] Skill de OpenCode para automatización completa
- [ ] Checklists y logs de errores/lecciones

## Capabilities

### New Capabilities
- `process-analysis`: Analizar sitio React y producir mapeo de contenido
- `openspec-planning`: Crear change de OpenSpec con proposal/design/specs/tasks
- `wp-backend`: Construir backend WP con meta campos, metabox y REST API
- `react-frontend`: Adaptar frontend React para consumir datos dinámicos
- `verification-qa`: Verificar build, REST API, diseño y animaciones
- `ecommerce`: Integrar WooCommerce (opcional)
- `playbook-maintenance`: Auditar, verificar y mejorar el playbook mismo

### Modified Capabilities
- *(Ninguna — playbook nuevo)*

## Impact

- **Usuarios del playbook**: Desarrolladores y equipos que necesitan convertir React → WP headless
- **Proyectos**: Cualquier sitio React (Vite/Next) + WordPress 6.9+
- **Tiempo estimado**: 12-18h por proyecto (usando el playbook)
- **ROI**: Cada proyecto reduce tiempo de setup en un 70% respecto a hacerlo desde cero