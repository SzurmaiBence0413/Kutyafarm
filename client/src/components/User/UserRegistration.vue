<template>
  <form @submit.prevent="handleSubmit" :class="{ 'was-validated': validated }" novalidate>
    <div class="mb-3">
      <label for="userName" class="form-label">User Name</label>
      <input
        type="text"
        class="form-control"
        id="userName"
        v-model.trim="userName"
        @input="clearError('name')"
        required
      />
      <div v-if="!serverErrors.name" class="invalid-feedback">
        User name is required.
      </div>
      <div v-if="serverErrors.name" class="invalid-feedback d-block">
        {{ serverErrors.name[0] }}
      </div>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input
        type="email"
        class="form-control"
        id="email"
        v-model.trim="email"
        @input="clearError('email')"
        required
      />
      <div v-if="!serverErrors.email" class="invalid-feedback">Please enter a valid email.</div>
      <div v-if="serverErrors.email" class="invalid-feedback d-block">
        {{ serverErrors.email[0] }}
      </div>
    </div>

    <PasswordField
      class="mb-3"
      ref="pass1Comp"
      v-model="password"
      :label="'Password'"
      :inputRef="'firstInput'"
      :label-id="'password'"
      :serverErrors="serverErrors"
    />

    <PasswordField
      ref="pass2Comp"
      v-model="confirmPassword"
      :label="'Confirm Password'"
      :inputRef="'confirmInput'"
      :label-id="'confirmPassword'"
      :passwordErrorMessage="passwordErrorMessage"
      :serverErrors="serverErrors"
    />

    <div class="d-flex gap-2 flex-wrap mt-3">
      <button type="submit" class="btn submit-btn">Registration</button>
      <button type="button" class="btn switch-btn" @click="this.$router.push('/login')">Cancel</button>
    </div>
  </form>
</template>

<script>
import PasswordField from "./PasswordField.vue";

export default {
  name: "UserRegistration",
  components: {
    PasswordField,
  },
  data() {
    return {
      userName: "",
      email: "",
      password: "",
      confirmPassword: "",
      validated: false,
      passwordErrorMessage: "",
      serverErrors: {},
    };
  },
  methods: {
    validatePasswords() {
      const comp2 = this.$refs.pass2Comp;
      const input2 = comp2?.$refs[comp2.inputRef];

      if (this.password !== this.confirmPassword) {
        input2.setCustomValidity("Passwords do not match.");
        this.passwordErrorMessage = "Passwords do not match.";
      } else {
        input2.setCustomValidity("");
        this.passwordErrorMessage = "";
      }
    },
    handleSubmit(event) {
      this.validatePasswords();
      const form = event.target;
      this.validated = true;

      if (form.checkValidity() === false) return;

      const data = {
        name: this.userName,
        email: this.email,
        password: this.password,
      };

      this.$emit("createUser", {
        data,
        done: (success) => {
          if (success) {
            this.$router.push("/login");
          }
        },
      });
    },
    setServerErrors(errors) {
      this.serverErrors = errors;
    },
    clearError(field) {
      if (this.serverErrors[field]) {
        delete this.serverErrors[field];
      }
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
