import { useHomeData } from "../hooks/useHomeData";

/**
 * Ejemplo de un componente React que consume los meta campos de WordPress
 * con fallbacks incorporados.
 */

// 1. Definir los fallbacks (el texto original estático del diseño)
const FALLBACK = {
  label: "Agencia Digital",
  headline: "SOMOS EL MOTOR DIGITAL DETRÁS DE LAS MARCAS QUE ESCALAN.",
  subtitle: "Integramos estrategia, marketing, webs, tecnología, datos e IA para escalar negocios",
  cta_primary_text: "Conversemos",
  cta_primary_url: "#contacto",
  cta_secondary_text: "Nuestras Soluciones",
  cta_secondary_url: "#servicios",
  video_url: "/hero-video.mp4",
  // Si WordPress devuelve un image_id pero no querés depender de otra request,
  // la mejor práctica es exponer la URL directamente desde el mu-plugin,
  // o tener una imagen de fallback por defecto.
};

export default function HeroSection() {
  // 2. Obtener los datos del hook
  const { data, loading } = useHomeData();
  
  // 3. Obtener el meta campo específico de esta sección
  // Nota: {PREFIX} debe ser reemplazado por el prefijo real del proyecto
  const meta = data?.PREFIX_hero;

  // 4. Mapear cada variable usando el meta de WP o el fallback
  const label = meta?.label || FALLBACK.label;
  const headline = meta?.headline || FALLBACK.headline;
  const subtitle = meta?.subtitle || FALLBACK.subtitle;
  const ctaPrimaryText = meta?.cta_primary_text || FALLBACK.cta_primary_text;
  const ctaPrimaryUrl = meta?.cta_primary_url || FALLBACK.cta_primary_url;
  const ctaSecondaryText = meta?.cta_secondary_text || FALLBACK.cta_secondary_text;
  const ctaSecondaryUrl = meta?.cta_secondary_url || FALLBACK.cta_secondary_url;
  const videoUrl = meta?.video_url || FALLBACK.video_url;

  return (
    <section className="relative min-h-screen flex items-center justify-center">
      {/* El video background */}
      <video
        autoPlay
        muted
        loop
        playsInline
        className="absolute inset-0 w-full h-full object-cover"
      >
        <source src={videoUrl} type="video/mp4" />
      </video>

      {/* Contenido */}
      <div className="relative z-10 text-center">
        <p className="text-sm uppercase tracking-widest mb-4">
          {label}
        </p>
        
        <h1 className="text-5xl md:text-7xl font-bold mb-6 max-w-4xl mx-auto">
          {headline}
        </h1>
        
        <p className="text-lg md:text-xl mb-8 max-w-2xl mx-auto">
          {subtitle}
        </p>
        
        <div className="flex gap-4 justify-center">
          <a href={ctaSecondaryUrl} className="btn-secondary">
            {ctaSecondaryText}
          </a>
          <a href={ctaPrimaryUrl} className="btn-primary">
            {ctaPrimaryText}
          </a>
        </div>
      </div>
    </section>
  );
}
