<script setup>
import { computed } from "vue";

const sortedVotes = computed(() => {
  return votes.value.sort((a, b) => {
    return b.vote - a.vote;
  });
});
</script>
<template>
  <!-- <div class="flex space-x-3">
      <div
        class="w-12 h-32 "
        v-for="vote in sortedVotes"
        :key="vote.id"
      >
        <Card
          :number="vote.vote"
          :owner="vote.name"
          :visible="visible"
        ></Card>
      </div>
    </div> -->
</template>
