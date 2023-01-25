<script setup>
import { getAllProducts, deleteProduct } from "@/api/product";
import { onMounted, reactive } from "vue";

const products = reactive([]);

onMounted(() => {
  getAllProducts().then((res) => {
    products.value = res.data.items;
  });
});

function handleDelete(value) {
  deleteProduct(value.id)
    .then(() => {
      getAllProducts().then((res) => {
        products.value = res.data.items;
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
        :to="{ name: 'admin-product-create' }"
        class="text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800"
        aria-current="page"
        >Ajouter un produit</router-link
      >
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-400">
        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">name</th>
            <th scope="col" class="px-6 py-3">Catégorie produit</th>
            <th scope="col" class="px-6 py-3">Type produit</th>
            <th scope="col" class="px-6 py-3">Prix</th>
            <th scope="col" class="px-6 py-3">Quantitée</th>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            :key="item.id"
            v-for="item in products.value"
            class="border-b bg-gray-800 border-gray-700"
          >
            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
              {{ item.name }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
              {{ item.category.name }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
              {{ item.type.name }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
              {{ item.price }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
              {{ item.quantity }}
            </th>
            <td class="px-6 py-4">
              <router-link
                :to="{
                  name: 'admin-product',
                  params: { id: item.id },
                }"
                class="font-medium text-blue-500 hover:underline"
                >Edit</router-link
              >
            </td>
            <td class="px-6 py-4">
              <button
                @click.prevent="handleDelete(item)"
                type="submit"
                class="font-medium text-blue-500 hover:underline"
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
