<template>
  <AuthPetLayout title="Pet Adoption Form" subtitle="Login">
    <UserLogin @logIn="loginHandler" />
  </AuthPetLayout>
</template>

<script>
import { mapActions } from "pinia";
import { useUserLoginLogoutStore } from "@/stores/userLoginLogoutStore";
import AuthPetLayout from "@/components/User/AuthPetLayout.vue";
import UserLogin from "@/components/User/UserLogin.vue";

export default {
  name: "LoginView",
  components: {
    AuthPetLayout,
    UserLogin,
  },
  methods: {
    ...mapActions(useUserLoginLogoutStore, ["login"]),
    async loginHandler(user) {
      try {
        await this.login(user);
        this.$router.push("/");
      } catch (error) {}
    },
  },
};
</script>

<style scoped>
</style>
