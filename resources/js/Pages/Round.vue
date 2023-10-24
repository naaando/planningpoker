<script setup>
import Deck from "@/Components/Deck.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { onMounted } from "vue";
import { rounds } from "../api";
import MainLayout from "@/Layouts/MainLayout.vue";
import BaseTable from "@/Components/VotePresentation/BaseTable.vue";
import HorizontalTable from "@/Components/VotePresentation/HorizontalTable.vue";
import VerticalTable from "@/Components/VotePresentation/VerticalTable.vue";

const props = defineProps({
  roundId: {
    type: String,
    required: true,
  },
});

const loaded = ref(false);
const votes = ref([]);
const count = ref(0);
const average = ref(0);

onMounted(() => {
  rounds(props.roundId)
    .get()
    .then((response) => {
      loaded.value = true;
      votes.value = response.data.data.votes;
      count.value = response.data.data.votes_count;
      average.value = response.data.data.votes_average;
    });

  Echo.channel(`rounds.${props.roundId}`).listen("RoundUpdated", (e) => {
    console.log("Round updated", e.round);
    votes.value = e.round.votes;
    count.value = e.round.votes_count;
    average.value = e.round.votes_average;
  });
});
</script>

<template>
  <Head title="Round" />

  <MainLayout v-slot="{ username }">
    <BaseTable
      v-if="loaded"
      v-slot="{ visible, directionalVotes, reveal }"
      :votes="votes"
      :count="count"
      :average="average"
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
      v-if="username"
      :round="roundId"
      :username="username"
    ></Deck>
  </MainLayout>
</template>
