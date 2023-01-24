<script setup>
import { inject } from "vue";
import { clearCart } from "@/idbHelper";
const currentUser = inject("auth_user");

const handleLogout = () => {
  sessionStorage.removeItem("cw-app-token");
  clearCart();
  window.location.href = "/login";
};
</script>

<template>
  <header class="sticky top-0">
    <nav class="bg-gray-900 border-gray-200 px-2 sm:px-4 py-2.5">
      <div class="container flex flex-wrap items-center justify-between mx-auto">
        <router-link to="/" class="flex items-center">
          <img src="/logo.png" class="h-10" alt="Flowbite Logo" />
        </router-link>
        <button
          data-collapse-toggle="navbar-default"
          type="button"
          class="inline-flex items-center p-2 ml-3 text-sm rounded-lg md:hidden focus:outline-none focus:ring-2 text-gray-400 hover:bg-gray-700 focus:ring-gray-600"
          aria-controls="navbar-default"
          aria-expanded="false"
        >
          <span class="sr-only">Open main menu</span>
          <svg
            class="w-6 h-6"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
          <ul
            class="flex flex-col p-4 mt-4 border rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white bg-gray-800 md:bg-gray-900 border-gray-700"
          >
            <li v-if="currentUser?.value?.id">
              <router-link
                :to="{ name: 'store' }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
                >La boutique</router-link
              >
            </li>
            <li v-if="currentUser?.value && !currentUser.value.isAdmin">
              <router-link
                :to="{ name: 'orders' }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
                >Mes Commandes</router-link
              >
            </li>
            <li v-if="currentUser?.value && !currentUser.value.isAdmin">
              <router-link
                :to="{ name: 'cart' }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
              >
                <svg
                  aria-hidden="true"
                  class="w-5 h-5 mr-2 -ml-1 float-left"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                  ></path>
                </svg>
                Mon panier
              </router-link>
            </li>

            <li v-if="!currentUser.value?.['@id']">
              <router-link
                :to="{ name: 'login' }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
                >Se connecter</router-link
              >
            </li>
            <li v-else>
              <a
                href="#"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
                @click="handleLogout"
              >
                <span class="flex-1 ml-3 text-red-500 whitespace-nowrap">Déconnexion</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>
