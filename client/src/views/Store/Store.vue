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
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
      <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-2">
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
