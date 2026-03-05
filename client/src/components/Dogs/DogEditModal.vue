<template>
  <Transition name="modal-fade">
    <div v-if="isOpen">
      <div class="modal fade show" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content bg-light shadow-lg">
            <div class="modal-header bg-warning-subtle">
              <h5 class="modal-title">{{ title }}</h5>
              <button
                type="button"
                class="btn-close"
                aria-label="Close"
                @click="$emit('close')"
              ></button>
            </div>
            <div class="modal-body">
              <AddDogForm
                :breeds="breeds"
                :colors="colors"
                :loading="loading"
                mode="edit"
                :initialDog="dog"
                :showHeader="false"
                @submit="$emit('submit', $event)"
                @close="$emit('close')"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="modal-backdrop fade show"></div>
    </div>
  </Transition>
</template>

<script>
import AddDogForm from "@/components/Dogs/AddDogForm.vue";

export default {
  name: "DogEditModal",
  components: { AddDogForm },
  props: {
    isOpen: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default: "Edit Dog",
    },
    dog: {
      type: Object,
      default: null,
    },
    breeds: {
      type: Array,
      required: true,
    },
    colors: {
      type: Array,
      required: true,
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["close", "submit"],
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

:deep(.add-dog.card-like) {
  border: 0;
  box-shadow: none;
  margin-bottom: 0 !important;
  padding: 0;
}
</style>
