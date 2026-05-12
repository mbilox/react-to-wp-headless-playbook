# Fase 5: Verificación y QA

> **Tiempo estimado:** 2-3 horas  
> **Entregable:** Sitio verificado visualmente y funcionalmente

---

## Objetivo

Asegurar que todo funciona correctamente antes de entregar al cliente.

## Pasos de Verificación

### 5.1 Build de producción

```bash
cd app/
npm run build
```

**Esperado:** 0 errores de TypeScript, build exitoso.

**Si hay errores:**
- Revisar tipos en `src/types/home-meta.ts`
- Verificar que todos los imports son correctos
- Asegurar que `tsconfig.json` incluye todos los archivos

### 5.2 Verificar REST API

```bash
# Endpoint de la página de inicio
curl -s http://localhost:8882/wp-json/wp/v2/pages?slug={SLUG} | jq '.[0].meta'

# Debería mostrar:
# {
#   "{PREFIX}_hero": { ... },
#   "{PREFIX}_rooms": { ... },
#   "{PREFIX}_surf_info": { ... }
# }
```

**Validar:**
- [ ] Todos los meta campos están presentes
- [ ] La estructura JSON coincide con los tipos TypeScript
- [ ] Los arrays tienen elementos correctos
- [ ] Los strings no están vacíos (si se poblaron)

### 5.3 Levantar servidor de desarrollo

```bash
cd app/
npm run dev
```

**Esperado:** Servidor corriendo en `http://localhost:3000`

### 5.4 Screenshots con agent-browser

```bash
# Abrir el sitio
agent-browser open http://localhost:3000 --headless

# Screenshot de página completa
agent-browser screenshot screenshot-home.png --full

# Snapshot de elementos interactivos
agent-browser snapshot -i
```

**Validar visualmente:**
- [ ] Hero carga correctamente
- [ ] Services muestran los 4 servicios
- [ ] Process muestra los 5 pasos
- [ ] Projects muestra los 3 proyectos
- [ ] About muestra párrafos y stats
- [ ] Closing muestra CTA
- [ ] Footer muestra enlaces y redes
- [ ] Navbar funciona (scroll to sections)
- [ ] Diseño visual se mantiene al 100%
- [ ] Colores, tipografías, espaciados correctos

### 5.5 Editar contenido desde WordPress

1. Ir al admin de WordPress: `http://localhost:8882/wp-admin`
2. Editar la página de inicio (con Home Template)
3. Cambiar un campo en el metabox (ej: título del Hero)
4. Guardar/Actualizar
5. Recargar el frontend React
6. **Validar:** El cambio se refleja inmediatamente

### 5.6 Probar fallbacks

1. En WordPress, vaciar un campo (ej: subtitle del Hero)
2. Guardar
3. Recargar el frontend
4. **Validar:** Se muestra el texto estático original (fallback)

### 5.7 Verificar animaciones

1. Scroll por toda la página
2. **Validar:**
   - [ ] Hero: animaciones de entrada funcionan
   - [ ] Services: cards aparecen con animación
   - [ ] Process: slider pinned funciona
   - [ ] Projects: clip-path reveal funciona
   - [ ] About: contadores animan desde 0
   - [ ] Closing: blur effect funciona
   - [ ] Footer: fade in al entrar en viewport

### 5.8 Responsive

1. Redimensionar navegador o usar DevTools
2. **Validar:**
   - [ ] Mobile (< 768px): layout correcto
   - [ ] Tablet (768px - 1024px): layout correcto
   - [ ] Desktop (> 1024px): layout correcto
   - [ ] Textos no se cortan
   - [ ] Botones son clickeables
   - [ ] Menú hamburguesa funciona (si aplica)

### 5.9 Performance

1. Abrir DevTools → Performance
2. **Validar:**
   - [ ] LCP (Largest Contentful Paint) < 2.5s
   - [ ] FID (First Input Delay) < 100ms
   - [ ] CLS (Cumulative Layout Shift) < 0.1
   - [ ] No hay layout shifts al cargar datos

### 5.10 Accesibilidad

1. Usar Lighthouse o axe DevTools
2. **Validar:**
   - [ ] Contraste de colores suficiente
   - [ ] Imágenes tienen alt text
   - [ ] Botones tienen aria-labels
   - [ ] Navegación por teclado funciona
   - [ ] Screen reader puede leer contenido

---

## Checklist de QA

### Funcionalidad
- [ ] Build de producción sin errores
- [ ] REST API devuelve datos correctos
- [ ] Frontend carga datos de WordPress
- [ ] Cambios en WordPress se reflejan en React
- [ ] Fallbacks funcionan cuando campos están vacíos

### Diseño
- [ ] Diseño visual idéntico al original
- [ ] Animaciones GSAP funcionan correctamente
- [ ] Responsive en mobile, tablet, desktop
- [ ] No hay layout shifts
- [ ] Performance aceptable

### WordPress Admin
- [ ] Metabox aparece en página con Home Template
- [ ] Campos se pueden editar
- [ ] Media Frame funciona para imágenes
- [ ] Repeaters permiten añadir/eliminar filas
- [ ] Datos se guardan correctamente
- [ ] Sanitización funciona (no permite XSS)

### Cross-browser
- [ ] Chrome/Chromium
- [ ] Firefox
- [ ] Safari (si aplica)
- [ ] Edge

---

## Herramientas de Verificación

| Herramienta | Uso | Comando |
|-------------|-----|---------|
| **agent-browser** | Screenshots, DOM snapshot | `agent-browser screenshot page.png --full` |
| **curl** | Verificar REST API | `curl http://localhost:8882/wp-json/...` |
| **jq** | Parsear JSON | `curl ... | jq '.[0].meta'` |
| **Lighthouse** | Performance, SEO, A11y | En DevTools de Chrome |
| **axe DevTools** | Accesibilidad | Extensión de navegador |
| **WAVE** | Accesibilidad | Extensión de navegador |

---

## Errores comunes

**Error:** El sitio se ve roto después de editar desde WordPress
- **Causa:** Campo obligatorio quedó vacío
- **Solución:** Implementar validación en el metabox o mejorar fallbacks

**Error:** Animaciones no funcionan después de cambios
- **Causa:** Los refs de GSAP apuntan a elementos que ya no existen
- **Solución:** Verificar que los refs se inicializan después del render

**Error:** Performance degradada
- **Causa:** Demasiadas peticiones a la API o imágenes sin optimizar
- **Solución:** Implementar caching o SWR, optimizar imágenes

---

## Sign-off

Antes de entregar, obtener confirmación del usuario:

- [ ] Usario aprobó el diseño visual
- [ ] Usuario pudo editar contenido desde WordPress
- [ ] Usario verificó que los cambios se reflejan en el frontend
- [ ] Usuario aprobó el responsive
- [ ] Usuario aprobó las animaciones

---

**¿Todo pasó?** ¡Listo para deploy! 🚀
