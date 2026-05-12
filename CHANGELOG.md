# Changelog

## v1.0.0 → v1.1.0

### SKILL.md — Rewrite completo
- Convertido de formato `<skill_content>` XML a YAML frontmatter estándar.
- Agregado metadata completo (autor, versión, fases, licencia, compatibilidad).
- Steps expandidos con detalles por cada una de las 6 fases.
- Nuevas reglas de oro: no modificar diseño visual, fallbacks al texto original, 100% nativo sin ACF.
- Ahora compatible con OpenCode + OpenSpec.

### PLAYBOOK.md — Corrección menor
- Eliminada la mención específica a "IA como Kimi o Claude" en la sección "¿Qué resolvemos?" para generalizar el alcance del playbook.

### CHECKLISTS/ — Nuevo (6 archivos)
- checklists por fase: analysis, openspec, wp-backend, react-frontend, verification, ecommerce.

### openspec/ — Nuevo (13 archivos)
- Configuración OpenSpec completa (`config.yaml`).
- Change `playbook-v1.0.0` con:
  - Proposal + Design docs
  - Specs individuales: process-analysis, openspec-planning, wp-backend, react-frontend, verification-qa, ecommerce, playbook-maintenance
  - Tasks desglosados por fase

Sin cambios en: README, PHASES/, LOGS/, DIAGRAMS/, TEMPLATES/, STARTERS/, COPY-INSTRUCTIONS.md, TOOLS-REFERENCE.md.
