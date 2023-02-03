<script setup>
const handleDropdown = (id) => {
  const dropdown = document.getElementById(id);
  if (dropdown.classList.contains("hidden")) {
    dropdown.classList.remove("hidden");
  } else {
    dropdown.classList.add("hidden");
  }
};
</script>

<template>
  <aside class="h-full w-64 fixed" aria-label="Sidebar">
    <div class="px-3 py-4 h-full w-64 overflow-y-auto bg-gray-800">
      <ul class="space-y-2">
        <li>
          <a
            href="#"
            class="flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-gray-700"
          >
            <svg
              aria-hidden="true"
              class="w-6 h-6 transition duration-75 text-gray-400 group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
              <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
            <router-link class="h-full w-full" :to="{ name: 'admin-dashboard' }">
              <span class="ml-3"> Tableau de bord</span></router-link
            >
          </a>
        </li>
        <li>
          <button
            type="button"
            class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group text-white hover:bg-gray-700"
            aria-controls="dropdown-profil"
            data-collapse-toggle="dropdown-profil"
            @click="handleDropdown('dropdown-profil')"
          >
            <svg
              aria-hidden="true"
              class="flex-shrink-0 w-6 h-6 transition duration-75 text-gray-400 group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Profils</span>
            <svg
              sidebar-toggle-item
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          <ul id="dropdown-profil" class="py-2 space-y-2">
            <li>
              <router-link
                class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg pl-11 group text-white hover:bg-gray-700"
                :to="{ name: 'admin-profils-clients' }"
              >
                • Clients
              </router-link>
            </li>
            <li>
              <router-link
                class="h-full flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg pl-11 group text-white hover:bg-gray-700"
                :to="{ name: 'admin-profils-deliverers' }"
              >
                • Livreurs
              </router-link>
            </li>
          </ul>
        </li>
        <li>
          <a
            href="#"
            class="flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-gray-700"
          >
            <svg
              aria-hidden="true"
              class="flex-shrink-0 w-6 h-6 transition duration-75 text-gray-400 group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
              ></path>
            </svg>
            <router-link class="h-full w-full" :to="{ name: 'admin-orders' }">
              <span class="flex-1 ml-3 whitespace-nowrap">Liste des commandes</span>
            </router-link>
          </a>
        </li>
        <li>
          <a
            href="#"
            class="flex items-center p-2 text-base font-normal rounded-lg text-white hover:bg-gray-700"
          >
            <svg
              aria-hidden="true"
              class="w-6 h-6 transition duration-75 text-gray-400 group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
              <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
            <router-link class="h-full w-full" :to="{ name: 'admin-kyc-list' }">
              <span class="ml-3">Vérification des KYC</span></router-link
            >
          </a>
        </li>
        <li>
          <button
            type="button"
            class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group text-white hover:bg-gray-700"
            aria-controls="dropdown-boutique"
            data-collapse-toggle="dropdown-boutique"
            @click="handleDropdown('dropdown-boutique')"
          >
            <svg
              aria-hidden="true"
              class="flex-shrink-0 w-6 h-6 transition duration-75 text-gray-400 group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="flex-1 ml-3 text-left whitespace-nowrap">Boutique</span>
            <svg
              sidebar-toggle-item
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          <ul id="dropdown-boutique" class="py-2 space-y-2">
            <li>
              <router-link
                class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg pl-11 group text-white hover:bg-gray-700"
                :to="{ name: 'admin-products' }"
              >
                • Produits
              </router-link>
            </li>
            <li>
              <router-link
                class="h-full flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg pl-11 group text-white hover:bg-gray-700"
                :to="{ name: 'admin-product-types' }"
              >
                • Types de produits</router-link
              >
            </li>
            <li>
              <router-link
                class="h-full flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg pl-11 group text-white hover:bg-gray-700"
                :to="{ name: 'admin-product-categorys' }"
              >
                • Catégories
              </router-link>
            </li>
          </ul>
        </li>
        <li>
          <router-link
            class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group text-white hover:bg-gray-700"
            :to="{ name: 'adminReviews' }"
          >
            <svg
              fill="currentColor"
              viewBox="0 0 24 24"
              class="flex-shrink-0 w-6 h-6 transition duration-75 text-gray-400 group-hover:text-white"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5zm6.61 10.936a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
              ></path>
              <path
                d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"
              ></path>
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">Avis</span>
          </router-link>
        </li>
      </ul>
    </div>
  </aside>
</template>
