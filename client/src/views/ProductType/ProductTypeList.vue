<script setup>
import { getAllProductType, deleteProductType } from "@/api/productType";
import { onMounted, reactive } from "vue";

const productTypes = reactive([]);

onMounted(() => {
  getAllProductType().then((res) => {
    productTypes.value = res.data.items;
  });
});

function handleDelete(value) {
  deleteProductType(value.id)
    .then(({ data }) => {
      getAllProductType().then((res) => {
        productTypes.value = res.data.items;
      });
    })
    .catch((error) => {
      console.log(error);
    });
}
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div class="m-4">
      <router-link
        :to="{ name: 'admin-product-type-create' }"
        class="text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800"
        aria-current="page"
        >Ajouter un type de produit</router-link
      >
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-400">
        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">Type de produit</th>
            <th scope="col" class="px-6 py-3">unité</th>
            <th scope="col" class="px-6 py-3">label</th>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            :key="item.id"
            v-for="item in productTypes.value"
            class="border-b bg-gray-800 border-gray-700"
          >
            <th
              scope="row"
              class="px-6 py-4 font-medium whitespace-nowrap text-white"
            >
              {{ item.name }}
            </th>
            <td class="px-6 py-4">{{ item.unit }}</td>
            <td class="px-6 py-4">{{ item.label }}</td>
            <td class="px-6 py-4">
              <router-link
                :to="{
                  name: 'admin-product-type',
                  params: { id: item.id },
                }"
                class="font-medium text-blue-500 hover:underline"
                >Modifier</router-link
              >
            </td>
            <td class="px-6 py-4">
              <button
                @click.prevent="handleDelete(item)"
                type="submit"
                class="font-medium text-blue-500 hover:underline"
              >
                Supprimer
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped></style>
