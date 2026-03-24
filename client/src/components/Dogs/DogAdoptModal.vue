<template>
  <Transition name="modal-fade">
    <div v-if="isOpen && dog" class="modal-layer" @click.self="$emit('close')">
      <div class="modal fade show" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content bg-light shadow-lg">
            <div class="modal-header bg-warning-subtle">
              <h5 class="modal-title">{{ title || "Adopt Dog" }}</h5>
              <button
                type="button"
                class="btn-close"
                aria-label="Close"
                @click="$emit('close')"
              ></button>
            </div>

            <form novalidate @submit.prevent="submitHandler">
              <div class="modal-body">
                <div class="alert alert-secondary py-2 mb-3">
                  <strong>Dog:</strong> {{ dog.name }} (ID: {{ dog.id }})
                </div>

                <div class="row g-3">
                  <div class="col-12 col-md-6">
                    <label class="form-label">Full name</label>
                    <input v-model.trim="form.fullName" class="form-control" type="text" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label">Email</label>
                    <input v-model.trim="form.email" class="form-control" type="email" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label">Phone</label>
                    <input
                      v-model.trim="form.phone"
                      class="form-control"
                      type="tel"
                      inputmode="tel"
                      autocomplete="tel"
                    />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label">City</label>
                    <input
                      v-model.trim="form.city"
                      class="form-control"
                      type="text"
                      autocomplete="address-level2"
                    />
                  </div>

                  <div class="col-12">
                    <label class="form-label">Message (optional)</label>
                    <textarea
                      v-model.trim="form.message"
                      class="form-control"
                      rows="4"
                      maxlength="500"
                      placeholder="Tell us why you’d be a great match..."
                    ></textarea>
                    <div class="form-text">Max 500 characters.</div>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="$emit('close')">
                  Cancel
                </button>
                <button type="submit" class="btn btn-warning text-white" :disabled="loading">
                  {{ loading ? "Sending..." : "Send request" }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-backdrop fade show"></div>
    </div>
  </Transition>
</template>

<script>
export default {
  name: "DogAdoptModal",
  props: {
    isOpen: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default: "",
    },
    dog: {
      type: Object,
      default: null,
    },
    loading: {
      type: Boolean,
      default: false,
    },
    initialUser: {
      type: Object,
      default: null,
    },
  },
  emits: ["close", "submit"],
  data() {
    return {
      form: this.buildEmptyForm(),
    };
  },
  watch: {
    isOpen: {
      immediate: true,
      handler(value) {
        if (!value) return;
        this.form = this.buildPrefilledForm();
      },
    },
    dog: {
      handler() {
        if (!this.isOpen) return;
        this.form = this.buildPrefilledForm();
      },
    },
    initialUser: {
      handler() {
        if (!this.isOpen) return;
        this.form = this.buildPrefilledForm();
      },
    },
  },
  methods: {
    buildEmptyForm() {
      return {
        fullName: "",
        email: "",
        phone: "",
        city: "",
        message: "",
      };
    },
    buildPrefilledForm() {
      const base = this.buildEmptyForm();
      const user = this.initialUser || {};
      return {
        ...base,
        fullName: user.name || "",
        email: user.email || "",
      };
    },
    submitHandler() {
      if (!this.dog?.id) return;
      this.$emit("submit", {
        dogId: this.dog.id,
        dogName: this.dog.name,
        ...this.form,
      });
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

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.2s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}
</style>
