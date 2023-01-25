<script setup>
import HeaderAdmin from "../components/HeaderAdmin.vue";
</script>

<template>
  <div class="flex w-full h-full self-start">
    <HeaderAdmin class="justify-self-start" />
    <main className="flex items-center justify-center h-full">
      <router-view class="justify-self-center self-center" />
    </main>
  </div>
</template>

<style scoped></style>
