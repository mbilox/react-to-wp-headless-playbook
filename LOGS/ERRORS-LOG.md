# Errors Log — React to WordPress Headless

> Registro de errores que ocurrieron durante el proyecto WE Digital y sus soluciones.  
> **Objetivo:** Evitar que estos errores vuelvan a ocurrir en futuros proyectos.

---

## Tabla de Errores

| Código | Error | Síntoma | Causa | Solución | Prevención |
|--------|-------|---------|-------|----------|------------|
| **E001** | WordPress path not found | "No encuentro WordPress" o "wp-load.php no existe" | Ruta de instalación no estándar o desconocida | Pedir al usuario la ruta explícitamente y guardar en memoria persistente | Incluir en checklist inicial: "Pedir ruta de WordPress" |
| **E002** | CORS blocked | Frontend muestra "Failed to fetch" o error de red | WordPress no acepta el origen del dev server de Vite | Headers CORS en el mu-plugin + preflight OPTIONS | Template del mu-plugin ya incluye CORS por defecto |
| **E003** | Meta not exposed in REST | API devuelve página sin campo `meta` | `show_in_rest` no está configurado en `register_post_meta` | Agregar `'show_in_rest' => ['schema' => [...]]` | Template base siempre incluye `show_in_rest` |
| **E004** | TypeScript compiler not found | `npm run build` falla: "tsc not recognized" | Falta `node_modules` o TypeScript no está instalado | Ejecutar `npm install` antes del build | Checklist incluye `npm install` como paso previo |
| **E005** | Node processes stuck | El servidor no responde o "port already in use" | Procesos de Node anteriores siguen corriendo | `taskkill /F /IM node.exe` (Windows) o `killall node` (Mac/Linux) | Script de cleanup en el playbook; reiniciar terminal si es necesario |
| **E006** | ES modules vs CommonJS conflict | `ReferenceError: require is not defined` | `package.json` tiene `"type": "module"` pero el script usa `require()` | Usar extensión `.cjs` para scripts CommonJS o migrar a ES modules (`import`) | Scripts de ayuda usar extensión `.cjs` o ES modules consistentemente |
| **E007** | WordPress Media Frame not loading | Botón "Seleccionar imagen" no hace nada | No se encoló `wp_enqueue_media()` | Llamar `wp_enqueue_media()` en `admin_enqueue_scripts` antes del script del metabox | Template del mu-plugin incluye `wp_enqueue_media()` |
| **E008** | Repeater data lost | Array se guarda como string vacío o incorrecto | JSON no se decodifica al leer desde POST | Usar `sanitize_callback` con `json_decode` en `register_post_meta` | Template base incluye `sanitize_callback` |
| **E009** | Build fails with TypeScript errors | Errores de tipos en `npm run build` | Los tipos TypeScript no coinciden con la estructura real de la API | Verificar la respuesta real de la API y ajustar interfaces en `types/home-meta.ts` | Crear tipos basados en la respuesta real de la API, no en suposiciones |
| **E010** | Animations broken after data load | GSAP no anima o muestra errores en consola | Los refs apuntan a `null` porque el contenido aún no cargó | Esperar a `loading === false` antes de inicializar GSAP; usar `useLayoutEffect` si es necesario | Siempre verificar que `loading` es false antes de inicializar animaciones |
| **E011** | Template not assigned | Metabox no aparece en el editor | La página no tiene asignada la plantilla `home-template.php` | Asignar la plantilla manualmente o via script PHP | Incluir verificación de plantilla en el checklist |
| **E012** | Admin assets not loading | Metabox se ve sin estilos o JS no funciona | `admin_enqueue_scripts` no se ejecuta o el hook es incorrecto | Verificar que `get_current_screen()->id === 'page'` y que el hook es `admin_enqueue_scripts` | Template del mu-plugin incluye verificación de screen |
| **E013** | Data not saving | Los cambios en el metabox no persisten | `save_post` no está hooked o el nonce falla | Verificar `add_action('save_post', ...)` y que `wp_verify_nonce` pasa | Template incluye nonce y verificación completa |
| **E014** | Slug mismatch | Hook `useHomeData` no encuentra la página | El slug en el fetch no coincide con el slug real de la página | Verificar el slug en WordPress (Páginas → Editar → Slug) y actualizar el hook | Documentar el slug en el README del proyecto |
| **E015** | Image URL not loading | La imagen seleccionada en WordPress no aparece en React | Se guardó el `image_id` pero no se obtuvo la URL | Usar `wp_get_attachment_url()` o `wp_get_attachment_image_src()` para obtener la URL desde el ID | En el frontend, hacer un segundo fetch al media endpoint o incluir la URL en el meta |

---

## Soluciones detalladas

### E002: CORS Configuration

**Archivo:** `wp-content/mu-plugins/{PREFIX}-home-meta.php`

```php
function {PREFIX}_configure_cors(): void {
    $allowed_origins = [
        'http://localhost:5173',
        'https://localhost:5173',
        'http://127.0.0.1:5173',
        'https://127.0.0.1:5173',
    ];
    
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    
    if (in_array($origin, $allowed_origins, true)) {
        header("Access-Control-Allow-Origin: {$origin}");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-WP-Nonce');
        header('Access-Control-Allow-Credentials: true');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        status_header(200);
        exit;
    }
}
add_action('init', '{PREFIX}_configure_cors', 1);
add_action('rest_api_init', '{PREFIX}_configure_cors', 1);
```

### E005: Kill Node Processes

**Windows:**
```powershell
taskkill /F /IM node.exe
taskkill /F /IM npm.exe
```

**Mac/Linux:**
```bash
killall node
killall npm
```

### E006: ES Modules vs CommonJS

**Opción A: Usar `.cjs` (recomendado para scripts simples)**
```javascript
// test-server.cjs
const http = require('http');
// ...
```

**Opción B: Usar ES modules**
```javascript
// test-server.mjs
import http from 'http';
// ...
```

### E010: GSAP + Dynamic Content

```typescript
useEffect(() => {
  if (loading) return; // ⭐ Esperar a que los datos carguen
  
  const ctx = gsap.context(() => {
    // Inicializar animaciones aquí
  }, sectionRef);

  return () => ctx.revert();
}, [loading]); // ⭐ Dependencia en loading
```

---

## Troubleshooting paso a paso

### El frontend no carga datos de WordPress

1. Verificar que WordPress está corriendo: `curl http://localhost:8882`
2. Verificar que la REST API funciona: `curl http://localhost:8882/wp-json/`
3. Verificar que el endpoint de páginas funciona: `curl http://localhost:8882/wp-json/wp/v2/pages`
4. Verificar que los meta campos están expuestos: `curl .../pages/2 | jq '.meta'`
5. Verificar CORS en el navegador (DevTools → Network → ver headers)
6. Verificar que `VITE_WP_API_URL` está configurado en `.env`
7. Verificar que el slug en `useHomeData()` coincide con el de WordPress

### El metabox no aparece en WordPress

1. Verificar que la página tiene asignada la plantilla `home-template.php`
2. Verificar que el mu-plugin está en `wp-content/mu-plugins/`
3. Verificar que no hay errores PHP (habilitar `WP_DEBUG`)
4. Verificar que `add_meta_boxes` está hooked correctamente
5. Verificar que `get_current_screen()->id === 'page'`

### Los datos no se guardan

1. Verificar que `save_post` está hooked
2. Verificar que el nonce se verifica correctamente
3. Verificar que `current_user_can('edit_page', $post_id)` pasa
4. Verificar que `$_POST['{PREFIX}_hero']` existe
5. Verificar que no hay errores de sanitización
6. Verificar la base de datos: `SELECT * FROM wp_postmeta WHERE post_id = 2`

---

**Última actualización:** Mayo 2026  
**Proyecto de referencia:** theme-wordpress2 (WE Digital)
