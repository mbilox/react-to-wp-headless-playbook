import { useState, useEffect } from "react";

// ============================================================
// TIPOS DE META CAMPOS
// ============================================================

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

// ============================================================
// HOOK useHomeData
// ============================================================

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
          `${WP_API_URL}/wp/v2/pages?slug={SLUG}&_embed=1`
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
