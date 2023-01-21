<script setup>
import { getAllProducts } from "@/api/product";
import { onMounted, reactive } from "vue";

const products = reactive([]);

onMounted(() => {
  getAllProducts().then((res) => {
    products.value = res.data.items;
  });
});
</script>

<template>
  <section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
      <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-2">
        <div
          v-for="item in products.value"
          :key="item.id"
          class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700"
        >
          <a href="#" class="ml-5">
            <img
              class="product-img"
              :src="`https://picsum.photos/seed/${item.id}/10/10/?blur=1`"
              alt="picture"
            />
          </a>
          <div class="p-5">
            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
              <a href="#">{{ item.name }}</a>
            </h3>
            <span class="text-gray-500 dark:text-gray-400">{{ item.category.name }}</span>
            <span class="text-gray-500 dark:text-gray-400">
              (
              <i class="text-gray-500 dark:text-gray-400"
                >{{ item.type.name }} {{ item.type.unit }} {{ item.type.label }}</i
              >
              )
            </span>
            <p class="mt-3 text-gray-500 dark:text-gray-400">{{ item.description }}</p>
            <ul class="flex space-x-4 sm:mt-0">
              <li>
                <div class="grid gap-2 mb-6 md:grid-cols-2">
                  <div>
                    <input
                      type="number"
                      class="h-full bg-gray-50 border border-gray-300 text-gray-900 text-sm block mb-2 m-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                      placeholder="quantité"
                    />
                  </div>
                  <button
                    type="button"
                    class="text-white h-full bg-blue-700 block mb-2 m-2 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                  >
                    <svg
                      aria-hidden="true"
                      class="w-5 h-5 mr-2 -ml-1"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                      ></path>
                    </svg>
                    <strong class="text-xl whitespace-nowrap"> {{ item.price }} € </strong>
                  </button>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.color-green {
  fill: green;
}

.product-img {
  image-rendering: pixelated;
  border-radius: 8px;
  width: 200px;
  max-width: 200px;
  height: 200px;
  max-height: 200px;
}
</style>
