# Fase 6: E-commerce (WooCommerce)

> **Tiempo estimado:** 2-4 horas (opcional)  
> **Entregable:** Tienda online integrada con React headless

---

## Objetivo

Si el proyecto incluye una tienda online, integrar WooCommerce con el frontend React en modo headless.

## Casos de uso

- **Product catalog:** Mostrar productos desde WooCommerce
- **Product detail:** Página de producto con variaciones
- **Cart:** Carrito de compras
- **Checkout:** Pasarela de pago headless
- **My account:** Historial de órdenes

## 6.1 Instalar WooCommerce

1. Instalar plugin WooCommerce en WordPress
2. Completar el setup wizard
3. Configurar productos, categorías, atributos

## 6.2 WooCommerce REST API

### Endpoints principales

```
GET /wp-json/wc/v3/products          ← Listado de productos
GET /wp-json/wc/v3/products/{id}     ← Producto individual
GET /wp-json/wc/v3/products/categories ← Categorías
GET /wp-json/wc/v3/orders            ← Órdenes (requiere auth)
POST /wp-json/wc/v3/orders           ← Crear orden (requiere auth)
```

### Autenticación

WooCommerce requiere autenticación para operaciones de escritura:

**Opción A: Consumer Key/Secret**
```bash
curl https://tusitio.com/wp-json/wc/v3/products \
  -u ck_XXXXXXXXX:cs_XXXXXXXXX
```

**Opción B: JWT Authentication**
```bash
# Obtener token
POST /wp-json/jwt-auth/v1/token
# Usar token en header
Authorization: Bearer {token}
```

## 6.3 Meta campos para productos

Extender productos de WooCommerce con meta campos personalizados:

```php
// En el mu-plugin
function {PREFIX}_register_product_meta(): void {
    register_post_meta('product', '{PREFIX}_product_extra', [
        'type'         => 'object',
        'single'       => true,
        'show_in_rest' => [
            'schema' => [
                'type'       => 'object',
                'properties' => [
                    'badge'          => ['type' => 'string'],
                    'shipping_time'  => ['type' => 'string'],
                    'custom_tabs'    => [
                        'type'  => 'array',
                        'items' => [
                            'type'       => 'object',
                            'properties' => [
                                'title'   => ['type' => 'string'],
                                'content' => ['type' => 'string'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);
}
add_action('init', '{PREFIX}_register_product_meta');
```

## 6.4 Frontend: Product Catalog

```typescript
// hooks/useProducts.ts
import { useState, useEffect } from "react";

interface Product {
  id: number;
  name: string;
  price: string;
  images: { src: string }[];
  // ... más campos
}

export function useProducts() {
  const [products, setProducts] = useState<Product[]>([]);
  
  useEffect(() => {
    fetch(`${API_URL}/wp-json/wc/v3/products?consumer_key=...&consumer_secret=...`)
      .then(r => r.json())
      .then(setProducts);
  }, []);
  
  return { products };
}
```

## 6.5 Frontend: Cart Headless

**Opción A:** Usar localStorage + WooCommerce REST API

```typescript
// hooks/useCart.ts
import { useState, useEffect } from "react";

interface CartItem {
  product_id: number;
  quantity: number;
}

export function useCart() {
  const [items, setItems] = useState<CartItem[]>(() => {
    const saved = localStorage.getItem("cart");
    return saved ? JSON.parse(saved) : [];
  });
  
  useEffect(() => {
    localStorage.setItem("cart", JSON.stringify(items));
  }, [items]);
  
  const addItem = (productId: number) => {
    setItems(prev => {
      const existing = prev.find(i => i.product_id === productId);
      if (existing) {
        return prev.map(i =>
          i.product_id === productId
            ? { ...i, quantity: i.quantity + 1 }
            : i
        );
      }
      return [...prev, { product_id: productId, quantity: 1 }];
    });
  };
  
  return { items, addItem };
}
```

**Opción B:** Usar WooCommerce Cart REST API (experimental)

```typescript
// WooCommerce 8.0+ tiene endpoints de cart
POST /wp-json/wc/store/cart/add-item
GET /wp-json/wc/store/cart
```

## 6.6 Checkout con Stripe (Headless)

```typescript
// components/Checkout.tsx
import { loadStripe } from "@stripe/stripe-js";

export default function Checkout() {
  const handlePayment = async () => {
    // 1. Crear orden en WooCommerce
    const order = await fetch(`${API_URL}/wp-json/wc/v3/orders`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        payment_method: "stripe",
        line_items: cartItems,
        // ... más datos
      }),
    }).then(r => r.json());
    
    // 2. Crear PaymentIntent con Stripe
    const stripe = await loadStripe(STRIPE_KEY);
    const { client_secret } = await fetch("/api/create-payment-intent", {
      method: "POST",
      body: JSON.stringify({ amount: order.total }),
    }).then(r => r.json());
    
    // 3. Confirmar pago
    await stripe.confirmCardPayment(client_secret);
    
    // 4. Redirigir a thank you page
  };
  
  return (
    <button onClick={handlePayment}>Pagar</button>
  );
}
```

## 6.7 Alternativas a WooCommerce REST API

**Opción A: WPGraphQL + WooGraphQL**
- Más flexible que REST
- Permite queries complejos
- Requiere instalar plugins adicionales

**Opción B: Shopify Buy Button / Storefront API**
- Si no querés manejar WordPress para e-commerce
- Más simple pero menos integrado

**Opción C: Snipcart**
- Solución headless para carrito
- Se integra con cualquier frontend
- Requiere cuenta en Snipcart

---

## Checklist Fase 6

- [ ] WooCommerce instalado y configurado
- [ ] Productos cargados en WordPress
- [ ] REST API de WooCommerce accesible
- [ ] Autenticación configurada
- [ ] Meta campos personalizados para productos (si aplica)
- [ ] Frontend muestra catálogo de productos
- [ ] Frontend muestra detalle de producto
- [ ] Carrito funcional
- [ ] Checkout integrado con pasarela de pago
- [ ] Órdenes se guardan en WooCommerce

---

## Errores comunes

**Error:** WooCommerce REST API devuelve 401
- **Causa:** Falta autenticación
- **Solución:** Generar Consumer Key/Secret en WooCommerce → Settings → Advanced → REST API

**Error:** Productos no se muestran en el frontend
- **Causa:** CORS o permisos incorrectos
- **Solución:** Verificar CORS en WordPress y permisos de la API

**Error:** Checkout no funciona
- **Causa:** Falta integración con pasarela de pago
- **Solución:** Configurar Stripe/MercadoPago/PayPal en WooCommerce y en el frontend

---

**Nota:** Esta fase es opcional. Solo aplicar si el proyecto incluye e-commerce.
