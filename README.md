# React to WordPress Headless — SKILL HÍBRIDO

> **Versión:** 1.0.0  
> **Autor:** Bilox  
> **Fecha:** Mayo 2026  
> **Proyecto de referencia:** theme-wordpress (Digital Agency)

---

## ¿Qué es esto?

Este es un **proceso híbrido documentado** que permite convertir cualquier sitio estático hecho en **React** en un sitio **headless** administrado por **WordPress**.

No usamos ACF ni plugins de custom fields. Todo es **100% nativo**: metaboxes, repeaters, Media Frame, REST API.

## Estructura de esta documentación

```
react-to-wp-headless-playbook/
├── README.md                 ← Este archivo (índice)
├── PLAYBOOK.md               ← Guía maestro paso a paso
├── DIAGRAMS/                 ← Diagramas Mermaid
├── PHASES/                   ← Fases del proceso (1 al 6)
├── TEMPLATES/                ← Código base configurable
├── STARTERS/                 ← Starters listos para copiar
├── CHECKLISTS/               ← Checklist por fase
├── LOGS/                     ← Errores, decisiones, lecciones
├── TOOLS-REFERENCE.md        ← Plugins, skills, repos
├── .opencode/skills/         ← Skill custom para OpenCode
└── COPY-INSTRUCTIONS.md      ← Cómo llevar esto a otro proyecto
```

## Flujo rápido (TL;DR)

1. **Analizar** el diseño React y mapear secciones → meta campos
2. **Crear** un change en OpenSpec con proposal/design/specs/tasks
3. **Construir** el backend WordPress (mu-plugin + metabox nativo)
4. **Adaptar** el frontend React (hook `useHomeData` + props + fallbacks)
5. **Verificar** con build, REST API, screenshots (agent-browser)
6. **Archivar** el change y documentar

## Tiempo estimado total

| Fase | Tiempo estimado |
|------|----------------|
| 1. Análisis | 1-2h |
| 2. OpenSpec | 2-3h |
| 3. WordPress Backend | 4-6h |
| 4. React Frontend | 3-4h |
| 5. Verificación | 2-3h |
| 6. E-commerce (opcional) | 2-4h |
| **Total** | **14-22h** |

## Prerrequisitos

- Node.js 20+
- WordPress 6.9+ instalado
- Proyecto React con Vite/Next.js
- Conocimiento básico de PHP y TypeScript
- OpenCode CLI con skills de OpenSpec

## Cómo usar este skill en otro proyecto

Ver archivo: [`COPY-INSTRUCTIONS.md`](./COPY-INSTRUCTIONS.md)

## Créditos y herramientas

Ver archivo: [`TOOLS-REFERENCE.md`](./TOOLS-REFERENCE.md)

---

**¿Listo para empezar?** Abre [`PLAYBOOK.md`](./PLAYBOOK.md) y sigue el flujo completo.
