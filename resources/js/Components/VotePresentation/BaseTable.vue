<script setup>
import { computed } from "vue";

const props = defineProps({
  votes: {
    required: true,
  },
  count: {
    type: Number,
    required: true,
  },
  average: {
    type: Number,
    required: true,
  },
  finished: {
    type: Boolean,
    required: true,
  },
});

const directionalVotes = computed(() => {
  const crossAxis = [2, 3];
  let directions = [[], [], [], [], [], []];
  let cursor = 0;

  props.votes.forEach((vote) => {
    while (crossAxis.includes(cursor) && directions[cursor].length > 1) {
      cursor++;
    }

    directions[cursor].push(vote);
    cursor++;

    if (cursor >= directions.length) {
      cursor = 0;
    }
  });

  return {
    mainAxisStart: directions[0].concat(directions[4]),
    mainAxisEnd: directions[1].concat(directions[5]),
    crossAxisStart: directions[2],
    crossAxisEnd: directions[3],
  };
});
</script>

<template>
  <slot
    :directionalVotes="directionalVotes"
    :count="props.count"
    :average="props.average"
  ></slot>
</template>
