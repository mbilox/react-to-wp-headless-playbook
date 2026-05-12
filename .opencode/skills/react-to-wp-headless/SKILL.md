<skill_content name="react-to-wp-headless">
# Skill: react-to-wp-headless

Convierte un sitio React estático en un headless CMS administrado por WordPress.
Basado en el Playbook de WE Digital Agency.

**Input**: Ejecutar con `/adapt-react-to-wp <nombre-proyecto>` o sin argumentos para iniciar el asistente interactivo.

**Steps**

1. **Si no hay nombre de proyecto, preguntar**
   Usar **AskUserQuestion tool** para solicitar:
   - Nombre del proyecto (prefijo para namespace, ej: `acme`)
   - Ruta de la instalación de WordPress
   - Ruta del frontend React

2. **Validar requisitos**
   Verificar que las rutas existen usando herramientas de sistema de archivos.
   Si no existen, advertir al usuario y pausar.

3. **Ejecutar Fase 1: Análisis (Solo lectura)**
   Escanear el directorio React (`/src/sections` o similar) buscando componentes.
   Extraer textos estáticos y proponer un mapeo inicial.
   Mostrar el mapeo al usuario y pedir aprobación para continuar.

4. **Ejecutar Fase 2: OpenSpec Planning**
   Usar la skill `openspec-propose` para crear un change formal.
   El change debe incluir las capabilities: `wp-admin-metabox`, `react-data-hook`.
   Esperar aprobación del usuario sobre el proposal.

5. **Ejecutar Fase 3: WordPress Backend**
   Una vez aprobado, usar `openspec-apply-change`.
   - Copiar `react-to-wp-headless-playbook/TEMPLATES/mu-plugin-template.php` al dir de wp-content/mu-plugins
   - Reemplazar `{PREFIX}`, `{CLIENT}`, etc.
   - Copiar estilos y scripts del metabox
   - Crear `home-template.php` en el tema activo
   - Verificar REST API con llamada HTTP o WP MCP

6. **Ejecutar Fase 4: React Frontend**
   - Crear `types/home-meta.ts` basado en el template
   - Crear `hooks/useHomeData.ts` basado en el template
   - Refactorizar 1-2 componentes iniciales (ej: Hero) para mostrar cómo se hace
   - Dejar el resto como tareas en OpenSpec para el desarrollador/IA

7. **Ejecutar Fase 5: Verificación**
   - Ejecutar `npm run build` en el dir de React
   - Tomar screenshots con `agent-browser` (si está disponible)
   - Finalizar el proceso con instrucciones claras de los próximos pasos

**Reglas Críticas**
- NUNCA sobreescribir archivos sin confirmar si ya existen.
- Siempre usar prefijos en las funciones PHP (`{PREFIX}_register_meta_fields`).
- Los componentes React SIEMPRE deben tener fallbacks (`const title = meta?.title || "Texto Original"`).
- Siempre crear el mu-plugin, NUNCA modificar el `functions.php` del tema para esto.

Base directory: `react-to-wp-headless-playbook/`
Templates disponibles en: `react-to-wp-headless-playbook/TEMPLATES/`
Documentación completa en: `react-to-wp-headless-playbook/PLAYBOOK.md`
</skill_content>