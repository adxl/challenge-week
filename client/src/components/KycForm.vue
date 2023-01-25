<script setup>
import { addKyc, updateKyc } from "@/api/kyc";
import { Form, Field, ErrorMessage } from "vee-validate";
import { useRouter } from "vue-router";
import { onMounted, reactive } from "vue";
import { inject } from "vue";

const user = inject("auth_user");

const route = useRouter();
const id = route.currentRoute.value.params.id ?? null;

const _formValues = reactive({
  siret: "",
  status: "PENDING",
});

onMounted(() => {
  console.log(user);
  if (!id) return;
  getProductCategory(id).then((res) => {
    _formValues.name = res.data.items.name;
  });
});

const simpleSchema = {
  siret(value) {
    if (!value) {
      return "le siret est requis";
    }
    return true;
  },
};

function handleRegister(values) {
  const data = {
    siret: values.siret,
    status: "PENDING",
    reason: "",
    deliverer: "/users/" + user.value.id,
  };
  console.log(data);
  if (id) {
    updateKyc(id, data)
      .then(({ data }) => {
        route.push({ name: "admin-product-categorys" });
      })
      .catch((error) => {
        console.log(error);
      });
    return;
  } else {
    addKyc(id, data)
      .then(({ data }) => {
        console.log(data);
        // route.push({ name: "orders" });
      })
      .catch((error) => {
        console.log(error);
      });
  }
}
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <span class="mb-4 text text-gray-900 md:text-5xl lg:text-6xl">
      Avant de commencer, nous avons besoin de quelques informations
    </span>
    <Form
      class="mt-4"
      :initial-values="_formValues"
      @submit="handleRegister"
      :validation-schema="simpleSchema"
    >
      <div class="mb-6">
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900"
          >Numero de SIRET</label
        >
        <Field
          name="siret"
          class="shadow-sm mb-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        />
        <ErrorMessage
          class="p-1 mb-1 text-sm text-red-700 borderrounded-lg"
          name="siret"
        />
      </div>
      <div class="mb-6 hidden">
        <Field
          name="status"
          value="PENDING"
          class="shadow-sm mb-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        />
        <ErrorMessage
          class="p-1 mb-1 text-sm text-red-700 borderrounded-lg"
          name="status"
        />
      </div>
      <button
        type="submit"
        class="text-white bg-blue-700 m-6 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
      >
        Vérifier mon compte
      </button>
    </Form>
  </div>
</template>

<style scoped></style>
