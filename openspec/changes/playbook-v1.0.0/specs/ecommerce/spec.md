## ADDED Requirements

### Requirement: Integración WooCommerce (Opcional)
El sistema SHALL integrar WooCommerce para proyectos que requieran tienda online, consumiendo la REST API de WooCommerce desde React.

#### Scenario: WooCommerce instalado
- **WHEN** el proyecto requiere e-commerce
- **THEN** el sistema MUST instalar y configurar WooCommerce en WordPress
- **AND** crear productos, categorías y atributos

#### Scenario: Product catalog
- **WHEN** se consume la API de WooCommerce
- **THEN** el frontend MUST mostrar catálogo de productos
- **AND** cada producto debe mostrar nombre, precio e imagen

#### Scenario: Cart headless
- **WHEN** el usuario agrega productos al carrito
- **THEN** el sistema MUST mantener el carrito en localStorage o usar Cart API de WooCommerce
- **AND** permitir modificar cantidades y eliminar items

#### Scenario: Checkout
- **WHEN** el usuario finaliza la compra
- **THEN** el sistema MUST integrar pasarela de pago (Stripe, MercadoPago, etc.)
- **AND** crear orden en WooCommerce

## Validation Rules

- [ ] WooCommerce instalado y configurado
- [ ] Productos cargados en WordPress
- [ ] REST API de WooCommerce accesible
- [ ] Frontend muestra catálogo de productos
- [ ] Frontend muestra detalle de producto
- [ ] Carrito funcional
- [ ] Checkout integrado con pasarela de pago
- [ ] Órdenes se guardan en WooCommerce

## Templates

- **Referencia:** Ver `PHASES/PHASE-6-ECOMMERCE.md`
- **Nota:** Esta fase es opcional y solo aplica si el proyecto incluye e-commerce
- **Auth:** Se requiere Consumer Key/Secret o JWT Authentication