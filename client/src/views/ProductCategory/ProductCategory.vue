<script setup>
import {
  getProductCategory,
  addProductCategory,
  updateProductCategory,
} from "@/api/productCategory";
import { Form, Field, ErrorMessage } from "vee-validate";
import { useRouter } from "vue-router";
import { onMounted, reactive } from "vue";

const route = useRouter();
const id = route.currentRoute.value.params.id ?? null;

const _formValues = reactive({
  name: "",
});

onMounted(() => {
  if (!id) return;
  getProductCategory(id).then((res) => {
    _formValues.name = res.data.items.name;
  });
});

const simpleSchema = {
  name(value) {
    if (!value) {
      return "le nom est requis";
    }
    return true;
  },
};

function handleRegister(values) {
  if (id) {
    updateProductCategory(id, { ...values })
      .then(({ data }) => {
        route.push({ name: "admin-product-categorys" });
      })
      .catch((error) => {
        console.log(error);
      });
    return;
  } else {
    addProductCategory({ id, ...values })
      .then(({ data }) => {
        route.push({ name: "admin-product-categorys" });
      })
      .catch((error) => {
        console.log(error);
      });
  }
}
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <h3
      class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl"
    >
      {{ id ? "Modification " + _formValues.name : "Création d'un catégorie" }}
    </h3>
    <Form
      :initial-values="_formValues"
      @submit="handleRegister"
      :validation-schema="simpleSchema"
    >
      <div class="mb-6">
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900"
          >Nom de la catégorie</label
        >
        <Field
          name="name"
          class="shadow-sm mb-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        />
        <ErrorMessage
          class="p-1 mb-1 text-sm text-red-700 borderrounded-lg"
          name="name"
        />
      </div>
      <button
        type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
      >
        Ajouter une catégorie de produit
      </button>
    </Form>
  </div>
</template>

<style scoped></style>
