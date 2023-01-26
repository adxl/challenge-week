<script setup>
import HeaderAdmin from "../components/HeaderAdmin.vue";
</script>

<template>
  <div class="min-height flex w-full self-start">
    <HeaderAdmin class="justify-self-start" />
    <main className="relative left-64 flex items-center justify-center h-max">
      <router-view class="my-5" />
    </main>
  </div>
</template>

<style scoped>
.left-64 {
  width: calc(100% - 16rem);
}
</style>
