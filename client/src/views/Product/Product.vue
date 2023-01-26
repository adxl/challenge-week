<script setup>
import { getProduct, addProduct, updateProduct } from "@/api/product";
import { getAllProductType } from "@/api/productType";
import { getAllProductCategory } from "@/api/productCategory";
import { Form, Field, ErrorMessage } from "vee-validate";
import { useRouter } from "vue-router";
import { onMounted, reactive } from "vue";
import { isIntegerKey } from "@vue/shared";

const route = useRouter();
const id = route.currentRoute.value.params.id ?? null;

const _formValues = reactive({
  name: "",
  price: "",
  quantity: "",
  description: "",
  category: "",
  type: "",
});

const productTypes = reactive([]);
const productCategory = reactive([]);

onMounted(() => {
  if (id) {
    getProduct(id).then((res) => {
      console.log(res.data);
      _formValues.name = res.data.name;
      _formValues.price = Number(res.data.price);
      _formValues.quantity = Number(res.data.quantity);
      _formValues.description = res.data.description;
      _formValues.type = res.data.type["@id"];
      _formValues.category = res.data.category["@id"];
    });
  }

  getAllProductType().then((res) => {
    productTypes.value = res.data.items;
  });
  getAllProductCategory().then((res) => {
    productCategory.value = res.data.items;
  });
});

const simpleSchema = {
  name(value) {
    if (!value) {
      return "le nom est requis";
    }
    return true;
  },
  price(value) {
    if (!value) {
      return "le prix est requis";
    }
    return true;
  },
  quantity(value) {
    if (!value) {
      return "la quantitée est requis";
    }
    return true;
  },
  description(value) {
    if (!value) {
      return "la description est requis";
    }
    return true;
  },
  type(value) {
    if (!value) {
      return "le type est requis";
    }
    return true;
  },
  category(value) {
    if (!value) {
      return "la catégorie est requis";
    }
    return true;
  },
};

function handleRegister(values) {
  values.price = Number(values.price);
  values.quantity = Number(values.quantity);
  if (id) {
    updateProduct(id, { ...values })
      .then(({ data }) => {
        route.push({ name: "admin-products" });
      })
      .catch((error) => {
        console.log(error);
      });
    return;
  } else {
    addProduct({ id, ...values })
      .then(({ data }) => {
        route.push({ name: "admin-products" });
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
      {{ id ? "Modification " + _formValues.name : "Création d'un produit" }}
    </h3>
    <Form :initial-values="_formValues" @submit="handleRegister" :validation-schema="simpleSchema">
      <div class="mb-6">
        <label for="website" class="block mb-2 text-sm font-medium text-gray-900"
          >Nom du produit</label
        >
        <Field
          name="name"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        />
        <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="name" />
      </div>
      <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
          <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Prix</label>
          <Field
            name="price"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="price" />
        </div>
        <div>
          <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900"
            >Quantitée</label
          >
          <Field
            name="quantity"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="quantity" />
        </div>
      </div>
      <div class="mb-6">
        <label for="description" class="block mb-2 text-sm font-medium text-gray-900"
          >Description</label
        >
        <Field
          name="description"
          type="textarea"
          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
        />
        <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="description" />
      </div>
      <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
          <label for="type" class="block mb-2 text-sm font-medium text-gray-900"
            >Sélectionner un type de produit</label
          >
          <Field
            name="type"
            as="select"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          >
            <option selected>Choisir un type</option>
            <option v-for="item in productTypes.value" :value="item['@id']">
              {{ item.name }}
            </option>
          </Field>
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="type" />
        </div>
        <div>
          <label for="category" class="block mb-2 text-sm font-medium text-gray-900"
            >Sélectionner une catégorie</label
          >
          <Field
            name="category"
            as="select"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          >
            <option selected>Choisir une catégorie</option>
            <option v-for="item in productCategory.value" :value="item['@id']">
              {{ item.name }}
            </option>
          </Field>
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="category" />
        </div>
      </div>
      <button
        type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
      >
        Ajouter
      </button>
    </Form>
  </div>
</template>

<style scoped></style>
