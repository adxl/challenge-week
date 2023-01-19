<script setup>
import {
  getAllProductCategory,
  deleteProductCategory,
} from "@/api/productCategory";
import { onMounted, reactive } from "vue";

const productTypes = reactive([]);

onMounted(() => {
  getAllProductCategory().then((res) => {
    productTypes.value = res.data.items;
  });
});

function handleDelete(value) {
  deleteProductCategory(value.id)
    .then(({ data }) => {
      getAllProductCategory().then((res) => {
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
        :to="{ name: 'product-category-create' }"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        aria-current="page"
        >Ajouter une catégorie de produit</router-link
      >
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th scope="col" class="px-6 py-3">Catégorie produit</th>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            :key="item.id"
            v-for="item in productTypes.value"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
          >
            <th
              scope="row"
              class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{ item.name }}
            </th>
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
