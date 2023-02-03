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
        <!-- LOGO -->
        <router-link to="/" class="flex items-center">
          <img src="/logo.png" class="h-10" alt="Flowbite Logo" />
        </router-link>
        <!-- LINK -->
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
          <ul
            class="flex flex-col p-4 mt-4 border rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white bg-gray-800 md:bg-gray-900 border-gray-700"
          >
            <!-- IS CLIENT OR DELIVERERS -->
            <li v-if="currentUser?.value && !currentUser.value.isAdmin">
              <router-link
                :to="{ name: 'orders' }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
                data-cy="orders-link"
              >
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  class="w-5 h-5 -ml-1 mr-1 float-left"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"
                  ></path>
                </svg>
                Mes Commandes
              </router-link>
            </li>

            <!-- IS CLIENT -->
            <li v-if="currentUser?.value && currentUser.value.isClient">
              <router-link
                :to="{ name: 'cart' }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
              >
                <svg
                  aria-hidden="true"
                  class="w-5 h-5 -ml-1 mr-1 float-left"
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

            <!-- IS ADMIN -->
            <li v-if="currentUser?.value?.id && currentUser.value.isAdmin">
              <router-link
                :to="{ name: 'admin-dashboard' }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
              >
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  class="w-5 h-5 -ml-1 mr-1 float-left"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z"
                  ></path>
                </svg>
                Gestion de la boutique
              </router-link>
            </li>
            <!-- IS CONNECTED -->
            <li v-if="currentUser?.value?.id">
              <router-link
                :to="{ name: 'store' }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
              >
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  class="w-5 h-5 -ml-1 mr-1 float-left"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                  ></path>
                </svg>
                La boutique
              </router-link>
            </li>
            <li v-if="currentUser.value?.['@id']">
              <router-link
                :to="{ name: 'profil', params: { id: currentUser.value.id } }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
              >
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  class="w-5 h-5 -ml-1 mr-1 float-left"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"
                  ></path>
                </svg>
                {{ currentUser.value.firstname }} {{ currentUser.value.lastname }}
              </router-link>
            </li>
            <li v-if="currentUser.value?.['@id']">
              <a
                href="#"
                class="block py-2 pl-3 pr-4 text-red-500 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
                @click.prevent="handleLogout"
                data-cy="logout-button"
              >
                <svg
                  fill="none"
                  stroke="currentColor"
                  class="w-5 h-5 -ml-1 mr-1 float-left"
                  stroke-width="1.5"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"
                  ></path>
                </svg>
                <span class="flex-1 whitespace-nowrap">Déconnexion</span>
              </a>
            </li>

            <!-- IS NOT CONNECTED -->
            <li v-if="!currentUser.value?.['@id']">
              <router-link
                :to="{ name: 'login' }"
                class="block py-2 pl-3 pr-4 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white"
              >
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  class="w-5 h-5 -ml-1 mr-1 float-left"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"
                  ></path>
                </svg>
                Se connecter
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>
