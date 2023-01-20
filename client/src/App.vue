<script setup>
import Header from "./components/Header.vue";
import { useGetCurrentUser } from "@/services";
import { onMounted, provide, reactive } from "vue";

const currentUser = reactive({ value: {} });
provide("auth_user", currentUser);
provide("app_refresh", refreshUser);

async function refreshUser() {
  currentUser.value = await useGetCurrentUser().catch(() => null);
  return currentUser.value;
}

onMounted(async () => {
  await refreshUser();
});
</script>

<template>
  <div className="h-screen">
    <Header />
    <main className="flex items-center justify-center">
      <router-view />
    </main>
  </div>
</template>

<style scoped>
.main {
  grid-template-columns: min-content auto;
}
</style>
