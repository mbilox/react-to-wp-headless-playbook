import { useEffect, useRef } from "react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import type { HeroMeta } from "../types/home-meta";

gsap.registerPlugin(ScrollTrigger);

interface HeroProps {
  meta: HeroMeta;
}

const FALLBACK = {
  label: "Agencia Digital",
  headline: "SOMOS EL MOTOR DIGITAL DETRÁS DE LAS MARCAS QUE ESCALAN.",
  subtitle: "Integramos estrategia, marketing, webs, tecnología, datos e IA para escalar negocios",
  cta_primary_text: "Conversemos",
  cta_primary_url: "#contacto",
  cta_secondary_text: "Nuestras Soluciones",
  cta_secondary_url: "#servicios",
  video_url: "/hero-video.mp4",
};

export default function Hero({ meta }: HeroProps) {
  const sectionRef = useRef<HTMLElement>(null);
  const videoRef = useRef<HTMLVideoElement>(null);
  const headlineRef = useRef<HTMLHeadingElement>(null);
  const subtitleRef = useRef<HTMLParagraphElement>(null);
  const ctaRef = useRef<HTMLDivElement>(null);
  const overlayRef = useRef<HTMLDivElement>(null);
  const glowRef = useRef<HTMLDivElement>(null);

  const label = meta?.label || FALLBACK.label;
  const headline = meta?.headline || FALLBACK.headline;
  const subtitle = meta?.subtitle || FALLBACK.subtitle;
  const ctaPrimaryText = meta?.cta_primary_text || FALLBACK.cta_primary_text;
  const ctaPrimaryUrl = meta?.cta_primary_url || FALLBACK.cta_primary_url;
  const ctaSecondaryText = meta?.cta_secondary_text || FALLBACK.cta_secondary_text;
  const ctaSecondaryUrl = meta?.cta_secondary_url || FALLBACK.cta_secondary_url;
  const videoUrl = meta?.video_url || FALLBACK.video_url;

  useEffect(() => {
    const ctx = gsap.context(() => {
      gsap.fromTo(
        videoRef.current,
        { opacity: 0 },
        { opacity: 1, duration: 1.2, ease: "power2.out" }
      );

      gsap.fromTo(
        overlayRef.current,
        { opacity: 0 },
        { opacity: 1, duration: 0.6, delay: 0.4 }
      );

      gsap.fromTo(
        glowRef.current,
        { opacity: 0, scale: 0.8 },
        { opacity: 1, scale: 1, duration: 1.5, delay: 0.3, ease: "power2.out" }
      );

      if (headlineRef.current) {
        const text = headlineRef.current.innerText;
        headlineRef.current.innerHTML = "";
        const chars = text.split("");
        chars.forEach((char) => {
          const span = document.createElement("span");
          span.innerText = char === " " ? "\u00A0" : char;
          span.style.display = "inline-block";
          span.style.opacity = "0";
          span.style.transform = "translateY(30px) rotateX(-40deg)";
          span.style.transformOrigin = "center bottom";
          headlineRef.current!.appendChild(span);
        });

        gsap.to(headlineRef.current.children, {
          opacity: 1,
          y: 0,
          rotateX: 0,
          duration: 0.6,
          stagger: 0.025,
          delay: 0.6,
          ease: "power3.out",
        });
      }

      gsap.fromTo(
        subtitleRef.current,
        { opacity: 0, y: 20 },
        { opacity: 1, y: 0, duration: 0.8, delay: 1.2, ease: "power3.out" }
      );

      gsap.fromTo(
        ctaRef.current,
        { opacity: 0, y: 20 },
        { opacity: 1, y: 0, duration: 0.8, delay: 1.5, ease: "power3.out" }
      );

      gsap.to(headlineRef.current, {
        yPercent: -15,
        ease: "none",
        scrollTrigger: {
          trigger: sectionRef.current,
          start: "top top",
          end: "bottom top",
          scrub: 0.5,
        },
      });
    }, sectionRef);

    return () => ctx.revert();
  }, []);

  return (
    <section
      id="inicio"
      ref={sectionRef}
      className="relative w-full min-h-screen flex items-center justify-center overflow-hidden bg-we-dark"
    >
      <video
        ref={videoRef}
        autoPlay
        muted
        loop
        playsInline
        preload="auto"
        className="absolute inset-0 w-full h-full object-cover opacity-0"
        style={{ zIndex: 0 }}
      >
        <source src={videoUrl} type="video/mp4" />
      </video>

      <div className="absolute inset-0 bg-we-dark/70" style={{ zIndex: 1 }} />

      <div
        ref={overlayRef}
        className="absolute inset-0 scanlines opacity-0"
        style={{ zIndex: 2 }}
      />

      <div
        ref={glowRef}
        className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] rounded-full opacity-0"
        style={{
          background: "radial-gradient(circle, rgba(255,201,50,0.08) 0%, transparent 70%)",
          zIndex: 3,
          animation: "pulse-glow 8s ease-in-out infinite",
        }}
      />

      <div className="absolute inset-0 overflow-hidden pointer-events-none" style={{ zIndex: 4 }}>
        {Array.from({ length: 20 }).map((_, i) => (
          <div
            key={i}
            className="absolute rounded-full bg-we-primary"
            style={{
              width: `${Math.random() * 3 + 1}px`,
              height: `${Math.random() * 3 + 1}px`,
              left: `${Math.random() * 100}%`,
              bottom: `-10px`,
              opacity: 0.2 + Math.random() * 0.2,
              animation: `float-particle ${10 + Math.random() * 15}s linear infinite`,
              animationDelay: `${Math.random() * 10}s`,
            }}
          />
        ))}
      </div>

      <div className="relative z-10 max-w-[900px] mx-auto px-6 text-center" style={{ perspective: "1000px" }}>
        <p className="text-[12px] uppercase tracking-[0.2em] text-we-primary font-medium mb-6">
          {label}
        </p>

        <h1
          ref={headlineRef}
          className="text-[36px] sm:text-[48px] lg:text-[64px] xl:text-[72px] font-extrabold uppercase leading-[1.1] tracking-tight text-white mb-8"
          style={{ transformStyle: "preserve-3d" }}
        >
          {headline}
        </h1>

        <p
          ref={subtitleRef}
          className="text-[16px] lg:text-[18px] text-we-text-secondary leading-relaxed max-w-[600px] mx-auto mb-10 opacity-0"
        >
          {subtitle}
        </p>

        <div ref={ctaRef} className="flex flex-col sm:flex-row items-center justify-center gap-4 opacity-0">
          <a
            href={ctaSecondaryUrl}
            onClick={(e) => {
              e.preventDefault();
              document.querySelector(ctaSecondaryUrl)?.scrollIntoView({ behavior: "smooth" });
            }}
            className="inline-flex items-center px-8 py-4 border border-we-primary text-we-primary text-[14px] font-semibold uppercase tracking-wide rounded-full hover:bg-we-primary hover:text-we-dark transition-all duration-300"
          >
            {ctaSecondaryText}
          </a>
          <a
            href={ctaPrimaryUrl}
            onClick={(e) => {
              e.preventDefault();
              document.querySelector(ctaPrimaryUrl)?.scrollIntoView({ behavior: "smooth" });
            }}
            className="inline-flex items-center px-8 py-4 bg-we-primary text-we-dark text-[14px] font-semibold uppercase tracking-wide rounded-full hover:scale-105 transition-all duration-300"
            style={{ boxShadow: "0 0 30px rgba(255,201,50,0.25)" }}
          >
            {ctaPrimaryText}
          </a>
        </div>
      </div>
    </section>
  );
}
