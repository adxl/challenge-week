<script setup>
import { getUser, updateUser, checkPassword } from "@/api/account";
import { Form, Field, ErrorMessage } from "vee-validate";
import { useRouter } from "vue-router";
import { inject, onMounted, reactive, ref } from "vue";

const route = useRouter();
const currentUser = inject("auth_user");
const refreshUser = inject("app_refresh");
const id = route.currentRoute.value.params.id ?? null;
const regex = {
  name: new RegExp(
    "^(?=.{2,255}$)[a-zA-ZÀ-ÖØ-öø-ÿ]+(?:[-' ][a-zA-ZÀ-ÖØ-öø-ÿ]+)*[a-zA-ZÀ-ÖØ-öø-ÿ]$"
  ),
  birthday: new RegExp("^(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$"),
  address: new RegExp("^[a-zA-Z0-9 ,'-]{5,255}$"),
  password: new RegExp("^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$"),
};

const _formValues = reactive({
  firstname: "",
  lastname: "",
  birthdayAt: "",
  address: "",
  oldPassword: undefined,
});

const validationForms = {
  firstname(value) {
    if (!value) return "Le prénom est requis";
    if (!regex.name.test(value)) "Le prénom n'est pas valide";
    return true;
  },
  lastname(value) {
    if (!value) return "Le nom de famille est requis";
    if (!regex.name.test(value)) "Le nom de famille n'est pas valide";
    return true;
  },
  birthdayAt(value) {
    if (!value) return "La date de naissance est requise";
    if (!regex.birthday.test(value)) return "La date de naissance n'est pas valide";

    const millisecondsInYear = 1000 * 60 * 60 * 24 * 365;
    const ageDiffInMilliseconds = Date.now() - new Date(value).getTime();
    const ageInYears = ageDiffInMilliseconds / millisecondsInYear;
    if (ageInYears < 18) return "Vous devez avoir au moins 18 ans";
    return true;
  },
  address(value) {
    if (!value) return "L'adresse est requise";
    value = value.replace(/[\r\n]+/gm, "");
    if (!regex.address.test(value)) return "L'adresse n'est pas valide";
    return true;
  },
  newPassword(value, values) {
    if (value) {
      const form = values.form;
      if (form.oldPassword === undefined || form.oldPassword.length <= 0)
        return "L'ancien mot de passe est requis";
      if (!regex.password.test(value))
        return "Le mot de passe doit contenir au moins 8 caractères, une lettre et un chiffre";
    }
    return true;
  },
  newPasswordConfirmation(value, values) {
    const form = values.form;
    if (form.newPassword !== undefined) {
      if (!value) return "La confirmation du mot de passe est requise";
      if (value !== form.newPassword) return "Les mots de passe ne correspondent pas";
    }
    return true;
  },
};

onMounted(() => {
  if (!id || !currentUser?.value?.id) window.location.href = "/";

  _formValues.firstname = currentUser.value.firstname;
  _formValues.lastname = currentUser.value.lastname;
  _formValues.birthdayAt = new Date(currentUser.value.birthdayAt).toISOString().substring(0, 10);
  _formValues.address = currentUser.value.address;
});

function handleSave(values) {
  console.log(values);
  if (values.oldPassword && values.newPassword) {
    checkPassword(id, values.oldPassword)
      .then((res) => {
        console.log(res.data);
        if (res.data) {
          const { newPassword: plainPassword } = values;
          updateUser(id, { plainPassword, ...values })
            .then((res) => {
              console.log(res.data);
              refreshUser();
            })
            .catch((error) => {
              console.log(error);
            });
        }
      })
      .catch((error) => {
        console.log(error);
      });
  } else {
    updateUser(id, { ...values })
      .then((res) => {
        refreshUser();
        console.log("success update user", res.data);
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
      class="mb-8 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl"
    >
      Modification du profil
    </h3>
    <Form :initial-values="_formValues" @submit="handleSave" :validation-schema="validationForms">
      <!-- <Form :initial-values="_formValues" @submit="handleSave"> -->
      <div class="grid md:grid-cols-3 md:gap-6 mb-4">
        <div>
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Prénom</label>
          <Field
            id="firstname"
            type="text"
            name="firstname"
            class="shadow-sm mb-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="firstname">
          </ErrorMessage>
        </div>
        <div>
          <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900"
            >Nom de famille</label
          >
          <Field
            type="text"
            id="lastname"
            name="lastname"
            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="lastname">
          </ErrorMessage>
        </div>
        <div>
          <label for="birthdayAt" class="block mb-2 text-sm font-medium text-gray-900"
            >Année de naissance</label
          >
          <Field
            id="birthdayAt"
            name="birthdayAt"
            type="date"
            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="birthdayAt">
          </ErrorMessage>
        </div>
      </div>
      <div class="grid md:grid-cols-2 md:gap-6 mb-4">
        <div>
          <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Adresse</label>
          <Field
            id="address"
            type="text"
            name="address"
            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="address">
          </ErrorMessage>
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
          <input
            id="email"
            type="email"
            :value="currentUser.value.email"
            disabled
            class="shadow-sm bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
        </div>
      </div>
      <div class="grid md:grid-cols-3 md:gap-6 mb-6">
        <div>
          <label for="plainPassword" class="block mb-2 text-sm font-medium text-gray-900"
            >Ancien mot de passe</label
          >
          <Field
            type="password"
            id="oldPassword"
            name="oldPassword"
            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="oldPassword">
          </ErrorMessage>
        </div>
        <div>
          <label for="newPassword" class="block mb-2 text-sm font-medium text-gray-900"
            >Nouveau mot de passe</label
          >
          <Field
            type="password"
            id="newPassword"
            name="newPassword"
            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage class="p-1 mb-1 text-sm text-red-700 borderrounded-lg" name="newPassword">
          </ErrorMessage>
        </div>

        <div>
          <label for="label" class="block mb-2 text-sm font-medium text-gray-900"
            >Confirmation du nouveau mot de passe</label
          >
          <Field
            type="password"
            id="newPasswordConfirmation"
            name="newPasswordConfirmation"
            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
          />
          <ErrorMessage
            class="p-1 mb-1 text-sm text-red-700 borderrounded-lg"
            name="newPasswordConfirmation"
          >
          </ErrorMessage>
        </div>
      </div>
      <button
        type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
      >
        Enregistrer
      </button>
    </Form>
  </div>
</template>

<style scoped></style>
