# Checklist — Fase 5: Verificación y QA

> **Objetivo:** Asegurar que todo funciona correctamente antes de entregar.
> **Tiempo estimado:** 2-3 horas

---

## Build de Producción

- [ ] `npm run build` ejecutado en directorio del React
- [ ] Build completa sin errores de TypeScript
- [ ] Build completa sin warnings críticos
- [ ] Archivos de build generados correctamente

## REST API

- [ ] Endpoint verificado: `curl http://localhost:8882/wp-json/wp/v2/pages?slug={SLUG}`
- [ ] Respuesta JSON incluye campo `meta`
- [ ] Meta campos tienen estructura correcta
- [ ] Arrays tienen elementos correctos
- [ ] Strings no están vacíos (si se poblaron)

## Servidor de Desarrollo

- [ ] `npm run dev` ejecutado
- [ ] Servidor corriendo en `http://localhost:3000`
- [ ] Frontend carga sin errores

## Screenshots Visuales

- [ ] Screenshots tomados con `agent-browser`
- [ ] Hero carga correctamente
- [ ] Services muestran todos los servicios
- [ ] Process muestra todos los pasos
- [ ] Projects muestra todos los proyectos
- [ ] About muestra párrafos y stats
- [ ] Closing muestra CTA
- [ ] Footer muestra enlaces y redes
- [ ] Navbar funciona (scroll to sections)

## Edición desde WordPress

- [ ] Admin de WordPress accesible
- [ ] Página de inicio editable
- [ ] Metabox "Contenido del Home" visible
- [ ] Campo editado (ej: título del Hero)
- [ ] Cambio guardado en WordPress
- [ ] Cambio reflejado en frontend React después de recargar

## Fallbacks

- [ ] Campo vaciado en WordPress (ej: subtitle del Hero)
- [ ] Cambio guardado
- [ ] Frontend recargado
- [ ] Texto estático original aparece como fallback
- [ ] No hay espacios en blanco ni errores

## Animaciones

- [ ] Scroll por toda la página
- [ ] Hero: animaciones de entrada funcionan
- [ ] Services: cards aparecen con animación
- [ ] Process: slider pinned funciona
- [ ] Projects: clip-path reveal funciona
- [ ] About: contadores animan desde 0
- [ ] Closing: blur effect funciona
- [ ] Footer: fade in al entrar en viewport

## Responsive

- [ ] Mobile (< 768px): layout correcto
- [ ] Tablet (768px - 1024px): layout correcto
- [ ] Desktop (> 1024px): layout correcto
- [ ] Textos no se cortan
- [ ] Botones son clickeables
- [ ] Menú hamburguesa funciona (si aplica)

## Performance

- [ ] LCP (Largest Contentful Paint) < 2.5s
- [ ] FID (First Input Delay) < 100ms
- [ ] CLS (Cumulative Layout Shift) < 0.1
- [ ] No hay layout shifts al cargar datos

## Accesibilidad

- [ ] Contraste de colores suficiente
- [ ] Imágenes tienen alt text
- [ ] Botones tienen aria-labels
- [ ] Navegación por teclado funciona
- [ ] Screen reader puede leer contenido

## WordPress Admin

- [ ] Metabox aparece en página con Home Template
- [ ] Campos se pueden editar
- [ ] Media Frame funciona para imágenes
- [ ] Repeaters permiten añadir/eliminar filas
- [ ] Datos se guardan correctamente
- [ ] Sanitización funciona (no permite XSS)

## Cross-browser

- [ ] Chrome/Chromium verificado
- [ ] Firefox verificado
- [ ] Safari verificado (si aplica)
- [ ] Edge verificado

## Sign-off

- [ ] Usuario aprobó el diseño visual
- [ ] Usuario pudo editar contenido desde WordPress
- [ ] Usuario verificó que los cambios se reflejan en el frontend
- [ ] Usuario aprobó el responsive
- [ ] Usuario aprobó las animaciones
- [ ] Listo para deploy 🚀