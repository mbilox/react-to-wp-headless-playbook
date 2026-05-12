## ADDED Requirements

### Requirement: Verificación completa
El sistema SHALL verificar que el build pasa, la REST API responde, el diseño se mantiene, y los fallbacks funcionan.

#### Scenario: Build de producción
- **WHEN** se ejecuta `npm run build`
- **THEN** el build MUST completarse sin errores de TypeScript
- **AND** sin warnings críticos

#### Scenario: REST API validada
- **WHEN** se verifica el endpoint
- **THEN** `curl http://localhost:8882/wp-json/wp/v2/pages?slug={SLUG}` MUST retornar JSON con campo `meta`
- **AND** los meta campos deben tener estructura correcta

#### Scenario: Screenshots visuales
- **WHEN** se verifica el diseño
- **THEN** el sistema MUST tomar screenshots con `agent-browser`
- **AND** comparar visualmente que el diseño se mantiene al 100%

#### Scenario: Edición desde WordPress
- **WHEN** se edita un campo en el metabox
- **THEN** el cambio MUST reflejarse en el frontend React después de recargar

#### Scenario: Fallbacks funcionando
- **WHEN** se vacía un campo meta en WordPress
- **THEN** el frontend MUST mostrar el texto estático original
- **AND** no debe quedar en blanco ni mostrar errores

#### Scenario: Animaciones verificadas
- **WHEN** se hace scroll por la página
- **THEN** todas las animaciones GSAP deben funcionar correctamente
- **AND** no debe haber errores en consola

#### Scenario: Responsive
- **WHEN** se redimensiona el navegador
- **THEN** el diseño debe adaptarse correctamente a mobile, tablet y desktop

## Validation Rules

- [ ] `npm run build` pasa sin errores
- [ ] REST API devuelve datos correctos
- [ ] Screenshots capturados y verificados
- [ ] Cambios en WordPress se reflejan en React
- [ ] Fallbacks funcionan cuando campos están vacíos
- [ ] Animaciones GSAP funcionan con datos dinámicos
- [ ] Responsive correcto en todos los breakpoints
- [ ] No hay errores en consola del navegador

## Tools

- **Screenshots:** `agent-browser screenshot page.png --full`
- **REST API:** `curl http://localhost:8882/wp-json/wp/v2/pages?slug={SLUG}`
- **Build:** `npm run build`
- **Ejemplo:** Ver `PHASES/PHASE-5-VERIFICATION.md`