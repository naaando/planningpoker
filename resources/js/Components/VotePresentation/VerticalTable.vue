<script setup>
import Card from "../Card.vue";

const props = defineProps({
  visible: {
    type: Boolean,
    required: true,
  },
  directionalVotes: {
    type: Object,
    required: true,
  },
  reveal: {
    type: Function,
    required: true,
  },
});
</script>

<template>
  <div class="items-center justify-center w-full pt-3 sm:pt-16">
    <table class="w-full container mx-auto max-w-6xl">
      <tbody>
        <tr id="table-main-start">
          <td colspan="3">
            <div
              class="flex items-center justify-around space-x-3 w-3/4 sm:w-1/3 mx-auto"
            >
              <div
                class="w-12 h-32"
                v-for="vote in props.directionalVotes.mainAxisStart"
                :key="vote.id"
              >
                <Card
                  :number="vote.vote"
                  :owner="vote.name"
                  :visible="visible"
                ></Card>
              </div>
            </div>
          </td>
        </tr>
        <tr id="table-middle">
          <td
            id="table-cross-start"
            class="w-1/4"
          >
            <div class="flex flex-col items-end justify-center space-y-3">
              <div
                class="w-12 h-32"
                v-for="vote in props.directionalVotes.crossAxisStart"
                :key="vote.id"
              >
                <Card
                  :number="vote.vote"
                  :owner="vote.name"
                  :visible="visible"
                ></Card>
              </div>
            </div>
          </td>
          <td
            id="table-center"
            class="w-2/4"
          >
            <div class="sm:p-5">
              <div
                class="rounded-full w-full aspect-mobile sm:aspect-video bg-white border-8 border-blue-700 drop-shadow-sm flex justify-center items-center"
              >
                <div class="text-center">
                  <button
                    class="px-3 py-2 bg-red-500 text-white rounded-full aspect-square"
                    @click="reveal()"
                  >
                    Reveal
                  </button>
                </div>
              </div>
            </div>
          </td>
          <td
            id="table-cross-end"
            class="w-1/4"
          >
            <div class="flex flex-col items-start justify-center space-y-3">
              <div
                class="w-12 h-32"
                v-for="vote in props.directionalVotes.crossAxisEnd"
                :key="vote.id"
              >
                <Card
                  :number="vote.vote"
                  :owner="vote.name"
                  :visible="visible"
                ></Card>
              </div>
            </div>
          </td>
        </tr>
        <tr id="table-main-end">
          <td colspan="3">
            <div
              class="flex items-center justify-around space-x-3 w-3/4 sm:w-1/3 mx-auto"
            >
              <div
                class="w-12 h-32"
                v-for="vote in props.directionalVotes.mainAxisEnd"
                :key="vote.id"
              >
                <Card
                  :number="vote.vote"
                  :owner="vote.name"
                  :visible="visible"
                ></Card>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
