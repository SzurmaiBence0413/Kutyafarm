<template>
  <div class="controls card-like mb-4">
    <div class="row g-3 align-items-center">
      <div class="col-12 col-lg-8">
        <div class="search-box">
          <i class="bi bi-search"></i>
          <input
            type="text"
            class="form-control"
            placeholder="Search by name, breed, or location..."
            :value="searchText"
            @input="$emit('update:searchText', $event.target.value)"
          />
        </div>
      </div>

      <div class="col-12 col-lg-4">
        <select
          class="form-select breed-select"
          :value="selectedBreed"
          @change="$emit('update:selectedBreed', $event.target.value)"
        >
          <option v-for="breed in breedOptions" :key="breed" :value="breed">
            {{ breed === "all" ? "All Breeds" : breed }}
          </option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DogBrowseFilters",
  props: {
    searchText: {
      type: String,
      required: true,
    },
    selectedBreed: {
      type: String,
      required: true,
    },
    breedOptions: {
      type: Array,
      required: true,
    },
  },
  emits: ["update:searchText", "update:selectedBreed"],
};
</script>

<style scoped>
.card-like {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid #e9eaed;
  padding: 20px;
}

.search-box {
  position: relative;
}

.search-box i {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #8b93a5;
}

.search-box .form-control {
  height: 48px;
  border: 1px solid #e3e5ea;
  border-radius: 10px;
  padding-left: 42px;
}

.search-box .form-control:focus,
.breed-select:focus {
  border-color: #ff7a00;
  box-shadow: 0 0 0 0.2rem rgba(255, 122, 0, 0.15);
}

.breed-select {
  height: 48px;
  border: 1px solid #e3e5ea;
  border-radius: 10px;
}
</style>
