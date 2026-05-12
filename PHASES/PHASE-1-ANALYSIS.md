# Fase 1: Análisis del Diseño React

> **Tiempo estimado:** 1-2 horas  
> **Entregable:** Documento de mapeo (texto estático → meta campos)

---

## Objetivo

Entender el sitio React al 100% antes de tocar código. Identificar qué contenido es estático, dónde está, y cómo mapearlo a meta campos de WordPress.

## Pasos Detallados

### 1.1 Listar todas las secciones

Recorrer el proyecto React y listar todos los componentes de sección:

```bash
# Buscar archivos de sección
glob app/src/sections/**/*.{tsx,jsx}
glob app/src/pages/**/*.{tsx,jsx}
glob app/src/components/**/*.{tsx,jsx}
```

**Ejemplo de output esperado:**
```
sections/
├── Hero.tsx
├── Services.tsx
├── Process.tsx
├── Projects.tsx
├── About.tsx
├── Closing.tsx
└── Footer.tsx
```

### 1.2 Identificar texto estático

Abrir cada componente y extraer todo texto hardcodeado:

**Ejemplo (Hero.tsx):**
```typescript
// Textos a extraer:
"Agencia Digital"                    → label
"SOMOS EL MOTOR DIGITAL..."         → headline
"Integramos estrategia..."          → subtitle
"Conversemos"                        → cta_primary_text
"Nuestras Soluciones"                → cta_secondary_text
```

**Herramienta útil:** Usar grep para encontrar strings:
```bash
grep -r "\"[A-Z]" app/src/sections/
```

### 1.3 Detectar assets

Listar todas las imágenes, videos y SVGs:

```bash
ls app/public/
ls app/src/assets/
```

**Categorizar:**
- **Backgrounds/Videos:** Hero background, section backgrounds
- **Logos:** Logo del cliente, favicon
- **Icons:** Iconos de servicios, redes sociales
- **Galerías:** Proyectos, portfolio

### 1.4 Identificar listas dinámicas

Buscar arrays de datos en los componentes:

```typescript
// Ejemplo: Services.tsx
const services = [
  { title: "Branding", description: "...", items: [...] },
  { title: "Growth", description: "...", items: [...] },
];
```

Estas listas se convertirán en **repeaters** en el metabox de WordPress.

### 1.5 Documentar animaciones

Identificar librerías y efectos:

```typescript
// ¿Qué animaciones usa?
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

// ¿Hay animaciones que dependen del contenido?
// Ej: contadores animados, sliders, parallax
```

**Nota importante:** Las animaciones se preservan intactas. No se modifican. Solo se asegura que el contenido dinámico no rompa los refs ni los timelines.

### 1.6 Crear tabla de mapeo

Documentar la correspondencia:

| Componente | Texto Estático | Clave Meta | Tipo |
|-----------|---------------|-----------|------|
| Hero.tsx | "Agencia Digital" | `{PREFIX}_hero.label` | string |
| Hero.tsx | "SOMOS EL MOTOR..." | `{PREFIX}_hero.headline` | string |
| Hero.tsx | "Integramos..." | `{PREFIX}_hero.subtitle` | string |
| Services.tsx | "Servicios" | `{PREFIX}_rooms.section_label` | string |
| Services.tsx | Array services | `{PREFIX}_rooms.services` | array[object] |
| About.tsx | Stats +500% | `{PREFIX}_surf_info.stats` | array[object] |

### 1.7 Definir estructura de meta campos

Agrupar en 3-5 meta campos principales:

```typescript
// Ejemplo:
{PREFIX}_hero: {
  label, headline, subtitle,
  cta_primary_text, cta_primary_url,
  cta_secondary_text, cta_secondary_url,
  video_url, image_id
}

{PREFIX}_rooms: {
  section_label, section_title,
  services: [{ title, description, items[], icon }]
}

{PREFIX}_surf_info: {
  process_label, process_title,
  steps: [{ number, title, description }],
  projects_label, projects_title,
  projects: [{ client, stat, statLabel, description, subStat, services[] }],
  about_label, about_title,
  about_paragraphs: string[],
  stats: [{ value, prefix, suffix, label }],
  closing_headline, closing_cta_text, closing_cta_url,
  footer_tagline, footer_solutions[],
  footer_empresa: [{ label, href }],
  footer_cta_text,
  footer_social: [{ label, url }]
}
```

**Regla:** No crear un meta campo por cada string. Agrupar por sección.

---

## Checklist Fase 1

- [ ] Todas las secciones listadas
- [ ] Todo texto estático extraído
- [ ] Todos los assets identificados
- [ ] Todas las listas dinámicas mapeadas
- [ ] Animaciones documentadas
- [ ] Tabla de mapeo creada
- [ ] Estructura de meta campos definida
- [ ] Revisión con el usuario/cliente

---

## Plantilla de Mapeo

Copiar y completar:

```markdown
# Mapeo de Contenido: {NOMBRE_PROYECTO}

## Meta Campos Definidos

| Campo | Tipo | Secciones |
|-------|------|-----------|
| `{PREFIX}_hero` | object | Hero |
| `{PREFIX}_rooms` | object | Services |
| `{PREFIX}_surf_info` | object | Process, Projects, About, Closing, Footer |

## Hero

| Texto Estático | Clave Meta | Tipo |
|----------------|-----------|------|
| "..." | `{PREFIX}_hero.label` | string |
| "..." | `{PREFIX}_hero.headline` | string |

## Services

| Texto Estático | Clave Meta | Tipo |
|----------------|-----------|------|
| "..." | `{PREFIX}_rooms.section_label` | string |
| Array servicios | `{PREFIX}_rooms.services` | array[object] |

[...continuar con cada sección...]
```

---

## Errores comunes en esta fase

**Error:** Olvidar assets (imágenes, videos)
- **Solución:** Revisar carpeta `public/` y `src/assets/`

**Error:** No identificar listas anidadas (items dentro de servicios)
- **Solución:** Revisar estructura completa de cada array

**Error:** No documentar animaciones que dependen del contenido
- **Solución:** Revisar `useEffect` y `useLayoutEffect` en cada componente

---

## Herramientas útiles

- `grep` / `rg` — Buscar strings en el código
- `glob` — Listar archivos de sección
- `tree` — Visualizar estructura de carpetas
- `read` — Leer contenido de archivos
