# Lessons Learned — React to WordPress Headless

> Lecciones aprendidas durante el desarrollo del proyecto WE Digital.  
> **Objetivo:** Capturar conocimiento tácito para reutilizar en futuros proyectos.

---

## Lecciones del Proyecto WE Digital

### 1. WordPress Media Frame es más simple de lo que parece

**Contexto:** El usuario pidió específicamente usar el Media Frame nativo de WordPress. Inicialmente parecía complejo, pero en realidad es muy sencillo.

**Lección:** `wp.media` está muy bien documentado y funciona con solo unas líneas de JavaScript. No hay que temerle.

**Snippet clave:**
```javascript
var frame = wp.media({
    title: 'Seleccionar imagen',
    button: { text: 'Usar esta imagen' },
    multiple: false,
    library: { type: 'image' }
});

frame.on('select', function() {
    var attachment = frame.state().get('selection').first().toJSON();
    // attachment.id, attachment.url, attachment.sizes.thumbnail.url
});

frame.open();
```

### 2. Sanitización en WordPress es crítica y fácil de olvidar

**Contexto:** En un momento olvidamos sanitizar un campo y los datos se guardaban con espacios extras o caracteres raros.

**Lección:** Siempre sanitizar ANTES de guardar. WordPress tiene funciones perfectas para cada tipo de dato.

**Checklist mental:**
- ¿Es texto simple? → `sanitize_text_field()`
- ¿Es un párrafo? → `sanitize_textarea_field()`
- ¿Es una URL? → `esc_url_raw()`
- ¿Es un número? → `absint()` o `intval()`
- ¿Es un array de strings? → `array_map('sanitize_text_field', ...)`

### 3. Los repeaters nativos con JS vanilla funcionan perfectamente

**Contexto:** Dudamos si los repeaters nativos serían tan robustos como los de ACF.

**Lección:** Con un poco de jQuery (o vanilla JS), los repeaters funcionan de maravilla. La clave es:
1. Templates HTML en `<script type="text/template">`
2. Re-indexar los `name` después de eliminar filas
3. Encolar scripts solo en la pantalla correcta

### 4. OpenSpec es excelente para mantener el orden

**Contexto:** El proyecto tenía 60+ tareas. Sin OpenSpec, habríamos perdido el control.

**Lección:** OpenSpec no es solo documentación, es un **sistema de tracking**. Cada tarea tiene un checkbox, y el progreso es visible.

**Mejores prácticas:**
- Siempre esperar el OK del usuario antes de ejecutar tareas
- Marcar tareas como completadas inmediatamente después
- Si surge un error, pausar y documentar

### 5. El build de TypeScript puede fallar por cosas simples

**Contexto:** `npm run build` falló porque TypeScript no estaba instalado (habíamos borrado node_modules).

**Lección:** Siempre ejecutar `npm install` antes de `npm run build`, especialmente después de cambiar de branch o clonar el repo.

### 6. Las animaciones GSAP no se rompen con contenido dinámico

**Contexto:** Preocupados de que cambiar texto hardcodeado por props dinámicas rompiera las animaciones.

**Lección:** Las animaciones GSAP dependen de los refs y los elementos DOM, no del contenido textual. Mientras los refs apunten a los elementos correctos, todo funciona.

**Truco:** Esperar a que `loading === false` antes de inicializar GSAP:
```typescript
useEffect(() => {
  if (loading) return;
  // Inicializar GSAP aquí
}, [loading]);
```

### 7. Es importante guardar la ruta de WordPress en memoria

**Contexto:** Tuvimos que preguntar varias veces dónde estaba instalado WordPress.

**Lección:** Guardar información crítica del proyecto en memoria persistente (Engram) para no tener que preguntar de nuevo.

### 8. El slug de la página importa

**Contexto:** El hook `useHomeData()` buscaba por slug (`sample-page`), no por ID.

**Lección:** Documentar siempre el slug de la página de inicio. Si cambia, hay que actualizar el hook.

### 9. agent-browser es invaluable para verificación visual

**Contexto:** Usamos agent-browser para tomar screenshots y verificar que el diseño se mantenía.

**Lección:** No confiar solo en que "no hay errores de consola". Tomar screenshots y comparar visualmente.

**Comandos útiles:**
```bash
agent-browser open http://localhost:3000 --headless
agent-browser screenshot page.png --full
agent-browser snapshot -i
```

### 10. Documentar errores en el momento

**Contexto:** Algunos errores los resolvemos y los olvidamos.

**Lección:** Documentar cada error INMEDIATAMENTE después de resolverlo. Incluir:
- Código del error (E001, E002, etc.)
- Síntoma exacto
- Causa raíz
- Solución paso a paso
- Cómo prevenirlo

---

## Mejores prácticas descubiertas

### BP1: Template del mu-plugin parametrizado

Crear el mu-plugin con placeholders desde el inicio:
- `{PREFIX}` → `wetheme`, `acme`, `clientname`
- `{CLIENT}` → nombre del cliente
- `{SLUG}` → slug de la página

Esto permite reutilizar el código en cualquier proyecto con solo buscar y reemplazar.

### BP2: Consistencia en nombres de meta campos

Siempre usar el mismo prefijo:
```
{PREFIX}_hero
{PREFIX}_rooms
{PREFIX}_surf_info
```

Nunca mezclar prefijos en el mismo proyecto.

### BP3: Fallbacks en todos los componentes

Cada componente debe tener:
```typescript
const FALLBACK = { /* texto original */ };
const value = meta?.field || FALLBACK.field;
```

### BP4: JSON Schema con `additionalProperties: true`

Esto permite extender el schema sin romper compatibilidad:
```php
'schema' => [
    'type' => 'object',
    'properties' => [ /* ... */ ],
    'additionalProperties' => true, // ⭐ Permite campos extras
]
```

### BP5: Procesos Node colgados

Siempre verificar que no hay procesos viejos antes de levantar el servidor:
```bash
# Windows
taskkill /F /IM node.exe

# Mac/Linux
killall node
```

---

## Qué haríamos diferente

1. **Crear el starter template desde el día 1**
   - En lugar de escribir todo desde cero, tener un template base listo para copiar

2. **Automatizar la asignación de plantilla**
   - Script que detecta si la página tiene la plantilla asignada y la asigna automáticamente

3. **Incluir validaciones en el metabox**
   - Campos requeridos, longitud máxima, etc.

4. **Implementar preview en vivo**
   - Botón "Preview" que abre el frontend en una nueva ventana

---

**Última actualización:** Mayo 2026  
**Proyecto de referencia:** theme-wordpress2 (WE Digital)
