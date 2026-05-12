## ADDED Requirements

### Requirement: Auditoría del playbook
El sistema SHALL verificar que el playbook está completo, consistente y sin errores.

#### Scenario: Placeholders documentados
- **WHEN** se ejecuta la auditoría
- **THEN** el sistema MUST listar todos los placeholders (`{PREFIX}`, `{CLIENT}`, `{SLUG}`, `{THEME}`)
- **AND** verificar que cada uno está documentado en `COPY-INSTRUCTIONS.md`

#### Scenario: Templates validados
- **WHEN** se verifican los templates
- **THEN** cada template MUST tener estructura correcta y placeholders necesarios
- **AND** no debe haber placeholders sin documentar

#### Scenario: Checklists completas
- **WHEN** se revisan las checklists
- **THEN** `CHECKLISTS/` no debe estar vacío
- **AND** debe haber una checklist por fase del proceso

#### Scenario: Índice cruzado
- **WHEN** se genera el índice
- **THEN** el sistema MUST crear mapeo de qué fase menciona qué template
- **AND** verificar que todos los templates mencionados existen

#### Scenario: Errores con solución
- **WHEN** se revisa `ERRORS-LOG.md`
- **THEN** cada error MUST tener solución documentada
- **AND** la solución debe estar referenciada en alguna fase del playbook

### Requirement: Mejoras incrementales
El sistema SHALL permitir mejorar el playbook basándose en lecciones aprendidas de cada proyecto.

#### Scenario: Lección aprendida registrada
- **WHEN** se completa un proyecto usando el playbook
- **THEN** el sistema SHOULD actualizar `LOGS/LESSONS-LEARNED.md`
- **AND** si el proyecto expuso un nuevo error, agregarlo a `ERRORS-LOG.md`

#### Scenario: Template mejorado
- **WHEN** un template no cubrió un caso de uso
- **THEN** el sistema SHOULD actualizar el template
- **AND** actualizar la spec correspondiente para reflejar el cambio

## Validation Rules

- [ ] Todos los placeholders están documentados
- [ ] Todos los templates tienen estructura correcta
- [ ] `CHECKLISTS/` tiene contenido (no vacío)
- [ ] Índice cruzado fase-template está completo
- [ ] Todos los errores tienen solución documentada
- [ ] `TIME-ESTIMATES.md` está actualizado
- [ ] `DECISION-LOG.md` incluye rationale para cada decisión
- [ ] Versión del playbook está documentada

## Templates

- **Auditoría:** Ejecutar tareas del `tasks.md` de este change
- **Logs:** Ver `LOGS/` para estructura esperada
- **Mejoras:** Ver `LOGS/LESSONS-LEARNED.md` para formato