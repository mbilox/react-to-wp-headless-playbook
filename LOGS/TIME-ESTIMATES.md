# Time Estimates — React to WordPress Headless

> Estimaciones de tiempo por fase basadas en el proyecto WE Digital.

---

## Estimaciones por Fase

### Fase 1: Análisis del Diseño React
**Tiempo estimado:** 1-2 horas

| Tarea | Tiempo |
|-------|--------|
| Listar secciones del sitio | 15 min |
| Identificar texto estático | 30 min |
| Detectar assets (imágenes, videos) | 15 min |
| Identificar listas dinámicas | 15 min |
| Documentar animaciones | 10 min |
| Crear tabla de mapeo | 15 min |
| **Total** | **1h 40min** |

**Factores que pueden aumentar el tiempo:**
- Sitio con muchas secciones (> 10)
- Animaciones complejas (WebGL, canvas)
- Muchos assets sin organizar
- Código sin tipar (JS puro)

### Fase 2: OpenSpec Planning
**Tiempo estimado:** 2-3 horas

| Tarea | Tiempo |
|-------|--------|
| Crear change | 5 min |
| Generar proposal.md | 30 min |
| Generar design.md | 45 min |
| Generar specs/ | 30 min |
| Generar tasks.md | 30 min |
| Revisión y ajustes | 30 min |
| **Total** | **2h 50min** |

**Factores que pueden aumentar el tiempo:**
- Ambigüedad en requerimientos (requiere más preguntas)
- Necesidad de investigar tecnologías nuevas
- Cambios durante la revisión

### Fase 3: WordPress Backend
**Tiempo estimado:** 4-6 horas

| Tarea | Tiempo |
|-------|--------|
| Identificar tema y crear plantilla | 30 min |
| Asignar plantilla a página | 15 min |
| Crear estructura del mu-plugin | 30 min |
| Implementar register_post_meta | 45 min |
| Crear metabox básico | 45 min |
| Implementar Media Frame | 30 min |
| Implementar repeaters | 1h |
| Implementar save_post + sanitización | 45 min |
| CSS y JS del metabox | 30 min |
| CORS y assets | 15 min |
| Poblar datos iniciales | 15 min |
| Testing y ajustes | 30 min |
| **Total** | **5h 30min** |

**Factores que pueden aumentar el tiempo:**
- Muchas secciones (> 7)
- Campos complejos (galerías, mapas, etc.)
- Necesidad de custom post types adicionales
- Conflictos con plugins existentes

### Fase 4: React Frontend
**Tiempo estimado:** 3-4 horas

| Tarea | Tiempo |
|-------|--------|
| Crear tipos TypeScript | 30 min |
| Implementar useHomeData hook | 30 min |
| Modificar App.tsx | 15 min |
| Refactorizar Hero.tsx | 30 min |
| Refactorizar Services.tsx | 30 min |
| Refactorizar Process.tsx | 30 min |
| Refactorizar Projects.tsx | 30 min |
| Refactorizar About.tsx | 30 min |
| Refactorizar Closing.tsx | 15 min |
| Refactorizar Footer.tsx | 15 min |
| Configurar .env | 5 min |
| Testing y ajustes | 30 min |
| **Total** | **3h 50min** |

**Factores que pueden aumentar el tiempo:**
- Muchas secciones (> 10)
- Animaciones complejas que requieren ajustes
- Componentes mal estructurados
- Necesidad de librerías adicionales

### Fase 5: Verificación y QA
**Tiempo estimado:** 2-3 horas

| Tarea | Tiempo |
|-------|--------|
| Build de producción | 5 min |
| Verificar REST API | 15 min |
| Levantar servidor | 5 min |
| Screenshots con agent-browser | 30 min |
| Editar contenido desde WP | 15 min |
| Probar fallbacks | 15 min |
| Verificar animaciones | 20 min |
| Responsive testing | 20 min |
| Performance audit | 20 min |
| Accesibilidad audit | 20 min |
| Ajustes finales | 30 min |
| **Total** | **2h 35min** |

**Factores que pueden aumentar el tiempo:**
- Muchos bugs encontrados
- Necesidad de ajustes de diseño
- Problemas de performance
- Testing cross-browser extenso

### Fase 6: E-commerce (Opcional)
**Tiempo estimado:** 2-4 horas

| Tarea | Tiempo |
|-------|--------|
| Instalar WooCommerce | 15 min |
| Configurar productos | 30 min |
| Crear meta campos para productos | 30 min |
| Frontend: Product catalog | 30 min |
| Frontend: Product detail | 30 min |
| Frontend: Cart | 30 min |
| Frontend: Checkout | 1h |
| Testing | 30 min |
| **Total** | **3h 45min** |

**Factores que pueden aumentar el tiempo:**
- Integración con pasarela de pago compleja
- Variaciones de productos
- Shipping/calculadora de envíos
- Impuestos complejos

---

## Resumen

| Fase | Mínimo | Máximo | Promedio |
|------|--------|--------|----------|
| 1. Análisis | 1h | 2h | 1.5h |
| 2. OpenSpec | 2h | 3h | 2.5h |
| 3. WP Backend | 4h | 6h | 5h |
| 4. React Frontend | 3h | 4h | 3.5h |
| 5. Verificación | 2h | 3h | 2.5h |
| 6. E-commerce (opt) | 2h | 4h | 3h |
| **Total (sin e-commerce)** | **12h** | **18h** | **15h** |
| **Total (con e-commerce)** | **14h** | **22h** | **18h** |

---

## Factores que afectan el tiempo

### Factores que ACORTAN el tiempo

- ✅ Usar este playbook/skill (ya documentado)
- ✅ Usar templates de código (copiar y adaptar)
- ✅ Sitio React simple (< 5 secciones)
- ✅ Sin animaciones complejas
- ✅ WordPress ya instalado y configurado
- ✅ Contenido ya definido

### Factores que ALARGAN el tiempo

- ⚠️ Sitio React complejo (> 10 secciones)
- ⚠️ Animaciones avanzadas (WebGL, canvas, Lottie)
- ⚠️ Multi-idioma
- ⚠️ Custom post types adicionales
- ⚠️ Integraciones de terceros (CRM, email marketing)
- ⚠️ E-commerce complejo
- ⚠️ WordPress no instalado aún
- ⚠️ Cambios de requerimientos durante el desarrollo

---

## Recomendación

Para proyectos típicos (sitio de agencia, landing page, portfolio):
- **Estimación segura:** 16-20 horas
- **Estimación optimista:** 12-14 horas
- **Estimación conservadora:** 20-24 horas

**Siempre agregar un 20% de buffer para imprevistos.**

---

**Última actualización:** Mayo 2026  
**Basado en:** Proyecto WE Digital (theme-wordpress2)
