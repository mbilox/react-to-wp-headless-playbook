# Checklist — Fase 4: React Frontend

> **Objetivo:** Adaptar el frontend React para consumir datos dinámicos de WordPress.
> **Tiempo estimado:** 3-4 horas

---

## Tipos TypeScript

- [ ] Archivo `src/types/home-meta.ts` creado
- [ ] Interfaces definidas para todas las secciones:
  - [ ] `HeroMeta` (label, headline, subtitle, CTAs, video_url, image_id)
  - [ ] `ServiceItem` (title, description, items[], icon)
  - [ ] `RoomsMeta` (section_label, section_title, services[])
  - [ ] `ProcessStep` (number, title, description)
  - [ ] `ProjectItem` (client, stat, statLabel, description, subStat, services[])
  - [ ] `AboutStat` (value, prefix, suffix, label)
  - [ ] `FooterLink` (label, href)
  - [ ] `SocialLink` (label, url)
  - [ ] `SurfInfoMeta` (process, projects, about, stats, closing, footer)
  - [ ] `HomeMetaData` (contenedor de todos los meta campos)

## Hook useHomeData

- [ ] Archivo `src/hooks/useHomeData.ts` creado
- [ ] Interface `UseHomeDataReturn` definida ({ data, loading, error })
- [ ] `useState` para data, loading, error
- [ ] `useEffect` con cleanup (`cancelled` flag)
- [ ] `fetch` a `${WP_API_URL}/wp/v2/pages?slug={SLUG}&_embed=1`
- [ ] Manejo de errores de red, 404, CORS
- [ ] Fallback a objeto vacío si un campo meta no existe
- [ ] Export de tipos desde `src/types/home-meta.ts`

## App.tsx

- [ ] `useHomeData()` importado y usado
- [ ] Estados loading y error manejados
- [ ] Spinner/mensaje de carga mostrado mientras `loading === true`
- [ ] Mensaje de error mostrado si `error !== null`
- [ ] Datos pasados por props a cada sección
- [ ] `ScrollTrigger.refresh()` llamado después de cargar datos

## Refactor de Secciones

- [ ] **Hero.tsx**: Texto estático reemplazado por `meta.wetheme_hero` con fallback
- [ ] **Services.tsx**: Array hardcodeado reemplazado por `meta.wetheme_rooms.services`
- [ ] **Process.tsx**: Steps reemplazados por `meta.wetheme_surf_info.steps`
- [ ] **Projects.tsx**: Projects reemplazados por `meta.wetheme_surf_info.projects`
- [ ] **About.tsx**: Párrafos y stats reemplazados por `meta.wetheme_surf_info`
- [ ] **Closing.tsx**: Headline y CTA reemplazados por `meta.wetheme_surf_info`
- [ ] **Footer.tsx**: Tagline, soluciones, empresa, social reemplazados

## Fallbacks

- [ ] Cada componente tiene objeto `FALLBACK` con texto original
- [ ] Cada campo usa `meta?.field || FALLBACK.field`
- [ ] No hay campos que rendericen `undefined` o `null`
- [ ] Sitio se ve correctamente si WordPress no tiene datos

## Animaciones GSAP

- [ ] Todos los refs preservados intactos
- [ ] `useEffect` o `useLayoutEffect` usados correctamente
- [ ] Animaciones inicializadas solo cuando `loading === false`
- [ ] Dependencia en `[loading]` para re-inicializar
- [ ] `ctx.revert()` en cleanup
- [ ] No hay errores en consola relacionados a GSAP

## Configuración

- [ ] Archivo `.env` creado en raíz del proyecto
- [ ] `VITE_WP_API_URL=http://localhost:8882/wp-json` configurado
- [ ] Fallback a URL por defecto si variable no está definida

## Build

- [ ] `npm run build` ejecutado
- [ ] Build completa sin errores de TypeScript
- [ ] Build completa sin errores de ESLint
- [ ] Build genera archivos en `dist/` o `build/`

## Verificación

- [ ] Frontend carga datos de WordPress correctamente
- [ ] Diseño visual se mantiene al 100%
- [ ] No hay layout shifts al cargar datos
- [ ] Consola del navegador sin errores