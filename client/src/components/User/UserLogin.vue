<template>
  <form @submit.prevent="handleSubmit" :class="{ 'was-validated': validated }" novalidate>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" v-model.trim="user.email" required />
      <div class="invalid-feedback">Please enter a valid email.</div>
    </div>

    <PasswordField class="mb-3 auth-pass" v-model="user.password" :label="'Password'" />

    <div class="d-flex gap-2 flex-wrap">
      <button type="submit" class="btn submit-btn">Login</button>
      <RouterLink to="/registration" class="btn switch-btn">Registration</RouterLink>
    </div>
  </form>
</template>

<script>
import PasswordField from "./PasswordField.vue";

class User {
  constructor(email = "", password = "") {
    this.email = email;
    this.password = password;
  }
}

export default {
  name: "UserLogin",
  components: {
    PasswordField,
  },
  data() {
    return {
      validated: false,
      user: new User(),
    };
  },
  methods: {
    handleSubmit(event) {
      const form = event.target;
      this.validated = true;
      if (form.checkValidity() === false) return;
      this.$emit("logIn", this.user);
    },
  },
};
</script>

<style scoped>
:deep(.form-label) {
  color: #f2f5f3;
}

:deep(.form-control) {
  border-radius: 0;
  border: 1px solid rgba(255, 255, 255, 0.35);
  background: rgba(255, 255, 255, 0.86);
}

:deep(.input-group .btn) {
  border-radius: 0;
}

.submit-btn,
.switch-btn {
  min-width: 140px;
  border-radius: 0;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.submit-btn {
  background: #19b6e5;
  border-color: #19b6e5;
  color: #fff;
}

.switch-btn {
  background: transparent;
  border: 1px solid #19b6e5;
  color: #dff8ff;
}

.switch-btn:hover {
  background: rgba(25, 182, 229, 0.16);
  color: #fff;
}
</style>
