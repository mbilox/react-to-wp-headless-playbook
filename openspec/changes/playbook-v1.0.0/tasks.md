## 1. Auditoría del Playbook

- [ ] 1.1 Listar todos los placeholders ({PREFIX}, {CLIENT}, {SLUG}, {THEME}) en TEMPLATES/
- [ ] 1.2 Verificar que cada placeholder está documentado en COPY-INSTRUCTIONS.md
- [ ] 1.3 Verificar que CHECKLISTS/ tiene al menos una checklist por fase
- [ ] 1.4 Generar índice cruzado: qué fase menciona qué template
- [ ] 1.5 Verificar que todos los errores de ERRORS-LOG.md tienen solución documentada
- [ ] 1.6 Verificar que TIME-ESTIMATES.md está actualizado con datos reales
- [ ] 1.7 Verificar que todos los links internos entre archivos funcionan

## 2. Validación de Templates

- [ ] 2.1 Verificar que home-template.php tiene estructura correcta (header, content, footer)
- [ ] 2.2 Verificar que mu-plugin-template.php tiene: register_post_meta, metabox, save_post, CORS
- [ ] 2.3 Verificar que react-types.ts tiene interfaces para todas las secciones
- [ ] 2.4 Verificar que react-section.tsx tiene patrón de fallback
- [ ] 2.5 Verificar que admin-metabox.css tiene estilos básicos para el metabox
- [ ] 2.6 Verificar que admin-metabox.js tiene funciones para Media Frame y repeaters
- [ ] 2.7 Validar que todos los templates usan placeholders consistentes

## 3. Creación de Checklists

- [ ] 3.1 Crear CHECKLISTS/phase-1-analysis.md
- [ ] 3.2 Crear CHECKLISTS/phase-2-openspec.md
- [ ] 3.3 Crear CHECKLISTS/phase-3-wp-backend.md
- [ ] 3.4 Crear CHECKLISTS/phase-4-react-frontend.md
- [ ] 3.5 Crear CHECKLISTS/phase-5-verification.md
- [ ] 3.6 Crear CHECKLISTS/phase-6-ecommerce.md (opcional)

## 4. Mejoras de Documentación

- [ ] 4.1 Agregar tabla de contenido a PLAYBOOK.md
- [ ] 4.2 Verificar que todos los diagramas en DIAGRAMS/ están referenciados
- [ ] 4.3 Actualizar README.md con instrucciones de uso de la skill
- [ ] 4.4 Documentar cómo contribuir al playbook (CONTRIBUTING.md)
- [ ] 4.5 Agregar changelog (CHANGELOG.md)

## 5. Testing del Playbook

- [ ] 5.1 Probar el playbook en un proyecto React nuevo
- [ ] 5.2 Documentar tiempo real vs estimado
- [ ] 5.3 Registrar errores encontrados durante el test
- [ ] 5.4 Actualizar LESSONS-LEARNED.md con nuevas lecciones
- [ ] 5.5 Verificar que la skill de OpenCode funciona end-to-end

## 6. Release v1.0.0

- [ ] 6.1 Verificar que todos los artifacts de OpenSpec están completos
- [ ] 6.2 Verificar que la skill SKILL.md tiene instrucciones claras
- [ ] 6.3 Taggear versión en git (si aplica)
- [ ] 6.4 Archivar change con /opsx-archive
- [ ] 6.5 Celebrar 🎉