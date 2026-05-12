# Fase 2: OpenSpec Planning

> **Tiempo estimado:** 2-3 horas  
> **Entregable:** Change de OpenSpec con proposal, design, specs, tasks

---

## Objetivo

Crear la especificación formal del proyecto usando OpenSpec. Esto sirve como contrato entre el usuario y la IA: define QUÉ se va a hacer, CÓMO, y en qué orden.

## Flujo de OpenSpec

```
Usuario describe el proyecto
        ↓
Crear change: openspec new change "nombre"
        ↓
Generar artifacts en orden:
  1. proposal.md (qué y por qué)
  2. design.md (decisiones técnicas)
  3. specs/ (capabilities y requerimientos)
  4. tasks.md (micro-tareas)
        ↓
Usuario revisa y aprueba
        ↓
Implementar: /opsx-apply
        ↓
Completar tareas una por una
        ↓
Archivar: /opsx-archive
```

## Comandos de OpenSpec

### Crear un change

```bash
openspec new change "nombre-del-proyecto"
# Ejemplo:
openspec new change "sync-home-react-to-wp"
```

Esto crea:
```
openspec/changes/nombre-del-proyecto/
├── .openspec.yaml
├── proposal.md   (vacío)
├── design.md     (vacío)
├── specs/        (vacío)
└── tasks.md      (vacío)
```

### Ver estado del change

```bash
openspec status --change "nombre-del-proyecto" --json
```

Output esperado:
```json
{
  "changeName": "...",
  "schemaName": "spec-driven",
  "isComplete": false,
  "artifacts": [
    { "id": "proposal", "status": "ready" },
    { "id": "design", "status": "blocked" },
    { "id": "specs", "status": "blocked" },
    { "id": "tasks", "status": "blocked" }
  ]
}
```

### Generar instrucciones de un artifact

```bash
openspec instructions proposal --change "nombre" --json
openspec instructions design --change "nombre" --json
openspec instructions specs --change "nombre" --json
openspec instructions tasks --change "nombre" --json
```

### Aplicar el change (implementar tareas)

```bash
# Después de que el usuario apruebe
/opsx-apply nombre-del-proyecto
```

### Archivar el change

```bash
# Cuando todo está terminado
/opsx-archive nombre-del-proyecto
```

## Estructura de cada artifact

### proposal.md

```markdown
## Why

[Explicar el problema/oportunidad. Por qué se necesita este change.]

## What Changes

- [ ] Cambio 1
- [ ] Cambio 2
- [ ] Cambio 3

## Capabilities

### New Capabilities
- `capability-name`: Descripción

### Modified Capabilities
- (si aplica)

## Impact

[Afectados: WordPress, React, APIs, usuarios]
```

### design.md

```markdown
## Context

[Background del proyecto]

## Goals / Non-Goals

**Goals:**
- [ ] Lista de objetivos

**Non-Goals:**
- [ ] Lo que NO se va a hacer

## Decisions

### 1. Decisión A vs B
**Decision:** Elegimos A
**Rationale:** Por qué
**Alternativa:** B → Por qué no

## Risks / Trade-offs

- **[Risk]** Descripción → Mitigation: solución

## Migration Plan

1. Paso 1
2. Paso 2

## Open Questions

1. ¿Pregunta 1?
```

### specs/{capability}/spec.md

```markdown
## ADDED Requirements

### Requirement: Nombre del requerimiento
Descripción. El sistema SHALL...

#### Scenario: Escenario 1
- **WHEN** condición
- **THEN** resultado esperado

#### Scenario: Escenario 2
- **WHEN** condición
- **THEN** resultado esperado
```

**Nota importante:** Los scenarios DEBEN usar `####` (4 hashtags). Si usás 3 o bullets, OpenSpec no los reconoce.

### tasks.md

```markdown
## 1. Grupo de tareas

- [ ] 1.1 Tarea específica
- [ ] 1.2 Otra tarea

## 2. Otro grupo

- [ ] 2.1 Tarea
- [ ] 2.2 Tarea
```

**Regla:** Usar `- [ ]` para que OpenSpec pueda trackear el progreso.

## Reglas de Oro

1. **Nunca ejecutar tareas sin aprobación.** Después de crear proposal/design/specs/tasks, esperar el OK explícito del usuario.

2. **Leer contexto antes de implementar.** Siempre leer los artifacts de contexto antes de empezar a codear.

3. **Marcar tareas completadas.** Después de cada tarea, cambiar `- [ ]` a `- [x]`.

4. **Pausar ante ambigüedades.** Si algo no está claro, preguntar. No asumir.

## Errores comunes

**Error:** Empezar a implementar sin que el usuario apruebe el plan.
- **Solución:** Esperar explícitamente el "OK" o "/opsx-apply".

**Error:** No leer las instrucciones del artifact antes de crearlo.
- **Solución:** Siempre ejecutar `openspec instructions {artifact} --json` primero.

**Error:** Crear specs con formato incorrecto (3 hashtags en vez de 4).
- **Solución:** Verificar que los scenarios usen `#### Scenario: ...`.

---

## Checklist Fase 2

- [ ] Change creado con `openspec new change`
- [ ] proposal.md generado y completo
- [ ] design.md generado con decisiones técnicas
- [ ] specs/ creados con capabilities definidas
- [ ] tasks.md desglosado en micro-tareas
- [ ] Usuario revisó y aprobó el plan
- [ ] `/opsx-apply` ejecutado (con permiso del usuario)
