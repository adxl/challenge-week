<script setup>
import { getAllKyc } from "@/api/kyc";
import { onMounted, reactive } from "vue";

const kyc = reactive([]);

onMounted(() => {
  getAllKyc().then((res) => {
    kyc.value = res.data.items;
  });
});

function status(status) {
  if (status === "pending") {
    return "⌛";
  } else if (status === "approved") {
    return "✅";
  } else if (status === "rejected") {
    return "🚫";
  }
}

// function handleDelete(value) {
//   deleteProductType(value.id)
//     .then(({ data }) => {
//       getAllProductType().then((res) => {
//         productTypes.value = res.data.items;
//       });
//     })
//     .catch((error) => {
//       console.log(error);
//     });
// }
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div class="m-4">
      <router-link
        :to="{ name: 'product-type-create' }"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        aria-current="page"
        >Ajouter un type de produit</router-link
      >
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th scope="col" class="px-6 py-3">Siret</th>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            :key="item.id"
            v-for="item in kyc.value"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
          >
            <td class="px-6 py-4">{{ item.siret }}</td>
            <td class="px-6 py-4">{{ status(item.status) }}</td>
            <td class="px-6 py-4">
              <router-link
                :to="{
                  name: 'product-type',
                  params: { id: item.id },
                }"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                >Edit</router-link
              >
            </td>
            <td class="px-6 py-4">
              <button
                @click.prevent="handleDelete(item)"
                type="submit"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped></style>
