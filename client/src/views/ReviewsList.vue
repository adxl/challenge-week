<script setup>
import { getAllDelivererReviews, getAllProductReviews } from "@/api/reviews";
import { watch, onMounted, ref } from "vue";

const delivererReviews = ref([]);

onMounted(() => {
  getAllDelivererReviews().then(({ data }) => {
    delivererReviews.value = data.items;
  });
});

watch(delivererReviews, () => console.log(delivererReviews.value));
</script>

<template>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-400">
      <thead class="text-xs uppercase bg-gray-700 text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">Commande</th>
          <th scope="col" class="px-6 py-3">Avis</th>
          <th scope="col" class="px-6 py-3">Livreur</th>
        </tr>
      </thead>
      <tbody>
        <tr
          :key="item.id"
          v-for="item in delivererReviews"
          class="border-b bg-gray-800 border-gray-700"
        >
          <td class="px-6 py-4 font-medium whitespace-nowrap text-white">
            CM-BBR-{{ item.originOrder["id"] }}
          </td>
          <td class="px-6 py-4 font-medium whitespace-nowrap text-white">
            {{ item.comment }}
          </td>
          <td class="px-6 py-4">
            {{ item.originOrder.deliverer.firstname }} {{ item.originOrder.deliverer.lastname }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
