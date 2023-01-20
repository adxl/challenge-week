<script setup>
import { getKyc, updateKyc } from "@/api/kyc";
import { Form, Field, ErrorMessage } from "vee-validate";
import { useRouter } from "vue-router";
import { onMounted, reactive } from "vue";

const route = useRouter();
const id = route.currentRoute.value.params.id ?? null;

const _formValues = reactive({
  siret: "",
  status: "",
  reason: "",
});

const _user = reactive({
  firstname: "",
  lastname: "",
});

const STATUS = [
  { value: "PENDING", label: "en Attente" },
  { value: "VALIDATED", label: "Validé" },
  { value: "REFUSED", label: "Refusé" },
];

onMounted(() => {
  if (!id) return;
  getKyc(id).then((res) => {
    _formValues.siret = res.data.items.siret;
    _formValues.status = res.data.items.status;
    _formValues.reason = res.data.items.reason;
    _user.firstname = res.data.items.deliverer["firstname"];
    _user.lastname = res.data.items.deliverer["lastname"];
  });
});

function handleUpdate(values) {
  updateKyc(id, { ...values })
    .then(({ data }) => {
      route.push({ name: "Verify KYC" });
    })
    .catch((error) => {
      console.log(error);
    });
  return;
}
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <h3
      class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl"
    >
      Kyc de {{ _user.firstname }} {{ _user.lastname }}
    </h3>
    <Form :initial-values="_formValues" @submit="handleUpdate">
      <div class="mb-6">
        <label for="siret" class="block mb-2 text-sm font-medium text-gray-900"
          >Siret
        </label>
        <Field
          name="siret"
          id="disabled-input"
          aria-label="disabled input"
          class="shadow-sm mb-4 bg-gray-50 border cursor-not-allowed border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          value="Disabled input"
          disabled
        />
        <ErrorMessage
          class="p-1 mb-1 text-sm text-red-700 borderrounded-lg"
          name="siret"
        />
      </div>
      <div class="mb-6">
        <label for="reason" class="block mb-2 text-sm font-medium text-gray-900"
          >Raison du refus
        </label>
        <Field
          name="reason"
          class="shadow-sm mb-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        />
        <ErrorMessage
          class="p-1 mb-1 text-sm text-red-700 borderrounded-lg"
          name="reason"
        />
      </div>
      <div class="mb-6">
        <label for="status" class="block mb-2 text-sm font-medium text-gray-900"
          >Sélectionner un status</label
        >
        <Field
          name="status"
          as="select"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        >
          <option selected>Choisir une catégorie</option>
          <option v-for="item in STATUS" :value="item.value">
            {{ item.label }}
          </option>
        </Field>
        <ErrorMessage
          class="p-1 mb-1 text-sm text-red-700 borderrounded-lg"
          name="status"
        />
      </div>
      <button
        type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
      >
        Valider
      </button>
    </Form>
  </div>
</template>

<style scoped></style>
