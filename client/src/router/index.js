import { createWebHistory, createRouter } from "vue-router";
import Register from "@/views/Register.vue";
import Login from "@/views/Login.vue";
import HelloWorld from "@/components/HelloWorld.vue";
import NotFound from "@/views/NotFound.vue";
import VerifyToken from "@/views/VerifyToken.vue";
import NewPasswordForm from "@/views/ResetPassword/NewPwdForm.vue";
import EmailForm from "@/views/ResetPassword/EmailForm.vue";
import ProductType from "@/views/ProductType/ProductType.vue";
import ProductTypeList from "@/views/ProductType/ProductTypeList.vue";
import ProductCategory from "@/views/ProductCategory/ProductCategory.vue";
import ProductCategoryList from "@/views/ProductCategory/ProductCategoryList.vue";
import Product from "@/views/Product/Product.vue";
import ProductList from "@/views/Product/ProductList.vue";

import { REGISTER_CLIENT, REGISTER_DELIVERER } from "./constants";

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
    name: "catchAll",
    path: "/:pathMatch(.*)*",
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
