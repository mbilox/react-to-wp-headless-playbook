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
          `${WP_API_URL}/wp/v2/pages?slug=sample-page&_embed=1`
        );

        if (!response.ok) {
          throw new Error(
            `Error ${response.status}: ${response.statusText}`
          );
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
            wetheme_hero: meta.wetheme_hero || {},
            wetheme_rooms: meta.wetheme_rooms || {},
            wetheme_surf_info: meta.wetheme_surf_info || {},
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
