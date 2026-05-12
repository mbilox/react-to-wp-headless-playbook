# Fase 4: React Frontend

> **Tiempo estimado:** 3-4 horas  
> **Entregable:** Frontend React consumiendo datos dinámicos de WordPress

---

## Objetivo

Adaptar el frontend React para que consuma datos de WordPress via REST API, manteniendo el diseño visual al 100% y preservando todas las animaciones.

---

## 4.1 Crear tipos TypeScript

Crear archivo: `src/types/home-meta.ts`

```typescript
// Tipos para meta campos de WordPress

export interface HeroMeta {
  label: string;
  headline: string;
  subtitle: string;
  cta_primary_text: string;
  cta_primary_url: string;
  cta_secondary_text: string;
  cta_secondary_url: string;
  video_url: string;
  image_id?: number;
}

export interface ServiceItem {
  title: string;
  description: string;
  items: string[];
  icon: string;
}

export interface RoomsMeta {
  section_label: string;
  section_title: string;
  services: ServiceItem[];
}

export interface ProcessStep {
  number: string;
  title: string;
  description: string;
}

export interface ProjectItem {
  client: string;
  stat: string;
  statLabel: string;
  description: string;
  subStat: string;
  services: string[];
}

export interface AboutStat {
  value: number;
  prefix: string;
  suffix: string;
  label: string;
}

export interface FooterLink {
  label: string;
  href: string;
}

export interface SocialLink {
  label: string;
  url: string;
}

export interface SurfInfoMeta {
  process_label: string;
  process_title: string;
  steps: ProcessStep[];
  projects_label: string;
  projects_title: string;
  projects: ProjectItem[];
  about_label: string;
  about_title: string;
  about_paragraphs: string[];
  stats: AboutStat[];
  closing_headline: string;
  closing_cta_text: string;
  closing_cta_url: string;
  footer_tagline: string;
  footer_solutions: string[];
  footer_empresa: FooterLink[];
  footer_cta_text: string;
  footer_social: SocialLink[];
}

export interface HomeMetaData {
  {PREFIX}_hero: HeroMeta;
  {PREFIX}_rooms: RoomsMeta;
  {PREFIX}_surf_info: SurfInfoMeta;
}
```

## 4.2 Implementar hook `useHomeData()`

Crear archivo: `src/hooks/useHomeData.ts`

```typescript
import { useState, useEffect } from "react";
import type { HomeMetaData } from "../types/home-meta";

interface UseHomeDataReturn {
  data: HomeMetaData | null;
  loading: boolean;
  error: Error | null;
}

const WP_API_URL =
  import.meta.env.VITE_WP_API_URL || "http://localhost:8882/wp-json";

export function useHomeData(): UseHomeDataReturn {
  const [data, setData] = useState<HomeMetaData | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<Error | null>(null);

  useEffect(() => {
    let cancelled = false;

    async function fetchHomeData() {
      try {
        setLoading(true);
        setError(null);

        const response = await fetch(
          `${WP_API_URL}/wp/v2/pages?slug={SLUG_DE_LA_PAGINA}&_embed=1`
        );

        if (!response.ok) {
          throw new Error(`Error ${response.status}: ${response.statusText}`);
        }

        const pages = await response.json();

        if (!Array.isArray(pages) || pages.length === 0) {
          throw new Error("No se encontró la página de inicio");
        }

        const page = pages[0];
        const meta = page.meta;

        if (!meta) {
          throw new Error("La página no tiene meta campos definidos");
        }

        if (!cancelled) {
          setData({
            {PREFIX}_hero: meta.{PREFIX}_hero || {},
            {PREFIX}_rooms: meta.{PREFIX}_rooms || {},
            {PREFIX}_surf_info: meta.{PREFIX}_surf_info || {},
          });
        }
      } catch (err) {
        if (!cancelled) {
          setError(
            err instanceof Error
              ? err
              : new Error("Error desconocido al cargar los datos")
          );
        }
      } finally {
        if (!cancelled) {
          setLoading(false);
        }
      }
    }

    fetchHomeData();

    return () => {
      cancelled = true;
    };
  }, []);

  return { data, loading, error };
}
```

**Notas importantes:**
- Usar `{SLUG_DE_LA_PAGINA}` — Ej: `sample-page`, `home`, `inicio`
- Usar `{PREFIX}` — Ej: `wetheme`, `acme`, `clientname`
- El fallback `|| {}` asegura que no haya errores si un campo está vacío

## 4.3 Modificar `App.tsx`

```typescript
import { useEffect } from "react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useHomeData } from "./hooks/useHomeData";
import Navbar from "./sections/Navbar";
import Hero from "./sections/Hero";
import Services from "./sections/Services";
// ... más imports

gsap.registerPlugin(ScrollTrigger);

function App() {
  const { data, loading, error } = useHomeData();

  useEffect(() => {
    if (!loading) {
      ScrollTrigger.refresh();
    }
    // Cleanup...
  }, [loading]);

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div>Cargando...</div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-red-500">Error: {error.message}</div>
      </div>
    );
  }

  const meta = data!;

  return (
    <div className="relative bg-dark min-h-screen">
      <Navbar />
      <main>
        <Hero meta={meta.{PREFIX}_hero} />
        <Services meta={meta.{PREFIX}_rooms} />
        <Process meta={meta.{PREFIX}_surf_info} />
        <Projects meta={meta.{PREFIX}_surf_info} />
        <About meta={meta.{PREFIX}_surf_info} />
        <Closing meta={meta.{PREFIX}_surf_info} />
      </main>
      <Footer meta={meta.{PREFIX}_surf_info} />
    </div>
  );
}

export default App;
```

## 4.4 Refactorizar secciones con props y fallbacks

Ejemplo completo: `src/sections/Hero.tsx`

```typescript
import { useEffect, useRef } from "react";
import gsap from "gsap";
import type { HeroMeta } from "../types/home-meta";

interface HeroProps {
  meta: HeroMeta;
}

// Fallbacks — texto estático original
const FALLBACK = {
  label: "Agencia Digital",
  headline: "SOMOS EL MOTOR DIGITAL DETRÁS DE LAS MARCAS QUE ESCALAN.",
  subtitle: "Integramos estrategia, marketing, webs, tecnología, datos e IA...",
  cta_primary_text: "Conversemos",
  cta_primary_url: "#contacto",
  cta_secondary_text: "Nuestras Soluciones",
  cta_secondary_url: "#servicios",
  video_url: "/hero-video.mp4",
};

export default function Hero({ meta }: HeroProps) {
  const sectionRef = useRef<HTMLElement>(null);
  // ... más refs para animaciones

  // Usar meta si existe, sino fallback
  const label = meta?.label || FALLBACK.label;
  const headline = meta?.headline || FALLBACK.headline;
  const subtitle = meta?.subtitle || FALLBACK.subtitle;
  const ctaPrimaryText = meta?.cta_primary_text || FALLBACK.cta_primary_text;
  const ctaPrimaryUrl = meta?.cta_primary_url || FALLBACK.cta_primary_url;
  const ctaSecondaryText = meta?.cta_secondary_text || FALLBACK.cta_secondary_text;
  const ctaSecondaryUrl = meta?.cta_secondary_url || FALLBACK.cta_secondary_url;
  const videoUrl = meta?.video_url || FALLBACK.video_url;

  useEffect(() => {
    // Animaciones GSAP — sin cambios
    const ctx = gsap.context(() => {
      // ... timeline y animaciones
    }, sectionRef);

    return () => ctx.revert();
  }, []);

  return (
    <section ref={sectionRef} className="...">
      <video src={videoUrl} autoPlay muted loop />
      <p>{label}</p>
      <h1>{headline}</h1>
      <p>{subtitle}</p>
      <a href={ctaSecondaryUrl}>{ctaSecondaryText}</a>
      <a href={ctaPrimaryUrl}>{ctaPrimaryText}</a>
    </section>
  );
}
```

### Patrón para repeaters

```typescript
// Services.tsx con repeater de services
interface ServicesProps {
  meta: RoomsMeta;
}

const FALLBACK_SERVICES = [
  { title: "Branding", description: "...", items: [...], icon: "branding" },
  // ... más servicios
];

export default function Services({ meta }: ServicesProps) {
  const sectionLabel = meta?.section_label || "Servicios";
  const sectionTitle = meta?.section_title || "¿QUÉ HACEMOS?";
  const services = meta?.services?.length > 0 
    ? meta.services 
    : FALLBACK_SERVICES;

  return (
    <section>
      <p>{sectionLabel}</p>
      <h2>{sectionTitle}</h2>
      
      {services.map((service, i) => (
        <div key={service.title || i}>
          <Icon name={service.icon} />
          <h3>{service.title}</h3>
          <p>{service.description}</p>
          <ul>
            {service.items.map((item) => (
              <li key={item}>{item}</li>
            ))}
          </ul>
        </div>
      ))}
    </section>
  );
}
```

### Patrón para stats/contadores

```typescript
// About.tsx con stats animados
interface AboutProps {
  meta: SurfInfoMeta;
}

const FALLBACK_STATS = [
  { value: 500, prefix: "+", suffix: "%", label: "crecimiento..." },
  // ... más stats
];

export default function About({ meta }: AboutProps) {
  const stats = meta?.stats?.length > 0 
    ? meta.stats 
    : FALLBACK_STATS;

  return (
    <section>
      {stats.map((stat) => (
        <div key={stat.label}>
          <span>{stat.prefix}{stat.value}{stat.suffix}</span>
          <p>{stat.label}</p>
        </div>
      ))}
    </section>
  );
}
```

## 4.5 Preservar animaciones GSAP

**Regla de oro:** No modificar las animaciones. Solo asegurar que:

1. Los refs (`useRef`) siguen apuntando a los elementos correctos
2. Los `useEffect` o `useLayoutEffect` se ejecutan después de que los datos carguen
3. El contenido dinámico no rompe los selectores de GSAP

```typescript
useEffect(() => {
  if (loading) return; // Esperar a que los datos carguen
  
  const ctx = gsap.context(() => {
    // Animaciones aquí
    gsap.fromTo(headlineRef.current, 
      { opacity: 0 },
      { opacity: 1, duration: 1 }
    );
    
    ScrollTrigger.create({
      trigger: sectionRef.current,
      // ... configuración
    });
  }, sectionRef);

  return () => ctx.revert();
}, [loading]); // Dependencia en loading
```

## 4.6 Configurar `.env`

Crear archivo: `.env` (en la raíz del proyecto React)

```env
VITE_WP_API_URL=http://localhost:8882/wp-json
```

**Nota:** Vite expone automáticamente variables que empiezan con `VITE_`.

En producción:
```env
VITE_WP_API_URL=https://tusitio.com/wp-json
```

## 4.7 Build de producción

```bash
npm run build
```

Debe pasar sin errores de TypeScript.

---

## Checklist Fase 4

- [ ] Tipos TypeScript creados para todos los meta campos
- [ ] Hook `useHomeData()` implementado
- [ ] `App.tsx` modificado para usar el hook
- [ ] Todas las secciones reciben props del meta
- [ ] Fallbacks implementados en cada componente
- [ ] Animaciones GSAP preservadas intactas
- [ ] `.env` configurado con `VITE_WP_API_URL`
- [ ] `npm run build` pasa sin errores
- [ ] El frontend carga datos de WordPress correctamente
- [ ] El diseño visual se mantiene al 100%

---

## Errores comunes

**Error:** TypeScript errors en los tipos
- **Causa:** Los tipos no coinciden con la estructura real de la API
- **Solución:** Verificar la respuesta real de la API y ajustar tipos

**Error:** Los componentes no reciben datos
- **Causa:** El hook no encuentra la página o el slug es incorrecto
- **Solución:** Verificar el slug en `useHomeData()` y en WordPress

**Error:** Animaciones GSAP no funcionan
- **Causa:** Los refs apuntan a null porque el contenido no cargó aún
- **Solución:** Esperar a `loading === false` antes de inicializar GSAP

**Error:** CORS bloquea las peticiones
- **Causa:** WordPress no acepta el origen del dev server
- **Solución:** Verificar headers CORS en el mu-plugin

---

## Verificación

```bash
# Verificar que el build pasa
npm run build

# Verificar que la app carga datos
# Abrir http://localhost:3000 y revisar console/network

# Verificar REST API
curl http://localhost:8882/wp-json/wp/v2/pages?slug={SLUG}
```
