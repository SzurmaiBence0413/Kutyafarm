<template>
  <div class="add-dog card-like mb-4">
    <div v-if="showHeader" class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="m-0">{{ mode === "edit" ? "Edit Dog" : "Add New Dog" }}</h2>
      <button class="btn btn-outline-secondary btn-sm" @click="$emit('close')">
        Close
      </button>
    </div>

    <form novalidate @submit.prevent="submitHandler">
      <div class="row g-3">
        <div class="col-12 col-md-6">
          <label class="form-label">Dog Name</label>
          <input v-model.trim="form.dogName" type="text" class="form-control" />
        </div>

        <div v-if="mode === 'create'" class="col-12 col-md-6">
          <label class="form-label">Image URL (optional)</label>
          <input
            v-model.trim="form.imageUrl"
            type="url"
            maxlength="2048"
            class="form-control"
            placeholder="https://example.com/dog.jpg"
          />
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Chip Number</label>
          <input
            v-model.trim="form.chipNumber"
            type="text"
            maxlength="15"
            class="form-control"
          />
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Breed</label>
          <select v-model="form.breedId" class="form-select">
            <option value="" disabled>Select breed</option>
            <option v-for="breed in breeds" :key="breed.id" :value="breed.id">
              {{ breed.breed }}
            </option>
          </select>
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Color</label>
          <select v-model="form.colorId" class="form-select">
            <option value="" disabled>Select color</option>
            <option v-for="color in colors" :key="color.id" :value="color.id">
              {{ color.colorName }}
            </option>
          </select>
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Date of Birth</label>
          <input v-model="form.dateOfBirth" type="date" class="form-control" />
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Weight (kg)</label>
          <input v-model="form.weight" type="number" min="0" step="0.1" class="form-control" />
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Gender</label>
          <select v-model="form.gender" class="form-select">
            <option value="1">Male</option>
            <option value="0">Female</option>
          </select>
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Teeth</label>
          <select v-model="form.teeth" class="form-select">
            <option value="1">Healthy</option>
            <option value="0">Needs care</option>
          </select>
        </div>
      </div>

      <div class="mt-3 d-flex gap-2">
        <button class="btn btn-warning text-white" type="submit" :disabled="loading">
          {{ loading ? "Saving..." : mode === "edit" ? "Update Dog" : "Save Dog" }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "AddDogForm",
  props: {
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
    mode: {
      type: String,
      default: "create",
    },
    initialDog: {
      type: Object,
      default: null,
    },
    showHeader: {
      type: Boolean,
      default: true,
    },
  },
  emits: ["submit", "close"],
  data() {
    return {
        form: {
          dogName: "",
          imageUrl: "",
          chipNumber: "",
          breedId: "",
          colorId: "",
          dateOfBirth: "",
          weight: "",
          gender: "1",
          teeth: "1",
          userId: "",
        },
      };
    },
  watch: {
    initialDog: {
      immediate: true,
        handler(value) {
          if (!value) return;
          this.form = {
            dogName: value.dogName ?? value.name ?? "",
            imageUrl: "",
            chipNumber: value.chipNumber ?? "",
            breedId: String(value.breedId ?? ""),
            colorId: String(value.colorId ?? ""),
            dateOfBirth: value.dateOfBirth ?? "",
          weight: value.weight ?? "",
          gender: String(value.gender ?? "1"),
          teeth: String(value.teeth ?? "1"),
          userId: String(value.userId ?? ""),
        };
      },
    },
  },
  methods: {
    submitHandler() {
      this.$emit("submit", { ...this.form });
    },
  },
};
</script>

<style scoped>
.card-like {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid #e9eaed;
  padding: 20px;
}

h2 {
  font-size: 1.2rem;
  font-weight: 700;
}
</style>
