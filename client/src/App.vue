<script setup>
import Header from "./components/Header.vue";
</script>

<template>
    <div>
        <router-link to="/">Accueil</router-link> |
        <router-link :to="{ name: 'register' }">Inscription</router-link> |
        <router-link :to="{ name: 'login' }">Se connecter</router-link>
        <router-view></router-view>
    </div>
    <div id="app" className="h-full bg-regal-orange dark:bg-[#202023]">
        <Header />
    </div>
</template>

<style scoped></style>
