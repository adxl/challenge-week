import { createWebHistory, createRouter } from "vue-router";
import Register from "@/views/Register.vue";
import Login from "@/views/Login.vue";
import HelloWorld from "@/components/HelloWorld.vue";
import NotFound from "@/views/NotFound.vue";
import AdminDashboard from "@/views/AdminDashboard.vue";
import VerifyToken from "@/views/VerifyToken.vue";
import KycList from "@/views/Kyc/KycList.vue";
import Kyc from "@/views/Kyc/Kyc.vue";
import Store from "@/views/Store/Store.vue";
import NewPasswordForm from "@/views/ResetPassword/NewPwdForm.vue";
import EmailForm from "@/views/ResetPassword/EmailForm.vue";
import ProductType from "@/views/ProductType/ProductType.vue";
import ProductTypeList from "@/views/ProductType/ProductTypeList.vue";
import OrderList from "@/views/Order/OrderList.vue";
import Order from "@/views/Order/Order.vue";
import ProductCategory from "@/views/ProductCategory/ProductCategory.vue";
import ProductCategoryList from "@/views/ProductCategory/ProductCategoryList.vue";
import Product from "@/views/Product/Product.vue";
import ProductList from "@/views/Product/ProductList.vue";
import { useGetCurrentUser } from "@/services";

import {
  REGISTER_CLIENT,
  REGISTER_DELIVERER,
  PROFIL_DELIVERER,
  PROFIL_USER,
} from "./constants";

const routes = [
  {
    name: "home",
    path: "/",
    component: HelloWorld,
  },
  {
    name: "registerClient",
    path: "/register/client",
    component: Register,
    props: { source: REGISTER_CLIENT },
  },
  {
    name: "registerDeliverer",
    path: "/register/deliverer",
    component: Register,
    props: { source: REGISTER_DELIVERER },
  },
  {
    name: "login",
    path: "/login",
    component: Login,
    meta: { alreadyLoggedIn: true },
  },
  {
    path: "/users/verify/:token",
    name: "Verify Token",
    component: VerifyToken,
  },
  {
    path: "/reset-password/:token",
    name: "New Password Form",
    component: NewPasswordForm,
  },
  {
    path: "/reset-password",
    name: "Reset Password",
    component: EmailForm,
  },
  {
    name: "store",
    path: "/store",
    component: Store,
  },
  {
    name: "orders",
    path: "/orders",
    component: OrderList,
  },
  {
    name: "order-detail",
    path: "/orders/:id",
    component: Order,
  },
  {
    path: "/admin/",
    meta: { authorize: ["ROLE_ADMIN"] },
    component: AdminDashboard,
    children: [
      {
        name: "admin-dashboard",
        path: "",
        component: () => import("@/views/DashboardAdmin.vue"),
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
        component: ProductList,
      },
      {
        path: "product/create",
        name: "admin-product-create",
        component: Product,
      },
      {
        path: "product/:id",
        name: "admin-product",
        component: Product,
      },
      {
        path: "product-categorys",
        name: "admin-product-categorys",
        component: ProductCategoryList,
      },
      {
        path: "product-category/create",
        name: "admin-product-category-create",
        component: ProductCategory,
      },
      {
        path: "product-category/:id",
        name: "admin-product-category",
        component: ProductCategory,
      },
      {
        path: "product-types",
        name: "admin-product-types",
        component: ProductTypeList,
      },
      {
        path: "product-type/create",
        name: "admin-product-type-create",
        component: ProductType,
      },
      {
        path: "product-type/:id",
        name: "admin-product-type",
        component: ProductType,
      },
      {
        path: "verify/kyc",
        name: "admin-kyc-list",
        component: KycList,
      },
      {
        path: "verify/kyc/:id",
        name: "admin-kyc",
        component: Kyc,
      },
    ],
  },
  {
    name: "catchAll",
    path: "/:pathMatch(.*)*",
    component: NotFound,
  },
];
const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to) => {
  const currentUser = await useGetCurrentUser().catch(() => null);

  if (
    to.meta.authorize &&
    !currentUser?.roles.some((r) => to.meta.authorize?.includes(r))
  ) {
    return {
      path: "/login",
      query: { redirect: to.fullPath },
    };
  }

  if (to.meta.alreadyLoggedIn && currentUser) {
    return {
      path: "/",
    };
  }
});
export default router;
