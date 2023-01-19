<script setup>
import { getOrder } from "@/api/order";
import { reactive, onMounted } from "vue";
import { useRouter } from "vue-router";

const order = reactive({
  value: {},
});

const route = useRouter();
const id = route.currentRoute.value.params.id ?? null;

onMounted(() => {
  getOrder(id)
    .then((res) => {
      console.log(res);
      order.value = res.data;
    })
    .catch(() => {
      route.push({ name: "orders" });
    });
});
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div
      class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
    >
      <h5
        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
      >
        Commande N°{{ order.value.id }}
      </h5>
      <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
          <li class="py-3 sm:py-4">
            <p
              class="text-sm font-medium text-gray-900 truncate dark:text-white"
            >
              {{ order.value.client?.firstname }}
              {{ order.value.client?.lastname }}
            </p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
