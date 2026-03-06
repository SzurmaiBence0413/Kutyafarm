<template>
  <section class="favorites-view">
    <div class="container py-5">
      <h1 class="page-title mb-3">Favorites</h1>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-warning" role="status"></div>
      </div>

      <div v-else-if="error" class="alert alert-danger" role="alert">
        Could not load dogs. Please try again.
      </div>

      <template v-else>
        <p class="results mb-4">Saved {{ favoriteDogs.length }} dogs</p>

        <div v-if="favoriteDogs.length === 0" class="empty card-like">
          No favorite dogs yet. Go to Browse Dogs and click the heart icon.
        </div>

        <FavoriteDogsGrid
          v-else
          :dogs="favoriteDogs"
          :isFavorite="isFavorite"
          @toggle-favorite="toggleFavorite"
          @open-details="openDetailsModal"
        />

        <DogDetailsModal
          :isOpen="isDetailsModalOpen"
          :dog="selectedDog"
          @close="closeDetailsModal"
        />
      </template>
    </div>
  </section>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { useDogBrowseStore } from "@/stores/dogBrowseStore";
import { useFavoritesStore } from "@/stores/favoritesStore";
import FavoriteDogsGrid from "@/components/Dogs/FavoriteDogsGrid.vue";
import DogDetailsModal from "@/components/Dogs/DogDetailsModal.vue";

export default {
  name: "FavoritesView",
  components: {
    FavoriteDogsGrid,
    DogDetailsModal,
  },
  data() {
    return {
      isDetailsModalOpen: false,
      selectedDog: null,
    };
  },
  computed: {
    ...mapState(useDogBrowseStore, ["dogs", "loading", "error"]),
    ...mapState(useFavoritesStore, ["favoriteIds"]),
    favoriteDogs() {
      const favorites = new Set(this.favoriteIds);
      return this.dogs.filter((dog) => favorites.has(dog.id));
    },
  },
  methods: {
    ...mapActions(useDogBrowseStore, ["fetchDogs"]),
    ...mapActions(useFavoritesStore, ["initFavorites", "toggleFavorite", "isFavorite"]),
    openDetailsModal(dog) {
      this.selectedDog = dog;
      this.isDetailsModalOpen = true;
    },
    closeDetailsModal() {
      this.isDetailsModalOpen = false;
      this.selectedDog = null;
    },
  },
  async mounted() {
    this.initFavorites();
    await this.fetchDogs();
  },
};
</script>

<style scoped>
.favorites-view {
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

.card-like {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid #e9eaed;
  padding: 20px;
}
</style>
