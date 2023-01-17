<script setup>
import Header from "./components/Header.vue";
</script>

<template>
  <div className="h-full">
    <Header />
    <main className="flex items-center justify-center h-screen">
      <router-view />
    </main>
  </div>
</template>

<style scoped></style>
