<template>
  <Transition name="modal-fade">
    <div v-if="isOpen && dog" class="modal-layer" @click.self="$emit('close')">
      <div class="modal fade show" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content bg-light shadow-lg">
            <div class="modal-header bg-warning-subtle">
              <h5 class="modal-title">{{ dog.name }} - Details</h5>
              <button type="button" class="btn-close" aria-label="Close" @click="$emit('close')"></button>
            </div>

            <div class="modal-body">
              <div class="row g-4 align-items-start">
                <div class="col-12 col-lg-5">
                  <img :src="dog.image" :alt="dog.name" class="detail-image" />
                </div>

                <div class="col-12 col-lg-7">
                  <p class="lead mb-2">{{ dog.description }}</p>
                  <div class="row g-3">
                    <div class="col-12 col-md-6"><strong>Name:</strong> {{ dog.name }}</div>
                    <div class="col-12 col-md-6"><strong>Breed:</strong> {{ dog.breed }}</div>
                    <div class="col-12 col-md-6"><strong>Owner:</strong> {{ ownerLabel }}</div>
                    <div class="col-12 col-md-6"><strong>Gender:</strong> {{ genderLabel }}</div>
                    <div class="col-12 col-md-6"><strong>Date of birth:</strong> {{ formatDate(dog.dateOfBirth) }}</div>
                    <div class="col-12 col-md-6"><strong>Age:</strong> {{ ageLabel }}</div>
                    <div class="col-12 col-md-6"><strong>Color:</strong> {{ dog.color || "Unknown" }}</div>
                    <div class="col-12 col-md-6"><strong>Weight:</strong> {{ weightLabel }}</div>
                    <div class="col-12 col-md-6"><strong>Teeth:</strong> {{ dog.teeth ?? "-" }}</div>
                    <div class="col-12 col-md-6"><strong>Chip number:</strong> {{ dog.chipNumber || "-" }}</div>
                    <div class="col-12"><strong>Location:</strong> {{ dog.location || "-" }}</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button
                v-if="canAdopt"
                type="button"
                class="btn btn-warning text-white me-auto"
                @click="$emit('adopt', dog)"
              >
                Adopt
              </button>
              <button type="button" class="btn btn-secondary" @click="$emit('close')">Close</button>
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
  name: "DogDetailsModal",
  props: {
    isOpen: {
      type: Boolean,
      default: false,
    },
    dog: {
      type: Object,
      default: null,
    },
    canAdopt: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["close", "adopt"],
  computed: {
    genderLabel() {
      if (!this.dog) return "Unknown";
      return Number(this.dog.gender) === 1 ? "Male" : "Female";
    },
    ageLabel() {
      if (!this.dog) return "Unknown";
      if (this.dog.age === null || this.dog.age === undefined) return "Unknown";
      return `${this.dog.age} years`;
    },
    weightLabel() {
      if (!this.dog) return "-";
      if (this.dog.weight === null || this.dog.weight === undefined || this.dog.weight === "") {
        return "-";
      }
      return `${this.dog.weight} kg`;
    },
    ownerLabel() {
      if (!this.dog) return "-";
      if (this.dog.ownerName) return `${this.dog.ownerName} (ID: ${this.dog.userId})`;
      return this.dog.userId ? `User #${this.dog.userId}` : "-";
    },
  },
  methods: {
    formatDate(value) {
      if (!value) return "-";
      const date = new Date(value);
      if (Number.isNaN(date.getTime())) return value;
      return date.toLocaleDateString();
    },
  },
};
</script>

<style scoped>
.modal-layer {
  position: fixed;
  inset: 0;
  z-index: 1060;
}

.detail-image {
  width: 100%;
  border-radius: 12px;
  max-height: 420px;
  object-fit: cover;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.2s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}
</style>
