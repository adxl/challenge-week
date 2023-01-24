<script setup>
import Header from "./components/Header.vue";
import { useGetCurrentUser } from "@/services";
import { onMounted, provide, reactive, ref } from "vue";

const currentUser = reactive({ value: {} });
const headerHeight = ref(0);
provide("auth_user", currentUser);
provide("app_refresh", refreshUser);

async function refreshUser() {
  currentUser.value = await useGetCurrentUser().catch(() => null);
  return currentUser.value;
}

onMounted(async () => {
  headerHeight.value = document.querySelector("header").clientHeight;
  await refreshUser();
});
</script>

<template>
  <div className="h-screen">
    <Header style="z-index: 1" />
    <main className="flex items-center justify-center bg-gray-600 min-h-full">
      <router-view />
    </main>
  </div>
</template>

<style scoped>
main {
  min-height: calc(100% - 72px);
}
</style>
