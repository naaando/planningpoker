<script setup>
defineProps({
  number: {
    type: Number,
  },
  owner: {
    type: String,
    required: true,
  },
  visible: {
    type: Boolean,
    required: true,
  },
});
</script>

<template>
  <div class="flex flex-col w-full h-full aspect-mobile">
    <div
      v-if="owner"
      class="w-auto h-auto pb-2 overflow-hidden text-center overflow-ellipsis whitespace-nowrap dark:text-white"
    >
      {{ owner }}
    </div>

    <div
      v-if="visible && number"
      class="flex flex-col justify-center h-full px-1 text-lg font-bold text-black bg-white rounded shadow"
    >
      <div>{{ number }}</div>

      <div
        class="flex items-center justify-center h-full mx-2 text-center border-2 border-blue-500 rounded"
      >
        {{ number }}
      </div>

      <div class="transform rotate-180">{{ number }}</div>
    </div>

    <div
      v-if="!visible && number"
      class="h-full px-1 text-lg font-bold text-black bg-blue-500 rounded shadow"
    ></div>

    <div
      v-if="!number"
      class="h-full px-1 text-lg font-bold text-black bg-gray-500 rounded shadow"
    ></div>
  </div>
</template>
