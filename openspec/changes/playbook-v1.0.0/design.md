## Context

El playbook `react-to-wp-headless-playbook` documenta el proceso completo para convertir sitios React estáticos en sitios headless con WordPress como CMS. Surge del proyecto WE Digital (theme-wordpress2) y busca ser reusable para cualquier proyecto similar.

## Goals / Non-Goals

**Goals:**
- [ ] Documentar 6 fases del proceso con detalle ejecutable
- [ ] Proveer templates parametrizados (con placeholders {PREFIX}, {CLIENT}, {SLUG})
- [ ] Proveer starters de código listos para copiar
- [ ] Registrar errores comunes y sus soluciones
- [ ] Registrar decisiones técnicas con rationale
- [ ] Crear specs OpenSpec para cada fase como capability reusable
- [ ] Crear skill de OpenCode para automatización del proceso

**Non-Goals:**
- No modificar el diseño visual del React original
- No implementar autenticación JWT (meta campos públicos)
- No migrar assets a WordPress media library (URLs manejadas via meta campos)
- No soportar multi-idioma en la v1.0

## Decisions

### 1. Mu-plugin vs Plugin Regular
**Decision:** Mu-plugin (`wp-content/mu-plugins/`)
**Rationale:** Siempre activo, sin necesidad de activación manual. Apropiado para funcionalidades críticas.
**Alternativa:** Plugin regular → Requiere activación manual, puede desactivarse por error.

### 2. Meta Campos: Agrupados vs Simples
**Decision:** Tres meta campos de tipo objeto JSON (`{PREFIX}_hero`, `{PREFIX}_rooms`, `{PREFIX}_surf_info`)
**Rationale:** Menos registros en DB, agrupación lógica por sección, JSON Schema anidado más limpio.
**Alternativa:** Un campo por string → Docenas de registros, complicado de mantener.

### 3. Metabox: Nativo vs ACF
**Decision:** 100% nativo (`add_meta_box()` + JS vanilla + Media Frame)
**Rationale:** Sin dependencias, control total, sin costo de licencia. El usuario pidió explícitamente no usar ACF.
**Alternativa:** ACF Pro → Más rápido pero depende de plugin de terceros.

### 4. Frontend: Fetch Nativo vs Librerías
**Decision:** `fetch` nativo con hook custom `useHomeData()`
**Rationale:** Sin dependencias adicionales, bundle más pequeño. Suficiente para un solo endpoint.
**Alternativa:** React Query → Overkill para este alcance.

### 5. Fallbacks
**Decision:** Cada componente usa texto estático original como fallback
**Rationale:** Sitio nunca se ve roto, permite migración gradual.
**Alternativa:** Renderizar null → Peor UX durante transición.

### 6. Detección por Template
**Decision:** Crear `home-template.php` y detectar por `get_page_template_slug()`
**Rationale:** Más robusto y portable que ID fijo o slug.
**Alternativa:** ID fijo → Frágil si se borra y recrea la página.

## Risks / Trade-offs

- **[Risk]** CORS en desarrollo local → Mitigation: Headers CORS en mu-plugin
- **[Risk]** Schema JSON rígido → Mitigation: `additionalProperties: true`
- **[Risk]** Metabox nativo requiere más código → Mitigation: Templates reutilizables
- **[Risk]** El playbook puede quedar desactualizado → Mitigation: Specs de mantenimiento con tareas de auditoría

## Migration Plan

1. v1.0.0: Proceso base (6 fases, templates, starters)
2. v1.1.0: Multi-idioma, custom post types
3. v2.0.0: WooCommerce completo, GraphQL opcional

## Open Questions

1. **¿Soportar Next.js además de Vite?**
   - Respuesta: Por ahora solo Vite. Next.js requiere adaptaciones (SSR, API routes).
2. **¿Soportar TypeScript en el mu-plugin?**
   - Respuesta: No. PHP nativo para compatibilidad máxima.
3. **¿Incluir tests automatizados?**
   - Respuesta: En v1.1.0. Por ahora verificación manual con agent-browser.