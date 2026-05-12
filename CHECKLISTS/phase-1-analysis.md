# Checklist — Fase 1: Análisis del Diseño React

> **Objetivo:** Entender el sitio React al 100% antes de tocar código.
> **Tiempo estimado:** 1-2 horas

---

## Secciones

- [ ] Todas las secciones del sitio listadas (Hero, Services, About, etc.)
- [ ] Archivos de sección identificados en `src/sections/`, `src/pages/`, `src/components/`
- [ ] Componentes de sección diferenciados de componentes UI

## Texto Estático

- [ ] Todo texto hardcodeado extraído de cada componente
- [ ] Textos clasificados por tipo (título, subtítulo, CTA, label)
- [ ] Strings entre comillas identificados con grep/rg

## Assets

- [ ] Todas las imágenes detectadas
- [ ] Videos identificados
- [ ] SVGs y logos listados
- [ ] Assets categorizados (backgrounds, logos, icons, galerías)

## Listas Dinámicas

- [ ] Arrays de datos identificados (servicios, pasos, proyectos, stats)
- [ ] Estructura de cada elemento del array documentada
- [ ] Listas anidadas detectadas (items dentro de servicios)

## Animaciones

- [ ] Librerías de animación identificadas (GSAP, Framer Motion, etc.)
- [ ] Animaciones que dependen del contenido documentadas
- [ ] Efectos que podrían romperse con contenido dinámico marcados

## Mapeo

- [ ] Tabla de mapeo creada: Componente | Texto Estático | Clave Meta | Tipo
- [ ] Estructura de meta campos definida (3-5 campos principales)
- [ ] JSON Schema preliminar para cada meta campo

## Validación

- [ ] Mapeo revisado con el usuario/cliente
- [ ] Secciones, texto, assets, listas y animaciones cubiertas al 100%
- [ ] Documento `MAPPING.md` generado y guardado