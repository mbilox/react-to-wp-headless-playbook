## ADDED Requirements

### Requirement: Creación de change de OpenSpec
El proceso SHALL crear un change de OpenSpec completo con proposal, design, specs y tasks para el proyecto específico.

#### Scenario: Change creado correctamente
- **WHEN** un usuario inicia la fase de planning
- **THEN** el sistema MUST ejecutar `openspec new change "nombre-del-proyecto"`
- **AND** generar la estructura: `.openspec.yaml`, `proposal.md`, `design.md`, `specs/`, `tasks.md`

#### Scenario: Proposal generado
- **WHEN** se crea el change
- **THEN** el sistema MUST generar `proposal.md` con: Why, What Changes, Capabilities, Impact
- **AND** las capabilities deben reflejar las necesidades del proyecto específico

#### Scenario: Design con decisiones
- **WHEN** se genera el design
- **THEN** el sistema MUST documentar decisiones técnicas (mu-plugin vs plugin, fetch vs axios, etc.)
- **AND** incluir Goals, Non-Goals, Risks y Migration Plan

#### Scenario: Specs con scenarios
- **WHEN** se generan las specs
- **THEN** cada spec MUST tener requerimientos con scenarios usando `#### Scenario:`
- **AND** los scenarios MUST usar WHEN/THEN con el formato requerido por OpenSpec

#### Scenario: Tasks desglosadas
- **WHEN** se generan las tasks
- **THEN** cada task MUST usar checkbox `- [ ]` para tracking
- **AND** las tasks deben estar agrupadas por área (WP Backend, React Frontend, etc.)

### Requirement: Espera de aprobación
El proceso SHALL esperar aprobación explícita del usuario antes de ejecutar tareas.

#### Scenario: Usuario aprueba
- **WHEN** todos los artifacts están generados
- **THEN** el sistema MUST mostrar resumen y pedir confirmación
- **AND** solo ejecutar `/opsx-apply` cuando el usuario dé OK explícito

## Validation Rules

- [ ] El change se crea con `openspec new change`
- [ ] Todos los artifacts requeridos están presentes
- [ ] Los scenarios usan `#### Scenario:` (4 hashtags)
- [ ] Las tasks usan `- [ ]` para checkboxes
- [ ] El usuario confirma antes de implementar
- [ ] Las specs reflejan las necesidades específicas del proyecto (no genéricas)

## Templates

- **Comando:** `openspec new change "nombre"`
- **Estructura:** Ver `PHASES/PHASE-2-OPENSPEC.md`
- **Formato scenarios:** `#### Scenario: Nombre` con WHEN/THEN
- **Ejemplo:** Ver `openspec/changes/archive/2026-05-11-sync-home-react-to-wp/`