<script setup>
import Deck from "@/Components/Deck.vue";
import BaseTable from "@/Components/VotePresentation/BaseTable.vue";
import HorizontalTable from "@/Components/VotePresentation/HorizontalTable.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { rooms, rounds } from "../api";

const props = defineProps({
  roomSlug: {
    type: String,
    required: true,
  },
  roomName: {
    type: String,
    required: true,
  },
});

const loaded = ref(false);
const roundId = ref(null);
const votes = ref([]);
const count = ref(0);
const average = ref(0);
const visible = ref(false);

const reveal = () => {
  rounds(roundId.value).finish(!visible.value);
};

onMounted(async () => {
  const room = await rooms(props.roomSlug).get();

  if (room.data.data.round) {
    loaded.value = true;
    roundId.value = room.data.data.round.id;
    votes.value = room.data.data.round.votes;
    count.value = room.data.data.round.votes_count;
    average.value = room.data.data.round.votes_average;
    visible.value = room.data.data.round.finished_at !== null;
  }

  Echo.channel(`rooms.${props.roomSlug}`)
    .listen("RoundCreated", (e) => {
      loaded.value = true;
      roundId.value = e.round.id;
      votes.value = e.round.votes;
      count.value = e.round.votes_count;
      average.value = e.round.votes_average;
      visible.value = e.round.finished_at !== null;
    })
    .listen("RoundUpdated", (e) => {
      votes.value = e.round.votes;
      count.value = e.round.votes_count;
      average.value = e.round.votes_average;
      visible.value = e.round.finished_at !== null;
    });
});
</script>

<template>
  <Head :title="'Room ' + roomName" />

  <MainLayout v-slot="{ username }">
    <BaseTable
      v-if="loaded"
      v-slot="{ directionalVotes }"
      :votes="votes"
      :count="count"
      :average="average"
      :visible="visible"
    >
      <div class="hidden sm:block">
        <HorizontalTable
          :visible="visible"
          :directionalVotes="directionalVotes"
          :reveal="reveal"
        ></HorizontalTable>
      </div>

      <div class="block sm:hidden text-center text-white">
        Not ready for mobile yet
      </div>

      <!-- <div class="hidden sm:block">
        <VerticalTable
          :visible="visible"
          :directionalVotes="directionalVotes"
          :reveal="reveal"
        ></VerticalTable>
      </div> -->
    </BaseTable>

    <Deck
      v-if="username && roundId"
      :round="roundId"
      :username="username"
    ></Deck>
  </MainLayout>
</template>
