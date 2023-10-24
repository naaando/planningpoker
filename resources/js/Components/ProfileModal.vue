<script setup>
import { ref } from "vue";
import Modal from "./Modal.vue";

const props = defineProps({
  username: {
    type: String,
    required: true,
  },
});

const finalName = ref("");

const emit = defineEmits(["name-updated"]);

const setUsername = () => {
  console.log(`Setting name: ${finalName.value}`);
  sessionStorage.setItem("username", finalName.value);
  emit("name-updated");
};
</script>

<template>
  <Modal
    max-width="sm"
    :show="!props.username.trim()"
  >
    <div class="items-stretch p-3 justify-stretch">
      <div class="my-1">Bem vindo! Para começar, digite seu nome.</div>

      <input
        type="text"
        v-model="finalName"
        class="w-full my-1 rounded"
        autofocus
        @keyup.enter="setUsername()"
      />

      <button
        class="block w-full px-4 py-2 my-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
        v-on:click="setUsername()"
      >
        Confirmar
      </button>
    </div>
  </Modal>
</template>
