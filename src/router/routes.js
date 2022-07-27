const routes = [
  {
    path: "/",
    component: () => import("layouts/LoginMain.vue"),
    children: [{ path: "/", component: () => import("pages/LoginPage.vue") }],
  },

  {
    path: "/dashboard",
    component: () => import("layouts/MainLayout.vue"),
    // children: [{ path: "", component: () => import("pages/IndexPage.vue") }],
    children: [
      {
        path: "/dashboard",
        component: () => import("pages/menu/OpeningStock.vue"),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
