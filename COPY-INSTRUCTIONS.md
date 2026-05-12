# Copy Instructions — React to WordPress Headless

> Cómo llevar este playbook a otro proyecto y adaptarlo.

---

## Opción A: Copiar la carpeta react-to-wp-headless-playbook completa

### Paso 1: Copiar al nuevo proyecto

```bash
# Desde el proyecto original
cp -r react-to-wp-headless-playbook /ruta/al/nuevo-proyecto/

# O en Windows
xcopy react-to-wp-headless-playbook C:\ruta\al\nuevo-proyecto\react-to-wp-headless-playbook /E /I
```

### Paso 2: Adaptar los templates

Editar los archivos en `TEMPLATES/` y `STARTERS/` reemplazando placeholders:

| Placeholder | Descripción | Ejemplo |
|-------------|-------------|---------|
| `{PREFIX}` | Namespace del proyecto | `wetheme`, `acme`, `clientname` |
| `{CLIENT}` | Nombre del cliente | "WE Digital", "Acme Corp" |
| `{SLUG}` | Slug de la página de inicio | `sample-page`, `home`, `inicio` |
| `{THEME}` | Nombre del tema de WordPress | `twentytwentyfive` |
| `{AUTHOR}` | Tu nombre | "Tu Nombre" |

**Comando rápido para reemplazar:**
```bash
# Mac/Linux
find react-to-wp-headless-playbook -type f -name "*.php" -o -name "*.ts" -o -name "*.tsx" -o -name "*.md" | xargs sed -i 's/{PREFIX}/acme/g'

# Windows (PowerShell)
Get-ChildItem -Recurse -File | ForEach-Object {
    (Get-Content $_.FullName) -replace '{PREFIX}','acme' | Set-Content $_.FullName
}
```

### Paso 3: Adaptar la estructura de meta campos

Revisar `PHASES/PHASE-1-ANALYSIS.md` y adaptar la tabla de mapeo según el nuevo diseño React.

### Paso 4: Seguir el playbook

Abrir `react-to-wp-headless-playbook/PLAYBOOK.md` y seguir las fases en orden.

---

## Opción B: Copiar solo los starters

Si solo necesitás el código base:

```bash
# Copiar starters
cp -r react-to-wp-headless-playbook/STARTERS/wp-mu-plugin /ruta/al/nuevo-wp/wp-content/mu-plugins/
cp -r react-to-wp-headless-playbook/STARTERS/react-frontend /ruta/al/nuevo-react/src/
```

Luego adaptar los archivos copiados.

---

## Opción C: Usar como referencia

Dejar `react-to-wp-headless-playbook/` en el proyecto original y consultarlo como documentación.

---

## Checklist de Adaptación

- [ ] Reemplazar `{PREFIX}` en todos los archivos
- [ ] Reemplazar `{CLIENT}` en headers y descripciones
- [ ] Reemplazar `{SLUG}` en el hook `useHomeData()`
- [ ] Reemplazar `{THEME}` en la ruta de la plantilla
- [ ] Adaptar estructura de meta campos al nuevo diseño
- [ ] Adaptar tipos TypeScript (`types/home-meta.ts`)
- [ ] Adaptar componentes React (secciones nuevas/eliminadas)
- [ ] Adaptar CSS del metabox (colores, branding)
- [ ] Verificar que las animaciones se preservan
- [ ] Probar el flujo completo

---

## Notas Importantes

1. **No copiar directamente sin adaptar.** Los templates tienen placeholders que DEBEN ser reemplazados.

2. **El slug es crítico.** Verificar que el slug en `useHomeData()` coincida con el slug real de la página en WordPress.

3. **La ruta de WordPress puede ser diferente.** Siempre verificar dónde está instalado WordPress en el nuevo proyecto.

4. **Las animaciones pueden variar.** Si el nuevo diseño usa otra librería de animaciones (Framer Motion, Lottie), adaptar la preservación de animaciones.

5. **Las dependencias pueden variar.** Verificar `package.json` del nuevo proyecto y ajustar según sea necesario.

---

## Integración con OpenCode

Si el nuevo proyecto también usa OpenCode:

1. Copiar `.opencode/skills/react-to-wp-headless/` al nuevo proyecto
2. La skill estará disponible con `/adapt-react-to-wp`
3. Seguir las instrucciones de la skill

---

**¿Necesitás ayuda?** Revisa los logs:
- [Errores comunes](./LOGS/ERRORS-LOG.md)
- [Decisiones técnicas](./LOGS/DECISION-LOG.md)
- [Lecciones aprendidas](./LOGS/LESSONS-LEARNED.md)
