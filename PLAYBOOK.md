# React to WordPress Headless — PLAYBOOK MAESTRO

> Proceso completo para convertir un sitio React estático en un sitio headless administrado por WordPress.

---

## Índice

1. [Visión General](#vision-general)
2. [Diagrama de Flujo](#diagrama-de-flujo)
3. [Fase 1: Análisis del Diseño React](./PHASES/PHASE-1-ANALYSIS.md)
4. [Fase 2: OpenSpec Planning](./PHASES/PHASE-2-OPENSPEC.md)
5. [Fase 3: WordPress Backend](./PHASES/PHASE-3-WP-BACKEND.md)
6. [Fase 4: React Frontend](./PHASES/PHASE-4-REACT-FRONTEND.md)
7. [Fase 5: Verificación y QA](./PHASES/PHASE-5-VERIFICATION.md)
8. [Fase 6: E-commerce (Opcional)](./PHASES/PHASE-6-ECOMMERCE.md)
9. [Errores y Soluciones](./LOGS/ERRORS-LOG.md)
10. [Decisiones Técnicas](./LOGS/DECISION-LOG.md)
11. [Lecciones Aprendidas](./LOGS/LESSONS-LEARNED.md)
12. [Estimaciones de Tiempo](./LOGS/TIME-ESTIMATES.md)

---

## Visión General

### ¿Qué resolvemos?

Los sitios React hechos con IA a travez de su webchat, como por ejemplo: Kimi o Claude tienen todo el contenido **hardcodeado** en el código. Esto significa que cualquier cambio de texto, imagen o estadística requiere un desarrollador.

**Solución:** Conectar el frontend React con WordPress como CMS headless, permitiendo que el equipo de marketing/negocio edite todo el contenido desde el admin de WordPress.

### Arquitectura

```
┌─────────────────┐     REST API      ┌──────────────────┐
│                 │ ◄─────────────────│                  │
│   React App     │    JSON + Meta    │   WordPress      │
│   (Vite/Next)   │                   │   (CMS Headless) │
│                 │──────────────────►│                  │
└─────────────────┘   fetch()         └──────────────────┘
       │                                         │
       │                                         │
       │ GSAP Animations                         │ Metabox Admin
       │ Tailwind CSS                            │ Media Frame
       │ TypeScript                              │ Repeaters
       └─────────────────────────────────────────┘
                        Contenido editable
```

### Flujo de trabajo

1. **Diseño React** → Análisis de secciones y contenido estático
2. **WordPress** → Registro de meta campos + metabox admin
3. **REST API** → Exposición de meta campos (`show_in_rest`)
4. **React Hook** → `useHomeData()` consume la API
5. **Componentes** → Props dinámicas con fallback al texto original
6. **Deploy** → Build de producción + WordPress online

---

## Diagrama de Flujo

Ver archivo: [`DIAGRAMS/flowchart-general.mmd`](./DIAGRAMS/flowchart-general.mmd)

O ver la versión renderizada en [diagrams.net](https://app.diagrams.net/) importando el archivo `.mmd`.

---

## Flujo Detallado

### Paso 0: Setup Inicial

Antes de empezar cualquier proyecto, asegurarse de tener:

- [ ] WordPress instalado y corriendo (local o remoto)
- [ ] Proyecto React clonado o creado
- [ ] OpenCode CLI instalado con skills de OpenSpec
- [ ] Node.js 20+ y npm instalados
- [ ] `agent-browser` instalado globalmente (`npm install -g agent-browser`)

### Paso 1: Análisis (1-2h)

**Objetivo:** Entender qué contenido del React es estático y cómo mapearlo a meta campos de WordPress.

**Acciones:**
1. Listar todas las secciones del sitio (Hero, Services, About, etc.)
2. Identificar todo texto estático en cada componente
3. Detectar imágenes, videos y SVGs
4. Identificar listas dinámicas (servicios, pasos, proyectos, stats)
5. Documentar animaciones (GSAP, Framer Motion, etc.)
6. Crear tabla de mapeo: texto estático → clave de meta campo

**Entregable:** Documento de mapeo (`MAPPING.md`) o tabla en el change de OpenSpec.

Ver detalle: [PHASE-1-ANALYSIS.md](./PHASES/PHASE-1-ANALYSIS.md)

### Paso 2: OpenSpec Planning (2-3h)

**Objetivo:** Crear la especificación formal del change con OpenSpec.

**Acciones:**
1. Crear change con `openspec new change "nombre-del-proyecto"`
2. Generar artifacts en orden:
   - `proposal.md` — ¿Por qué y qué?
   - `design.md` — Decisiones técnicas
   - `specs/` — Capabilities y requerimientos
   - `tasks.md` — Micro-tareas desglosadas
3. Esperar aprobación del usuario antes de ejecutar tareas
4. Aplicar change con `/opsx-apply`

**Regla de oro:** Nunca ejecutar tareas sin el OK explícito del usuario.

Ver detalle: [PHASE-2-OPENSPEC.md](./PHASES/PHASE-2-OPENSPEC.md)

### Paso 3: WordPress Backend (4-6h)

**Objetivo:** Construir el panel de administración nativo en WordPress.

**Acciones:**
1. Identificar tema activo de WordPress
2. Crear plantilla `home-template.php` en el tema
3. Crear/identificar página de inicio y asignarle la plantilla
4. Crear mu-plugin con:
   - `register_post_meta()` por cada sección
   - JSON Schema estricto para cada campo
   - `show_in_rest => true` para exposición REST API
5. Implementar metabox "Contenido del Home" con:
   - Campos por sección (text, textarea, number, url)
   - WordPress Media Frame para imágenes
   - Repeaters dinámicos con JS vanilla
   - Selects para opciones predefinidas (íconos, etc.)
6. Implementar `save_post` con sanitización completa
7. Configurar CORS para desarrollo (Vite en localhost:5173)
8. Poblar datos iniciales desde el contenido estático del React

**Archivos clave:**
- `wp-content/mu-plugins/{PREFIX}-home-meta.php`
- `wp-content/themes/{THEME}/home-template.php`

Ver detalle: [PHASE-3-WP-BACKEND.md](./PHASES/PHASE-3-WP-BACKEND.md)

### Paso 4: React Frontend (3-4h)

**Objetivo:** Adaptar el frontend para consumir datos dinámicos de WordPress.

**Acciones:**
1. Crear tipos TypeScript para todos los meta campos
2. Implementar hook `useHomeData()`:
   - `fetch()` al endpoint REST de WordPress
   - Estados: `loading`, `error`, `data`
   - Fallback al texto estático original si un campo está vacío
3. Modificar `App.tsx` para usar el hook y pasar datos por props
4. Refactorizar cada sección para recibir props del meta
5. Preservar todas las animaciones (GSAP, etc.)
6. Configurar `.env` con `VITE_WP_API_URL`

**Regla de oro:** Cada componente debe tener un fallback al texto estático original.

**Archivos clave:**
- `src/types/home-meta.ts`
- `src/hooks/useHomeData.ts`
- `src/App.tsx`
- `src/sections/*.tsx` (modificados)

Ver detalle: [PHASE-4-REACT-FRONTEND.md](./PHASES/PHASE-4-REACT-FRONTEND.md)

### Paso 5: Verificación (2-3h)

**Objetivo:** Asegurar que todo funciona correctamente antes de entregar.

**Acciones:**
1. Ejecutar `npm run build` — debe pasar sin errores de TypeScript
2. Verificar REST API devuelve datos correctos (via curl o navegador)
3. Levantar servidor de desarrollo (`npm run dev`)
4. Tomar screenshots con `agent-browser` para verificar diseño
5. Editar un campo desde WordPress y verificar cambio en React
6. Probar fallback: vaciar un campo y verificar texto original aparece
7. Verificar responsive y accesibilidad
8. Verificar que animaciones GSAP funcionan con datos dinámicos

**Herramientas:**
- `agent-browser screenshot` — Screenshots visuales
- `agent-browser snapshot` — Estructura del DOM
- `curl` o navegador — Validar REST API

Ver detalle: [PHASE-5-VERIFICATION.md](./PHASES/PHASE-5-VERIFICATION.md)

### Paso 6: E-commerce (Opcional, 2-4h)

**Objetivo:** Si el proyecto incluye tienda online, integrar WooCommerce.

**Acciones:**
1. Instalar WooCommerce en WordPress
2. Crear meta campos personalizados para productos
3. Consumir WooCommerce REST API desde React
4. Implementar carrito y checkout headless
5. Integrar pasarela de pago (Stripe, MercadoPago, etc.)

Ver detalle: [PHASE-6-ECOMMERCE.md](./PHASES/PHASE-6-ECOMMERCE.md)

---

## Convenciones de Nomenclatura

### Meta Campos
```
{PREFIX}_{SECTION}

Ejemplos:
- wetheme_hero
- wetheme_rooms
- wetheme_surf_info
- acme_hero
- acme_services
```

### Plantillas
```
{SECTION}-template.php

Ejemplos:
- home-template.php
- landing-template.php
- product-template.php
```

### Mu-plugins
```
{PREFIX}-home-meta.php

Ejemplos:
- wetheme-home-meta.php
- acme-home-meta.php
```

---

## Reglas de Oro

1. **Nunca modificar el diseño visual del React.** El objetivo es mantener el 100% del diseño original.
2. **Siempre usar fallback.** Si un campo meta está vacío, mostrar el texto estático original.
3. **No usar ACF.** Todo nativo: `register_post_meta`, `add_meta_box`, `wp.media`.
4. **Sanitizar todo.** `sanitize_text_field`, `esc_url_raw`, `absint`, `sanitize_textarea_field`.
5. **Esperar OK del usuario.** En OpenSpec, nunca ejecutar tareas sin aprobación.
6. **Documentar errores.** Cada error que ocurre se registra en `ERRORS-LOG.md`.
7. **Verificar con agent-browser.** Screenshots visuales antes de dar por terminado.

---

## Próximos Pasos

¿Empezando un nuevo proyecto? Sigue este orden:

1. Abre [PHASE-1-ANALYSIS.md](./PHASES/PHASE-1-ANALYSIS.md)
2. Completa el checklist de análisis
3. Continúa con [PHASE-2-OPENSPEC.md](./PHASES/PHASE-2-OPENSPEC.md)
4. Y así sucesivamente...

---

**¿Necesitas ayuda?** Revisa los logs:
- [Errores comunes y soluciones](./LOGS/ERRORS-LOG.md)
- [Decisiones técnicas con rationale](./LOGS/DECISION-LOG.md)
- [Lecciones aprendidas](./LOGS/LESSONS-LEARNED.md)
