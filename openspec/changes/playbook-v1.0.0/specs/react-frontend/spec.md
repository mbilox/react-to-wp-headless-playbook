## ADDED Requirements

### Requirement: Hook useHomeData
El sistema SHALL implementar un hook de React que consuma la REST API de WordPress y exponga datos con estados loading/error.

#### Scenario: Hook implementado
- **WHEN** se ejecuta la fase 4
- **THEN** el sistema MUST crear `src/hooks/useHomeData.ts`
- **AND** el hook MUST retornar `{ data, loading, error }`

#### Scenario: Tipos TypeScript
- **WHEN** se crea el hook
- **THEN** el sistema MUST definir interfaces para todos los meta campos
- **AND** los tipos deben coincidir con el JSON Schema del backend

#### Scenario: Fetch con fallback
- **WHEN** se consume la API
- **THEN** el sistema MUST usar `fetch` nativo
- **AND** si la API falla, mostrar error descriptivo
- **AND** si no hay datos, retornar objeto vacío (no null)

### Requirement: Refactor de componentes
El sistema SHALL modificar todos los componentes de sección para recibir props del meta con fallbacks al texto original.

#### Scenario: Props dinámicas
- **WHEN** se refactoriza un componente
- **THEN** el sistema MUST reemplazar texto hardcodeado por `meta.field || FALLBACK.field`
- **AND** cada componente MUST tener un objeto FALLBACK con el texto original

#### Scenario: Preservación de animaciones
- **WHEN** se modifica un componente con animaciones GSAP
- **THEN** el sistema MUST mantener todos los refs y timelines intactos
- **AND** inicializar GSAP solo cuando `loading === false`

#### Scenario: App.tsx modificado
- **WHEN** se completa el refactor
- **THEN** `App.tsx` MUST usar `useHomeData()` y pasar `meta` por props
- **AND** MUST manejar estados de loading y error

#### Scenario: Build exitoso
- **WHEN** se ejecuta `npm run build`
- **THEN** el build MUST pasar sin errores de TypeScript
- **AND** sin errores de ESLint

## Validation Rules

- [ ] Hook `useHomeData` implementado con estados loading/error
- [ ] Tipos TypeScript creados para todos los meta campos
- [ ] Todos los componentes reciben props del meta
- [ ] Cada componente tiene fallback al texto original
- [ ] Animaciones GSAP preservadas intactas
- [ ] `App.tsx` usa el hook y pasa datos por props
- [ ] `npm run build` pasa sin errores
- [ ] `.env` configurado con `VITE_WP_API_URL`

## Templates

- **Hook:** `STARTERS/react-frontend/useHomeData.ts`
- **Tipos:** `TEMPLATES/react-types.ts`
- **Sección:** `TEMPLATES/react-section.tsx`
- **Ejemplo completo:** Ver `app/src/hooks/useHomeData.ts` en proyecto WE Digital