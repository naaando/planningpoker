<script setup>
import { ref, watch } from "vue";

const props = defineProps({
  username: {
    type: String,
    required: true,
  },
});

const finalName = ref("");

watch(
  () => props.username,
  () => {
    finalName.value = props.username;
  }
);

const emit = defineEmits(["name-updated"]);

const setUsername = () => {
  console.log(`Setting name: ${finalName.value}`);
  sessionStorage.setItem("username", finalName.value);
  emit("name-updated");
};
</script>

<template>
  <div
    class="flex flex-col items-center px-4 py-2 space-x-2 sm:flex-row text-gray-900 dark:text-white bg-blue-700"
  >
    <h1 class="my-2 text-xl font-bold text-center sm:mr-auto">
      Planning Poker
    </h1>

    <input
      type="text"
      v-model="finalName"
      v-on:change="setUsername()"
      class="p-2 border border-blue-900 dark:border-blue-500 rounded bg-slate-200 dark:bg-slate-700 bg-opacity-70"
    />
  </div>
</template>
