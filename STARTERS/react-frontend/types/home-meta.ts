export interface HeroMeta {
  label: string;
  headline: string;
  subtitle: string;
  cta_primary_text: string;
  cta_primary_url: string;
  cta_secondary_text: string;
  cta_secondary_url: string;
  video_url: string;
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

export interface FooterEmpresaLink {
  label: string;
  href: string;
}

export interface FooterSocialLink {
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
  footer_empresa: FooterEmpresaLink[];
  footer_cta_text: string;
  footer_social: FooterSocialLink[];
}

export interface HomeMetaData {
  wetheme_hero: HeroMeta;
  wetheme_rooms: RoomsMeta;
  wetheme_surf_info: SurfInfoMeta;
}
