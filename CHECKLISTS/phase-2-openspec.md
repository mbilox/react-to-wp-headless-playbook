# Checklist — Fase 2: OpenSpec Planning

> **Objetivo:** Crear la especificación formal del proyecto con OpenSpec.
> **Tiempo estimado:** 2-3 horas

---

## Setup del Change

- [ ] Change creado con `openspec new change "nombre-del-proyecto"`
- [ ] Estructura generada: `.openspec.yaml`, `proposal.md`, `design.md`, `specs/`, `tasks.md`

## Proposal

- [ ] `proposal.md` generado y completo
- [ ] Sección "Why" explica el problema/oportunidad
- [ ] "What Changes" lista los cambios concretos
- [ ] Capabilities definidas (New y Modified)
- [ ] Impact documentado (WordPress, React, APIs, usuarios)

## Design

- [ ] `design.md` generado con decisiones técnicas
- [ ] Contexto del proyecto documentado
- [ ] Goals y Non-Goals definidos
- [ ] Decisiones con Rationale y Alternativas
- [ ] Risks/Trade-offs documentados con mitigations
- [ ] Migration Plan definido
- [ ] Open Questions respondidas

## Specs

- [ ] Specs/ creados con capabilities definidas
- [ ] Cada spec tiene requerimientos con `#### Scenario:`
- [ ] Scenarios usan WHEN/THEN con formato correcto
- [ ] Validation Rules incluidas
- [ ] Templates y ejemplos referenciados

## Tasks

- [ ] `tasks.md` desglosado en micro-tareas
- [ ] Cada tarea usa checkbox `- [ ]` para tracking
- [ ] Tareas agrupadas por área (WP Backend, React Frontend, etc.)
- [ ] Tasks en orden de ejecución lógico

## Aprobación

- [ ] Usuario revisó proposal, design, specs y tasks
- [ ] Usuario aprobó explícitamente el plan
- [ ] `/opsx-apply` ejecutado con permiso del usuario
- [ ] Ninguna tarea ejecutada sin aprobación previa

## Validación

- [ ] Todos los artifacts requeridos están presentes
- [ ] Scenarios usan `#### Scenario:` (4 hashtags)
- [ ] Tasks usan `- [ ]` para checkboxes
- [ ] Specs reflejan necesidades específicas del proyecto