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
  <div className="min-height h-full">
    <Header style="z-index: 1" />
    <main className="flex min-height items-center justify-center bg-gray-600 min-h-full h-full">
      <router-view class="min-h-full h-full" />
    </main>
  </div>
</template>

<style scoped>
.min-height {
  min-height: calc(100vh - 72px);
}
</style>
