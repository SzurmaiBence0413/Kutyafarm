<template>
  <div
    class="alert alert-primary alert-dismissible fade show custom-center-alert"
    :class="{
      'alert-danger': type == 'Error',
      'alert-success': type == 'Success',
    }"
    role="alert"
    v-if="messages.length"
  >
    <div class="mb-2">
      <h5>{{ type }}</h5>
      <p v-for="message in messages" :key="message" class="m-0">
        {{ message }}
      </p>
    </div>
    <button type="button" class="btn-close" @click="close()" aria-label="Close"></button>
  </div>
</template>

<script>
import { mapState, mapActions } from "pinia";
import { useToastStore } from "@/stores/toastStore";

export default {
  methods: {
    ...mapActions(useToastStore, ["close"]),
  },
  computed: {
    ...mapState(useToastStore, ["messages", "type"]),
  },
};
</script>

<style scoped>
.custom-center-alert {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1080;
  min-width: 420px;
  max-width: 560px;
  padding: 20px 24px;
  font-size: 1.1rem;
  box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3), 0 5px 10px rgba(0, 0, 0, 0.05);
}

.custom-center-alert h5 {
  font-size: 1.35rem;
  margin-bottom: 10px;
}

.custom-center-alert p {
  font-size: 1.08rem;
  line-height: 1.45;
}
</style>
