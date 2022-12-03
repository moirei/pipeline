module.exports = {
  title: "Laravel Pipeline",
  description: "Simple Laravel pipeline library.",
  base: "/pipeline/",
  theme: "vt",
  themeConfig: {
    enableDarkMode: true,
    logo: "/logo.png",
    repo: "moirei/pipeline",
    repoLabel: "Github",
    docsRepo: "moirei/pipeline",
    docsDir: "docs",
    docsBranch: "master",
    sidebar: [
      {
        title: "Get started",
        sidebarDepth: 1, // optional, defaults to 1
        children: ["/installation", "/rationale"],
      },
      {
        title: "Guide",
        path: "/guide/",
        children: [
          "/guide/creating-pipelines",
          "/guide/pipes",
          "/guide/context",
          "/guide/practices",
        ],
      },
      {
        title: "Operators",
        path: "/operators",
      },
    ],
    nav: [
      { text: "Guide", link: "/guide/" },
      {
        text: "Github",
        link: "https://github.com/moirei/pipeline",
        target: "_self",
      },
      // { text: 'External', link: 'https://moirei.com', target:'_self' },
    ],
  },
  head: [
    ["link", { rel: "icon", href: "/logo.png" }],
    // ['link', { rel: 'manifest', href: '/manifest.json' }],
    ["meta", { name: "theme-color", content: "#3eaf7c" }],
    ["meta", { name: "apple-mobile-web-app-capable", content: "yes" }],
    [
      "meta",
      { name: "apple-mobile-web-app-status-bar-style", content: "black" },
    ],
    [
      "link",
      { rel: "apple-touch-icon", href: "/icons/apple-touch-icon-152x152.png" },
    ],
    // ['link', { rel: 'mask-icon', href: '/icons/safari-pinned-tab.svg', color: '#3eaf7c' }],
    [
      "meta",
      {
        name: "msapplication-TileImage",
        content: "/icons/msapplication-icon-144x144.png",
      },
    ],
    ["meta", { name: "msapplication-TileColor", content: "#000000" }],
  ],
  plugins: [
    "@vuepress/register-components",
    "@vuepress/active-header-links",
    "@vuepress/pwa",
    "seo",
  ],
};
