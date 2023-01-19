<script setup>
import Header from "./components/Header.vue";
import HeaderAdmin from "./components/HeaderAdmin.vue";
import { useGetCurrentUser } from "@/services";
import { onMounted, onUpdated, provide, ref, watch } from "vue";

let currentUser = null;
const loading = ref(false);
provide("auth_user", currentUser);

async function refreshUser() {
  currentUser = await useGetCurrentUser().catch(() => null);
}

watch(currentUser, () => {
  provide("auth_user", currentUser);
});

onMounted(async () => {
  await refreshUser();
  loading.value = true;
});
onUpdated(async () => {
  await refreshUser();
  loading.value = true;
});
</script>

<template>
  <div className="h-screen" v-if="loading">
    <Header />
    <main v-if="currentUser?.isAdmin" className="main grid grid-cols-2 justify-items-start h-full">
      <HeaderAdmin class="justify-self-start" />
      <router-view class="justify-self-center self-center" />
    </main>
    <main v-else className="flex items-center justify-center h-full">
      <router-view class="" />
    </main>
  </div>
</template>

<style scoped>
.main {
  grid-template-columns: min-content auto;
}
</style>
