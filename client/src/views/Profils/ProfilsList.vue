<script setup>
import { getClients, getDeliverers } from "@/api/account";
import { banUser } from "@/api/user";
import { USER_STATUS, PROFIL_DELIVERER, PROFIL_USER } from "@/router/constants";
import { onMounted, reactive, ref, watch } from "vue";
import UserStatus from "@/components/UserStatus.vue";

const users = reactive({ value: [] });

const isClientProfil = ref(false);
const isDelivererProfil = ref(false);

const props = defineProps({
  source: {
    type: Symbol,
    required: true,
  },
});

function refreshUsers() {
  isClientProfil.value = props.source === PROFIL_USER;
  isDelivererProfil.value = props.source === PROFIL_DELIVERER;

  if (isClientProfil.value) {
    getClients()
      .then((res) => {
        users.value = res.data.items;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  if (isDelivererProfil.value) {
    getDeliverers()
      .then((res) => {
        users.value = res.data.items;

        // check if deliverer has a bad rating
        users.value.forEach((user) => {
          if (user.status === USER_STATUS.BANNED) {
            return;
          }
          const orders = user.delivererOrders.filter(
            (order) => order?.delivererReview?.rating >= 0
          );
          if (orders.length > 0) {
            const sum = orders.reduce((acc, order) => {
              return acc + order.delivererReview.rating;
            }, 0);
            const average = sum / orders.length;
            if (average < 0.5) {
              banUser(user.id)
                .then((res) => {
                  user.status = USER_STATUS.BANNED;
                })
                .catch((error) => {
                  console.log(error);
                });
            }
          }
        });

        users.value.sort((a) => {
          if (USER_STATUS.OPERATIVE === a.status) {
            return -1;
          }
          if (USER_STATUS.OPERATIVE !== a.status) {
            return 1;
          }
          return 0;
        });
      })
      .catch((error) => {
        console.log(error);
      });
  }
}
watch(props, () => refreshUsers());
onMounted(() => refreshUsers());

// format date as DD/MM/YYYY
const dateFormat = (value) => {
  const date = new Date(value);
  const year = date.getFullYear();
  const month = date.getMonth() + 1;
  const day = date.getDate();
  return `${padTo2Digits(day)}/${padTo2Digits(month)}/${padTo2Digits(year)}`;
};

function padTo2Digits(num) {
  return num.toString().padStart(2, "0");
}
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div class="m-4"></div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-400">
        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">Nom</th>
            <th scope="col" class="px-6 py-3">email</th>
            <th scope="col" class="px-6 py-3">adresse</th>
            <th scope="col" class="px-6 py-3">année de naissance</th>
            <th scope="col" class="px-6 py-3">Status</th>
            <th scope="col" class="px-6 py-3">Nb de commandes</th>
            <th scope="col" class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in users.value"
            class="border-b bg-gray-800 border-gray-700"
            :key="user.id"
          >
            <td class="px-6 py-4">{{ user.firstname }} {{ user.lastname }}</td>
            <td class="px-6 py-4">{{ user.email }}</td>
            <td class="px-6 py-4">{{ user.address }}</td>
            <td class="px-6 py-4">{{ dateFormat(user.birthdayAt) }}</td>
            <td class="px-6 py-4">
              <UserStatus :status="user.status" />
            </td>
            <td class="px-6 py-4 text-center">
              <span v-if="isClientProfil">
                {{ user.clientOrders.length }}
              </span>
              <span v-if="isDelivererProfil">
                {{ user.delivererOrders.length }}
              </span>
            </td>
            <td class="px-6 py-4">
              <router-link
                :to="{
                  name: 'admin-user-detail',
                  params: { id: user.id },
                }"
                class="font-medium text-blue-500 hover:underline"
                >Détail</router-link
              >
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped></style>
