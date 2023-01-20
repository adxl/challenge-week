<script setup>
import HeaderAdmin from "../components/HeaderAdmin.vue";
</script>

<template>
  <div class="w-full h-full">
    <div className="grid grid-cols-2 justify-items-start h-full">
      <HeaderAdmin class="justify-self-start" />
      <div className="flex items-center justify-center h-full">
        <router-view class="justify-self-center self-center" />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
