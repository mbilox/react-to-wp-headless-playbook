# React to WordPress Headless Skill

Instrucciones para instalar y usar esta skill de OpenCode en otros proyectos.

## 📦 Instalación

Para usar esta skill en otro proyecto, debes copiar la carpeta de la skill dentro del directorio `.opencode/skills/` de tu proyecto de destino.

```bash
# Estando en la raíz del proyecto destino
mkdir -p .opencode/skills
cp -r /ruta/a/react-to-wp-headless-playbook/.opencode/skills/react-to-wp-headless .opencode/skills/
```

## 🚀 Uso

Una vez instalada la skill, puedes invocarla en tu chat con OpenCode:

```text
/adapt-react-to-wp acme-corp
```

O si prefieres un flujo interactivo donde la IA te guíe:

```text
/adapt-react-to-wp
```

## 📋 ¿Qué hace esta skill?

Esta skill le da "superpoderes" a OpenCode, enseñándole exactamente cómo ejecutar el proceso estandarizado de la agencia WE Digital para convertir sitios React en headless CMS.

La skill sabe:
1. Qué preguntas hacerte al inicio
2. Cómo generar las propuestas y diseños en formato OpenSpec
3. Dónde encontrar los templates de código para el mu-plugin y React
4. Qué reglas seguir (ej. siempre usar fallbacks, nunca usar ACF)
5. Cómo verificar que el trabajo quedó bien hecho

Para más detalles sobre el proceso subyacente, lee la documentación completa en la carpeta `react-to-wp-headless-playbook/`.
