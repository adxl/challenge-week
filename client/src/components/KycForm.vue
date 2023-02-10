<script setup>
import { addKyc, updateKyc, getKyc } from "@/api/kyc";
import { Form, Field, ErrorMessage } from "vee-validate";
import { onMounted, reactive } from "vue";
import { inject } from "vue";

const user = inject("auth_user");

const kyc = user.value.kyc?.["@id"] ?? null;

const _idKyc = reactive({
  id: null,
});

const _formValues = reactive({
  siret: "",
  status: "",
  reason: "",
});

onMounted(() => {
  if (!kyc) return;
  getKyc(kyc).then(({ data }) => {
    _formValues.siret = data.siret;
    _formValues.reason = data.reason;
    _formValues.status = data.status;
    _idKyc.id = data.id;
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
  if (_idKyc.id) {
    updateKyc(_idKyc.id, data)
      .then(({ data }) => {
        location.reload();
      })
      .catch((error) => {
        console.log(error);
      });
    return;
  } else {
    addKyc(data)
      .then(({ data }) => {
        location.reload();
      })
      .catch((error) => {
        console.log(error);
      });
  }
}
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div v-if="_formValues.status == 'PENDING'">
      <span class="mb-4 text text-gray-900 md:text-5xl lg:text-6xl">
        Votre KYC est en cours de validation
      </span>
    </div>
    <div v-else>
      <span v-if="_idKyc.id == null" class="mb-4 text text-gray-900 md:text-5xl lg:text-6xl">
        Avant de commencer, nous avons besoin de quelques informations
      </span>
      <Form
        class="mt-4"
        :initial-values="_formValues"
        @submit="handleRegister"
        :validation-schema="simpleSchema"
      >
        <div class="mb-6" v-if="_formValues.status == 'REFUSED'">
          <label for="reason" class="block mb-2 text-sm font-medium text-red-700"
            >Raison du refut</label
          >
          <Field
            id="disabled-input"
            value=""
            disabled
            aria-label="disabled input"
            type="text"
            name="reason"
            v-model="_formValues.reason"
            aria-placeholder="{{ _formValues.reason }}"
            class="cursor-not-allowed bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
          />
        </div>
        <div class="mb-6">
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900"
            >Numero de SIRET</label
          >
          <Field
            name="siret"
            class="shadow-sm mb-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="siret" />
        </div>
        <div class="mb-6 hidden">
          <Field
            name="status"
            value="PENDING"
            class="shadow-sm mb-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="status" />
        </div>
        <button
          type="submit"
          class="text-white bg-blue-700 m-6 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
        >
          Vérifier mon compte
        </button>
      </Form>
    </div>
  </div>
</template>

<style scoped></style>
