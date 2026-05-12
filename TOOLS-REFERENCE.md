# Tools Reference — React to WordPress Headless

> Registro completo de todas las herramientas, skills, plugins y recursos utilizados.

---

## Skills de OpenCode

| Skill | Descripción | Uso en este proyecto | Tipo |
|-------|-------------|---------------------|------|
| **openspec-propose** | Crear propuestas de change con artifacts | Crear `sync-home-react-to-wp` y `wp-home-admin-panel` | Built-in |
| **openspec-apply-change** | Implementar tareas de un change | Ejecutar las 60+ tareas | Built-in |
| **openspec-archive-change** | Archivar changes completados | Archivar ambos changes | Built-in |
| **context7-mcp** | Documentación de librerías/frameworks | Disponible para consultar docs de React/WP | Built-in |
| **wp-rest-api** | Endpoints REST de WordPress | Si se necesitan endpoints custom | Built-in |
| **wp-playground** | Testing de WP sin instalar | Disponible para prototipar | Built-in |
| **frontend-design** | Diseño de interfaces | Si se necesita mejorar UI del metabox | Built-in |
| **generateblocks-layouts** | Layouts WP | Si se usa GenerateBlocks | Built-in |
| **vercel-react-best-practices** | Optimización React | Para revisar código React | Built-in |

---

## MCPs (Model Context Protocol)

| MCP | Descripción | Uso |
|-----|-------------|-----|
| **WordPress MCP Adapter** | Comunicación con WordPress via REST API | Verificar páginas, meta campos, sitio info |
| **Context7 MCP** | Documentación actualizada de librerías | Consultar docs de React, WordPress, etc. |

### Endpoints del WordPress MCP Adapter

```
# Core
core/get-site-info              ← Información del sitio
core/get-user-info              ← Información del usuario
core/get-environment-info       ← Info del entorno

# Pages
ewpa/get-pages                  ← Listar páginas
ewpa/get-page?id=2             ← Obtener página específica
ewpa/create-page                ← Crear página

# Posts
ewpa/get-posts                  ← Listar posts
ewpa/get-post?id=1             ← Obtener post
ewpa/create-post                ← Crear post
ewpa/update-post                ← Actualizar post
ewpa/delete-post                ← Eliminar post

# Taxonomías
ewpa/get-categories             ← Categorías
core/get-tags                   ← Tags

# Media
ewpa/get-media                 ← Medios
core/upload-image               ← Subir imagen

# Users
ewpa/get-users                 ← Usuarios

# Stats
ewpa/site-stats                ← Estadísticas del sitio
ewpa/search-replace             ← Buscar y reemplazar
```

---

## Herramientas Externas

| Herramienta | Versión | Propósito | Repositorio | Instalación |
|-------------|---------|-----------|-------------|-------------|
| **agent-browser** | Latest | Screenshots, verificación visual, navegación automatizada | https://github.com/vercel-labs/agent-browser | `npm install -g agent-browser` |
| **WordPress** | 6.9+ | CMS Headless | https://github.com/WordPress/WordPress | Descargar de wordpress.org |
| **React** | 19 | Framework UI | https://github.com/facebook/react | `npm install react react-dom` |
| **TypeScript** | 5.x | Tipado estático | https://github.com/microsoft/TypeScript | `npm install -D typescript` |
| **Vite** | 7 | Build tool / Dev server | https://github.com/vitejs/vite | `npm create vite@latest` |
| **Tailwind CSS** | 3.4 | Estilos | https://github.com/tailwindlabs/tailwindcss | `npm install -D tailwindcss` |
| **GSAP** | 3.x | Animaciones | https://github.com/greensock/GSAP | `npm install gsap` |
| **shadcn/ui** | Latest | Componentes UI | https://github.com/shadcn-ui/ui | `npx shadcn-ui@latest init` |

### WordPress Plugins Recomendados

| Plugin | Propósito | Cuándo usar |
|--------|-----------|-------------|
| **WooCommerce** | E-commerce | Si el proyecto incluye tienda online |
| **WPGraphQL** | GraphQL para WP | Si se prefiere GraphQL sobre REST |
| **WooGraphQL** | GraphQL para WooCommerce | Si se usa WooCommerce + GraphQL |
| **JWT Authentication** | Auth via tokens | Si se necesita autenticación en la API |
| **Yoast SEO / Rank Math** | SEO | Si se necesitan meta tags dinámicos |

---

## NPM Packages del Proyecto

### Producción
```json
{
  "react": "^19.0.0",
  "react-dom": "^19.0.0",
  "gsap": "^3.12.7",
  "@studio-freight/lenis": "^1.0.42",
  "lucide-react": "^0.468.0",
  "class-variance-authority": "^0.7.1",
  "clsx": "^2.1.1",
  "tailwind-merge": "^2.6.0"
}
```

### Desarrollo
```json
{
  "vite": "^7.3.0",
  "typescript": "~5.7.0",
  "tailwindcss": "^3.4.17",
  "@types/react": "^19.0.0",
  "@types/react-dom": "^19.0.0",
  "eslint": "^9.0.0",
  "@vitejs/plugin-react": "^4.0.0"
}
```

---

## Recursos de Documentación

### WordPress
- **REST API Handbook:** https://developer.wordpress.org/rest-api/
- **register_post_meta:** https://developer.wordpress.org/reference/functions/register_post_meta/
- **add_meta_box:** https://developer.wordpress.org/reference/functions/add_meta_box/
- **wp.media:** https://codex.wordpress.org/Javascript_Reference/wp.media

### React
- **Hooks:** https://react.dev/reference/react
- **useEffect:** https://react.dev/reference/react/useEffect
- **TypeScript:** https://www.typescriptlang.org/docs/

### GSAP
- **Documentación:** https://greensock.com/docs/
- **ScrollTrigger:** https://greensock.com/scroll/

### Vite
- **Configuración:** https://vitejs.dev/config/
- **Env Variables:** https://vitejs.dev/guide/env-and-mode.html

---

## Comandos Útiles

### OpenCode
```bash
# Crear change
openspec new change "nombre"

# Ver estado
openspec status --change "nombre" --json

# Ver instrucciones de artifact
openspec instructions {artifact} --change "nombre" --json

# Listar changes
openspec list --json

# Archivar change
openspec archive "nombre"
```

### WordPress
```bash
# Verificar que WP está corriendo
curl http://localhost:8882

# Verificar REST API
curl http://localhost:8882/wp-json

# Obtener página con meta
curl http://localhost:8882/wp-json/wp/v2/pages/2

# WooCommerce products
curl http://localhost:8882/wp-json/wc/v3/products \
  -u ck_XXX:cs_XXX
```

### React
```bash
# Instalar dependencias
npm install

# Build de producción
npm run build

# Servidor de desarrollo
npm run dev

# Preview del build
npm run preview
```

### agent-browser
```bash
# Instalar
npm install -g agent-browser

# Instalar Chrome
agent-browser install

# Abrir sitio
agent-browser open http://localhost:3000 --headless

# Screenshot
agent-browser screenshot page.png --full

# Snapshot
agent-browser snapshot -i

# Batch de comandos
agent-browser batch "open url" "screenshot" "snapshot"
```

---

## Enlaces Rápidos

- **OpenCode Docs:** https://opencode.ai
- **WordPress REST API:** https://developer.wordpress.org/rest-api/
- **React Docs:** https://react.dev
- **Vite Docs:** https://vitejs.dev
- **Tailwind Docs:** https://tailwindcss.com
- **GSAP Docs:** https://greensock.com/docs
- **agent-browser Repo:** https://github.com/vercel-labs/agent-browser

---

**Última actualización:** Mayo 2026
