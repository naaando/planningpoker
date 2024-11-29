<script setup>
import Nav from "@/Components/Nav.vue";
import ProfileModal from "@/Components/ProfileModal.vue";
import user from "@/user";
import { onMounted, ref } from "vue";

const username = ref("");

const fetchUsername = () => {
  username.value = user.retrieveUsername() ?? "";
  console.log(`Name on session storage: ${username.value}`);
};

onMounted(() => {
  fetchUsername();
});
</script>

<template>
  <Nav
    :username="username"
    @name-updated="fetchUsername"
  ></Nav>

  <slot :username="username"></slot>

  <ProfileModal
    :username="username"
    @name-updated="fetchUsername"
  ></ProfileModal>
</template>
