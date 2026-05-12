---
name: react-to-wp-headless
description: >
  Convierte cualquier sitio React estático en un sitio headless
  administrado por WordPress. Proceso completo: análisis → OpenSpec
  → WP Backend → React Frontend → Verificación. Todo nativo, sin ACF.
license: MIT
compatibility: Requires OpenCode with OpenSpec support.
metadata:
  author: Bilox
  version: "1.0.0"
  playbook_path: ./react-to-wp-headless-playbook
  based_on: WE Digital (theme-wordpress2)
  phases:
    - process-analysis
    - openspec-planning
    - wp-backend
    - react-frontend
    - verification-qa
    - ecommerce
---

Convierte un sitio React estático en WordPress headless.

**Proceso completo en 6 fases:**
1. **Análisis** — Detectar secciones, texto estático, assets
2. **OpenSpec** — Crear change con specs, design y tasks
3. **WP Backend** — Mu-plugin, metabox, REST API
4. **React Frontend** — Hook useHomeData, props, fallbacks
5. **Verificación** — Build, screenshots, validación
6. **E-commerce** — WooCommerce (opcional)

**Reglas de oro:**
- No modificar diseño visual
- Siempre usar fallbacks al texto original
- 100% nativo (sin ACF)
- Sanitizar todo
- Documentar errores

---

**Input**: Usuario ejecuta `/react-to-wp-headless` en cualquier proyecto.

**Steps**

1. **Detectar contexto del proyecto**

   Verificar si el proyecto actual es:
   - **Nuevo**: No hay React ni WordPress configurados
   - **React existente**: Hay `package.json` con React/Vite
   - **WordPress existente**: Hay `wp-config.php` o estructura WP
   - **Ambos**: Proyecto híbrido ya iniciado

   ```bash
   # Detectar React
   ls package.json src/App.tsx 2>/dev/null
   
   # Detectar WordPress
   ls wp-config.php wp-content/ 2>/dev/null
   ```

2. **Leer playbook y detectar fase actual**

   Leer archivos del playbook para entender el proceso:
   ```bash
   cat react-to-wp-headless-playbook/PLAYBOOK.md
   cat react-to-wp-headless-playbook/PHASES/PHASE-1-ANALYSIS.md
   ```

   Detectar en qué fase está el proyecto:
   - ¿Existe `MAPPING.md`? → Fase 1 completa
   - ¿Existe `openspec/changes/`? → Fase 2 completa
   - ¿Existe mu-plugin en WordPress? → Fase 3 completa
   - ¿Existe `src/hooks/useHomeData.ts`? → Fase 4 completa
   - ¿Build pasó sin errores? → Fase 5 completa

3. **Sugerir siguiente acción**

   Basado en la fase detectada, mostrar al usuario:
   
   ```
   ┌─────────────────────────────────────────────┐
   │  React to WordPress Headless — Skill v1.0  │
   └─────────────────────────────────────────────┘
   
   Estado detectado: [Fase X completada / Proyecto nuevo]
   
   Próximo paso recomendado: [Acción]
   
   Opciones:
   1. Continuar con la fase actual
   2. Ver todo el proceso
   3. Saltar a una fase específica
   4. Auditar playbook (mantenimiento)
   ```

4. **Ejecutar fase seleccionada**

   **Fase 1: Análisis**
   - Listar secciones del React: `glob src/sections/**/*.{tsx,jsx}`
   - Extraer texto estático: `grep -r "\"[A-Z]" src/sections/`
   - Detectar assets: `ls public/ src/assets/`
   - Generar `MAPPING.md` con tabla de correspondencia
   - Preguntar prefijo para meta campos: `{PREFIX}`

   **Fase 2: OpenSpec Planning**
   - Ejecutar: `openspec new change "nombre-del-proyecto"`
   - Generar proposal.md con contexto del proyecto actual
   - Generar design.md con decisiones estándar
   - Generar specs/ basadas en el mapeo de Fase 1
   - Generar tasks.md desglosadas
   - Esperar aprobación del usuario antes de continuar

   **Fase 3: WordPress Backend**
   - Preguntar ruta de WordPress (si no está detectada)
   - Crear `home-template.php` en tema activo
   - Crear mu-plugin con placeholders reemplazados:
     - `{PREFIX}` → prefijo elegido
     - `{CLIENT}` → nombre del cliente/proyecto
     - `{SLUG}` → slug de la página de inicio
   - Asignar plantilla a página de inicio
   - Poblar datos iniciales desde contenido estático del React
   - Verificar REST API: `curl http://localhost:8882/wp-json/wp/v2/pages?slug={SLUG}`

   **Fase 4: React Frontend**
   - Crear `src/types/home-meta.ts` con interfaces
   - Crear `src/hooks/useHomeData.ts`
   - Modificar `App.tsx` para usar el hook
   - Refactorizar cada sección con props y fallbacks
   - Configurar `.env` con `VITE_WP_API_URL`
   - Verificar build: `npm run build`

   **Fase 5: Verificación**
   - Build de producción
   - Verificar REST API devuelve datos correctos
   - Levantar servidor: `npm run dev`
   - Tomar screenshots con agent-browser
   - Editar campo desde WordPress y verificar cambio en React
   - Probar fallback: vaciar campo y verificar texto original
   - Verificar animaciones GSAP
   - Verificar responsive

   **Fase 6: E-commerce (Opcional)**
   - Solo si el usuario lo solicita explícitamente
   - Instalar WooCommerce
   - Configurar productos
   - Consumir WooCommerce REST API desde React

5. **Marcar progreso**

   Después de cada fase, actualizar estado:
   - Marcar tareas completadas en `tasks.md`
   - Guardar en memoria persistente: fase actual, ruta de WP, prefijo, slug
   - Mostrar resumen de lo completado

6. **Ofrecer siguiente paso o finalizar**

   Si quedan fases pendientes:
   - "Fase X completada. ¿Continuamos con Fase Y?"
   
   Si todo está completo:
   - "¡Proceso completo! ¿Querés archivar el change?"
   - Sugerir: `/opsx-archive nombre-del-change`

**Output**

Al iniciar:
```
## React to WordPress Headless — Skill v1.0

Proyecto detectado: [React/Vite en C:/proyectos/mi-sitio]
WordPress detectado: [Sí/No]
Fase actual: [1-5 / Nuevo]

Próximo paso: [Acción recomendada]

Para continuar, decime:
- "Continuar" → Ejecuto la siguiente fase
- "Ver proceso" → Muestro todas las fases
- "Saltar a fase X" → Voy directo a esa fase
- "Auditar" → Verifico que el playbook esté completo
```

Al completar una fase:
```
## Fase X Completada ✓

Completado:
- [x] Tarea 1
- [x] Tarea 2
- [x] Tarea 3

Archivos creados/modificados:
- path/to/file1
- path/to/file2

¿Continuamos con la Fase Y?
```

**Guardrails**

- Siempre preguntar antes de modificar archivos existentes
- Siempre usar fallback al texto original en componentes React
- Nunca ejecutar tareas sin aprobación del usuario (regla de OpenSpec)
- Si WordPress no está instalado, ofrecer usar wp-playground o pedir ruta
- Si el proyecto no tiene React, mostrar error y sugerir crear uno
- Preservar siempre las animaciones GSAP (no modificar refs ni timelines)
- Sanitizar todo input antes de guardar en WordPress
- Documentar errores en ERRORS-LOG.md si ocurren durante el proceso

**Templates**

La skill usa templates del playbook:
- `react-to-wp-headless-playbook/TEMPLATES/home-template.php`
- `react-to-wp-headless-playbook/TEMPLATES/mu-plugin-template.php`
- `react-to-wp-headless-playbook/TEMPLATES/react-types.ts`
- `react-to-wp-headless-playbook/TEMPLATES/react-section.tsx`
- `react-to-wp-headless-playbook/TEMPLATES/admin-metabox.css`
- `react-to-wp-headless-playbook/TEMPLATES/admin-metabox.js`

**Placeholders a reemplazar**

| Placeholder | Descripción | Ejemplo |
|-------------|-------------|---------|
| `{PREFIX}` | Namespace del proyecto | `wetheme`, `acme` |
| `{CLIENT}` | Nombre del cliente | "WE Digital" |
| `{SLUG}` | Slug de la página | `sample-page`, `home` |
| `{THEME}` | Nombre del tema WP | `twentytwentyfive` |

**Comandos útiles**

```bash
# Ver estado del playbook
/react-to-wp-headless status

# Auditar playbook
/react-to-wp-headless audit

# Ejecutar fase específica
/react-to-wp-headless phase 3

# Ver logs
/react-to-wp-headless logs
```

**Mantenimiento**

Para mejorar el playbook después de cada proyecto:
1. Actualizar `LOGS/LESSONS-LEARNED.md`
2. Agregar errores nuevos a `LOGS/ERRORS-LOG.md`
3. Actualizar `LOGS/TIME-ESTIMATES.md` con tiempos reales
4. Ejecutar tareas de `openspec/changes/playbook-v1.0.0/tasks.md`
5. Iterar y mejorar templates

---

**¿Necesitás ayuda?**
- Ver documentación completa: `react-to-wp-headless-playbook/PLAYBOOK.md`
- Errores comunes: `react-to-wp-headless-playbook/LOGS/ERRORS-LOG.md`
- Decisiones técnicas: `react-to-wp-headless-playbook/LOGS/DECISION-LOG.md`