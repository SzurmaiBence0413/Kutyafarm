<template>
  <Transition name="modal-fade">
    <div v-if="isOpen">
      <div class="modal fade show" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content bg-light shadow-lg">
            <div class="modal-header bg-warning-subtle">
              <h5 class="modal-title">{{ title }}</h5>
              <button
                type="button"
                class="btn-close"
                aria-label="Close"
                @click="$emit('cancel')"
              ></button>
            </div>
            <div class="modal-body">
              <p class="m-0">{{ message }}</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="$emit('cancel')">
                Cancel
              </button>
              <button type="button" class="btn btn-danger" @click="$emit('confirm')">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-backdrop fade show"></div>
    </div>
  </Transition>
</template>

<script>
export default {
  name: "DogDeleteConfirmModal",
  props: {
    isOpen: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default: "Delete Dog",
    },
    message: {
      type: String,
      default: "Are you sure you want to delete this dog?",
    },
  },
  emits: ["cancel", "confirm"],
};
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.2s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}
</style>

