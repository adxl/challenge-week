<script setup>
import { useRoute } from "vue-router";
import { verifyToken } from "@/api/token";
const route = useRoute();
const token = route.params.token;

const response = await verifyToken(token);
if (response.status === 200) {
    console.log("Token verified");
} else {
    console.log("Token not verified");
}
</script>

<template>
    <h1>Vérification du compte</h1>
</template>

<style scoped></style>
