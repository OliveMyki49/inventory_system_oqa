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
        component: () => import("pages/menu/StockIn.vue"),
        component: () => import("pages/menu/StockOut.vue"),
        component: () => import("pages/menu/CurrentStatus.vue"),
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
