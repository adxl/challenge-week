import { createWebHistory, createRouter } from "vue-router";
import Register from "@/views/Register.vue";
import Login from "@/views/Login.vue";
import HelloWorld from "@/components/HelloWorld.vue";
import NotFound from "@/views/NotFound.vue";
import AdminDashboard from "@/views/AdminDashboard.vue";
import VerifyToken from "@/views/VerifyToken.vue";
import KycList from "@/views/Kyc/KycList.vue";
import Kyc from "@/views/Kyc/Kyc.vue";
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
    path: "/admin/verify/kyc",
    name: "Verify KYC",
    component: KycList,
  },
  {
    path: "/admin/verify/kyc/:id",
    name: "Edit KYC",
    component: Kyc,
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
    name: "product-types",
    path: "/product-types",
    component: ProductTypeList,
  },
  {
    name: "product-type-create",
    path: "/product-type/create",
    component: ProductType,
  },
  {
    name: "product-type",
    path: "/product-type/:id",
    component: ProductType,
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
    name: "product-categorys",
    path: "/product-categorys",
    component: ProductCategoryList,
  },
  {
    name: "product-category-create",
    path: "/product-category/create",
    component: ProductCategory,
  },
  {
    name: "product-category",
    path: "/product-category/:id",
    component: ProductCategory,
  },
  {
    name: "products",
    path: "/products",
    component: ProductList,
  },
  {
    name: "product-create",
    path: "/product/create",
    component: Product,
  },
  {
    name: "product",
    path: "/product/:id",
    component: Product,
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
