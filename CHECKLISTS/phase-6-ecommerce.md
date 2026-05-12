# Checklist — Fase 6: E-commerce (Opcional)

> **Objetivo:** Integrar WooCommerce para proyectos con tienda online.
> **Tiempo estimado:** 2-4 horas
> **Nota:** Solo aplicar si el proyecto incluye e-commerce.

---

## WooCommerce Setup

- [ ] WooCommerce instalado en WordPress
- [ ] Setup wizard completado
- [ ] Productos creados y configurados
- [ ] Categorías y atributos definidos
- [ ] Configuración de envío y impuestos

## REST API WooCommerce

- [ ] REST API de WooCommerce accesible
- [ ] Endpoints principales funcionan:
  - [ ] `GET /wp-json/wc/v3/products`
  - [ ] `GET /wp-json/wc/v3/products/{id}`
  - [ ] `GET /wp-json/wc/v3/products/categories`
- [ ] Autenticación configurada (Consumer Key/Secret o JWT)

## Meta Campos Productos

- [ ] Meta campos personalizados registrados para productos
- [ ] Schema JSON definido para campos extra
- [ ] `show_in_rest` configurado

## Frontend: Catálogo

- [ ] Hook `useProducts()` implementado
- [ ] Productos se muestran en grid/lista
- [ ] Cada producto muestra: nombre, precio, imagen
- [ ] Filtros por categoría funcionan
- [ ] Paginación implementada (si aplica)

## Frontend: Detalle de Producto

- [ ] Página de producto individual creada
- [ ] Imagen principal y galería
- [ ] Descripción y especificaciones
- [ ] Variaciones (talla, color, etc.)
- [ ] Precio y disponibilidad

## Carrito

- [ ] Estado del carrito implementado
- [ ] Botón "Agregar al carrito" funciona
- [ ] Carrito persistente (localStorage o Cart API)
- [ ] Modificar cantidades
- [ ] Eliminar items
- [ ] Total calculado correctamente

## Checkout

- [ ] Formulario de checkout creado
- [ ] Datos del cliente validados
- [ ] Pasarela de pago integrada (Stripe, MercadoPago, PayPal)
- [ ] Orden creada en WooCommerce
- [ ] Email de confirmación enviado
- [ ] Redirección a página de gracias

## Mi Cuenta

- [ ] Historial de órdenes visible
- [ ] Detalle de cada orden
- [ ] Direcciones de envío guardadas
- [ ] Perfil editable

## Testing

- [ ] Flujo completo de compra testeado
- [ ] Pago con tarjeta de prueba funciona
- [ ] Orden aparece en WordPress Admin
- [ ] Stock se actualiza correctamente
- [ ] Email de confirmación recibido

## Documentación

- [ ] API keys documentadas (seguro, no en repo)
- [ ] Pasarela de pago configurada documentada
- [ ] Webhooks configurados (si aplica)
- [ ] Proceso de checkout documentado para usuarios