import { createWebHistory, createRouter } from "vue-router";
import { useGetCurrentUser } from "@/services";

import {
  REGISTER_CLIENT,
  REGISTER_DELIVERER,
  PROFIL_DELIVERER,
  PROFIL_USER,
  USER_ROLES,
  USER_STATUS,
} from "./constants";

const routes = [
  {
    name: "home",
    path: "/",
    component: () => import("@/components/HomePage.vue"),
  },
  {
    name: "registerClient",
    path: "/register/client",
    component: () => import("@/views/Register.vue"),
    props: { source: REGISTER_CLIENT },
    meta: { loggedIn: false },
  },
  {
    name: "registerDeliverer",
    path: "/register/deliverer",
    component: () => import("@/views/Register.vue"),
    props: { source: REGISTER_DELIVERER },
    meta: { loggedIn: false },
  },
  {
    name: "login",
    path: "/login",
    component: () => import("@/views/Login.vue"),
    meta: { loggedIn: false },
  },
  {
    //TODO: quel meta pour cette route ?
    path: "/users/verify/:token",
    name: "Verify Token",
    component: () => import("@/views/VerifyToken.vue"),
  },
  {
    path: "/reset-password/:token",
    name: "New Password Form",
    component: () => import("@/views/ResetPassword/NewPwdForm.vue"),
    meta: { loggedIn: false },
  },
  {
    path: "/reset-password",
    name: "Reset Password",
    component: () => import("@/views/ResetPassword/EmailForm.vue"),
    meta: { loggedIn: false },
  },
  {
    name: "store",
    path: "/store",
    component: () => import("@/views/Store/Store.vue"),
    meta: { authorize: [USER_ROLES.ROLE_CLIENT] },
  },
  {
    name: "orders",
    path: "/orders",
    component: () => import("@/views/Order/OrderList.vue"),
    meta: { authorize: [USER_ROLES.ROLE_CLIENT, USER_ROLES.ROLE_DELIVERER] },
  },
  {
    name: "order-detail",
    path: "/orders/:id",
    component: () => import("@/views/Order/Order.vue"),
    meta: { authorize: [USER_ROLES.ROLE_CLIENT, USER_ROLES.ROLE_DELIVERER] },
  },
  {
    name: "cart",
    path: "/cart",
    component: () => import("@/views/Store/Cart.vue"),
    meta: { authorize: [USER_ROLES.ROLE_CLIENT] },
  },
  {
    name: "profil",
    path: "/profil/:id",
    component: () => import("@/views/Profils/Profil.vue"),
    meta: { authorizeUpdateOwnProfil: true },
  },
  {
    path: "/admin/",
    meta: { authorize: ["ROLE_ADMIN"] },
    component: () => import("@/views/AdminDashboard.vue"),
    children: [
      {
        name: "admin-dashboard",
        path: "",
        component: () => import("@/views/DashboardAdmin.vue"),
      },
      {
        name: "admin-user-detail",
        path: "user/:id",
        component: () => import("@/views/Profils/UserProfil.vue"),
      },
      {
        name: "admin-profils-clients",
        path: "profils/clients",
        component: () => import("@/views/Profils/ProfilsList.vue"),
        props: { source: PROFIL_USER },
      },
      {
        name: "admin-profils-deliverers",
        path: "profils/deliverers",
        component: () => import("@/views/Profils/ProfilsList.vue"),
        props: { source: PROFIL_DELIVERER },
      },
      {
        name: "adminReviews",
        path: "reviews",
        component: () => import("@/views/ReviewsList.vue"),
      },
      {
        path: "products",
        name: "admin-products",
        component: () => import("@/views/Product/ProductList.vue"),
      },
      {
        path: "product/create",
        name: "admin-product-create",
        component: () => import("@/views/Product/Product.vue"),
      },
      {
        path: "product/:id",
        name: "admin-product",
        component: () => import("@/views/Product/Product.vue"),
      },
      {
        path: "product-categorys",
        name: "admin-product-categorys",
        component: () => import("@/views/ProductCategory/ProductCategoryList.vue"),
      },
      {
        path: "product-category/create",
        name: "admin-product-category-create",
        component: () => import("@/views/ProductCategory/ProductCategory.vue"),
      },
      {
        path: "product-category/:id",
        name: "admin-product-category",
        component: () => import("@/views/ProductCategory/ProductCategory.vue"),
      },
      {
        path: "product-types",
        name: "admin-product-types",
        component: () => import("@/views/ProductType/ProductTypeList.vue"),
      },
      {
        path: "product-type/create",
        name: "admin-product-type-create",
        component: () => import("@/views/ProductType/ProductType.vue"),
      },
      {
        path: "product-type/:id",
        name: "admin-product-type",
        component: () => import("@/views/ProductType/ProductType.vue"),
      },
      {
        path: "verify/kyc",
        name: "admin-kyc-list",
        component: () => import("@/views/Kyc/KycList.vue"),
      },
      {
        path: "verify/kyc/:id",
        name: "admin-kyc",
        component: () => import("@/views/Kyc/Kyc.vue"),
      },
      {
        path: "orders",
        name: "admin-orders",
        component: () => import("@/views/Order/OrderList.vue"),
      },
      {
        path: "order/:id",
        name: "admin-order",
        component: () => import("@/views/Order/Order.vue"),
      },
    ],
  },
  {
    name: "catchAll",
    path: "/:pathMatch(.*)*",
    component: () => import("@/views/NotFound.vue"),
  },
];
const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to) => {
  const currentUser = await useGetCurrentUser().catch(() => null);

  if (to.meta.loggedIn && !currentUser && currentUser.status === USER_STATUS.BANNED) {
    return {
      name: "login",
    };
  }

  if (to.meta.loggedIn === false && currentUser) {
    return {
      name: "home",
    };
  }

  if (to.meta.authorize && !currentUser?.roles.some((r) => to.meta.authorize?.includes(r))) {
    return {
      name: "catchAll",
    };
  }

  if (to.meta.authorizeUpdateOwnProfil) {
    if (Number(to.params.id) !== currentUser?.id) {
      return {
        name: "catchAll",
      };
    }
  }
});
export default router;
