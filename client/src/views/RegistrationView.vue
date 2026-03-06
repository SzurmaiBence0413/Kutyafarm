<template>
  <AuthPetLayout title="Pet Adoption Form" subtitle="Registration">
    <UserRegistration ref="form" @createUser="handlerCreateUser" />
  </AuthPetLayout>
</template>

<script>
import { mapActions } from "pinia";
import { useUserLoginLogoutStore } from "@/stores/userLoginLogoutStore";
import AuthPetLayout from "@/components/User/AuthPetLayout.vue";
import UserRegistration from "@/components/User/UserRegistration.vue";

export default {
  name: "RegistrationView",
  components: {
    AuthPetLayout,
    UserRegistration,
  },
  methods: {
    ...mapActions(useUserLoginLogoutStore, ["register"]),
    async handlerCreateUser({ data, done }) {
      try {
        await this.register(data);
        done(true);
      } catch (err) {
        if (err.response && err.response.status === 422) {
          this.$refs.form.setServerErrors(err.response.data.errors);
          done(false);
        } else {
          done(false);
        }
      }
    },
  },
};
</script>

<style scoped>
</style>
