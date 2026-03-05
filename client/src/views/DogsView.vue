<template>
  <section class="browse-dogs-view">
    <div class="container py-5">
      <h1 class="page-title mb-4">Browse Dogs</h1>

      <DogBrowseFilters
        :searchText="searchText"
        :selectedBreed="selectedBreed"
        :breedOptions="breedOptions"
        @update:searchText="setSearchText"
        @update:selectedBreed="setSelectedBreed"
      />

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-warning" role="status"></div>
      </div>

      <div v-else-if="error" class="alert alert-danger" role="alert">
        Could not load dogs. Please try again.
      </div>

      <template v-else>
        <p class="results mb-4">Showing {{ filteredDogs.length }} dogs</p>

        <div class="row g-4">
          <div
            class="col-12 col-sm-6 col-lg-4 col-xl-3"
            v-for="dog in filteredDogs"
            :key="dog.id"
          >
            <DogCard
              :dog="dog"
              :isFavorite="isFavorite(dog.id)"
              @toggle-favorite="toggleFavorite"
            />
          </div>
        </div>
      </template>
    </div>
  </section>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { useDogBrowseStore } from "@/stores/dogBrowseStore";
import DogBrowseFilters from "@/components/Dogs/DogBrowseFilters.vue";
import DogCard from "@/components/Dogs/DogCard.vue";

export default {
  name: "DogsView",
  components: {
    DogBrowseFilters,
    DogCard,
  },

  computed: {
    ...mapState(useDogBrowseStore, [
      "loading",
      "error",
      "searchText",
      "selectedBreed",
      "breedOptions",
      "filteredDogs",
    ]),
  },

  methods: {
    ...mapActions(useDogBrowseStore, [
      "fetchDogs",
      "setSearchText",
      "setSelectedBreed",
      "toggleFavorite",
      "isFavorite",
    ]),
  },

  async mounted() {
    await this.fetchDogs();
  },
};
</script>

<style scoped>
.browse-dogs-view {
  background: #f5f6f8;
  min-height: 100%;
}

.page-title {
  font-size: 2.6rem;
  font-weight: 700;
  letter-spacing: 0.2px;
}

.results {
  color: #4c5568;
  font-size: 1.06rem;
}

@media (max-width: 768px) {
  .page-title {
    font-size: 2rem;
  }
}
</style>
