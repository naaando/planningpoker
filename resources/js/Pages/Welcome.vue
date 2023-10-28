<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { createRound, createRoom } from "@/api";
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";

const roomName = ref("");
const error = ref("");

async function start() {
  try {
    const room = await createRoom(roomName.value);
    await createRound(room.data.data.id);
    router.get(`/${room.data.data.slug}`);
  } catch (e) {
    error.value = e.response.data.message;
  }
}
</script>

<template>
  <Head title="New Room" />

  <MainLayout>
    <div class="absolute top-0 flex items-center justify-center w-full h-full">
      <form
        class="bg-white rounded p-3"
        @submit.prevent="start()"
      >
        <input
          type="text"
          v-model="roomName"
          class="w-full my-1 rounded"
          autofocus
          required
          @blur="error = ''"
        />

        <p
          class="text-red-500"
          v-if="error"
        >
          {{ error }}
        </p>

        <button
          class="block w-full px-4 py-2 my-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
        >
          Create Room!
        </button>
      </form>
    </div>
  </MainLayout>
</template>

<style>
.bg-dots-darker {
  background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
  .dark\:bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
  }
}
</style>
