<script setup>
import { defineProps, ref } from "vue";
import { getCart, updateCart } from "@/idbHelper";

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
});

const quantity = ref(0);

const handleAddToCart = async () => {
  const cart = await getCart();
  if (quantity.value <= 0) {
    return;
  }

  let exists = cart.products.find((product) => {
    if (product.id === props.item.id) {
      product.quantity += quantity.value;
      return true;
    }
  });

  if (!exists) {
    cart.products.push({
      id: props.item.id,
      name: props.item.name,
      price: props.item.price,
      quantity: quantity.value,
    });
  }

  cart.total += quantity.value * props.item.price;

  await updateCart(cart);
};
</script>

<template>
  <div class="flex flex-col items-center p-3 rounded-lg shadow bg-gray-800 border-gray-700">
    <img
      class="product-img"
      :src="`https://picsum.photos/seed/${item.id}/10/10/?blur=1`"
      alt="picture"
    />
    <div class="py-5 text-start w-full">
      <h3 class="text-xl font-bold tracking-tight text-white">
        <a href="#">{{ item.name }}</a>
      </h3>
      <span class="text-gray-400">{{ item.category.name }}</span>
      <span class="text-gray-400">
        (
        <i class="text-gray-400">{{ item.type.name }} {{ item.type.unit }} {{ item.type.label }}</i>
        )
      </span>
      <p class="mt-3 text-gray-400">{{ item.description }}</p>
    </div>
    <div class="mt-auto">
      <div class="flex items-end justify-end pr-3 mb-2 gap-2 text-white">
        <div class="flex items-center">
          <i class="fa-solid fa-thumbs-up">&nbsp;</i>
          <span>{{ item.reviews.filter((i) => i.rating).length }}</span>
        </div>
        <span>|</span>
        <div class="flex items-center">
          <i class="fa-solid fa-thumbs-down">&nbsp;</i>
          <span>{{ item.reviews.filter((i) => !i.rating).length }}</span>
        </div>
      </div>
      <div class="grid gap-2 grid-cols-2">
        <input
          type="number"
          min="0"
          v-model="quantity"
          class="h-full border text-sm block rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
          placeholder="quantité"
        />
        <button
          type="button"
          class="text-white h-full block focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 text-center inline-flex items-center mr-2 bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
          @click="handleAddToCart(item)"
        >
          <svg
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
            ></path>
          </svg>
          <strong class="text-md whitespace-nowrap pl-1"> {{ item.price }} € </strong>
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.product-img {
  image-rendering: pixelated;
  border-radius: 8px;
  width: 100%;
  height: 200px;
  max-height: 200px;
  object-fit: cover;
}
</style>
