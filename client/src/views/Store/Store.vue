<script setup>
import { getAllProducts } from "@/api/product";
import { onMounted, reactive } from "vue";
import Product from "../../components/Store/Product.vue";

const products = reactive([]);

onMounted(() => {
  getAllProducts().then((res) => {
    products.value = res.data.items;
  });
});
</script>

<template>
  <section>
    <div class="py-8 px-4 mx-auto max-w-screen lg:py-16 lg:px-16">
      <div
        class="grid gap-2 mb-6 lg:mb-16 sm:grid-cols-2 md:grid-cols-4 xl:grid-cols-6"
        data-cy="store-products-list"
      >
        <Product v-for="item in products.value" :key="item.id" :item="item" />
      </div>
    </div>
  </section>
</template>

<style scoped>
.color-green {
  fill: green;
}
</style>
