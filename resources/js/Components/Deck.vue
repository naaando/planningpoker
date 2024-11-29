<script setup>
import { votes } from "@/api";
import { onMounted, ref, watch } from "vue";

const props = defineProps({
  username: {
    type: String,
    required: true,
  },
  round: {
    type: String,
    required: true,
  },
});

const vote = ref(null);
const items = [0, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89];
const selectedItem = ref(null);

onMounted(() => {
  vote.value = votes(props.round, props.username);
  vote.value.join().then((response) => {
    selectedItem.value = response.vote;
  });
});

watch(
  () => props.round,
  () => {
    selectedItem.value = null;
    vote.value = votes(props.round, props.username);
    vote.value.join().then((response) => {
      selectedItem.value = response.vote;
    });
  }
);

watch([() => props.name, selectedItem], () => {
  vote.value.set(selectedItem.value);
});
</script>

<template>
  <div
    class="fixed bottom-0 flex items-center justify-center w-full space-x-3 text-center"
  >
    <button
      :key="item"
      v-for="item in items"
      class="px-3 py-6 text-lg font-bold rounded-t w-14"
      v-on:click="selectedItem = item"
      :class="{
        'bg-blue-500 text-white shadow': selectedItem === item,
        'bg-white text-black shadow': selectedItem !== item,
      }"
    >
      {{ item }}
    </button>
  </div>
</template>
