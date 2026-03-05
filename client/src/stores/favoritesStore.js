import { defineStore } from "pinia";
import service from "@/api/favoritesService";

export const useFavoritesStore = defineStore("favorites", {
  state: () => ({
    favoriteIds: [],
    initialized: false,
  }),

  getters: {
    favoritesCount(state) {
      return state.favoriteIds.length;
    },
  },

  actions: {
    initFavorites() {
      if (this.initialized) return;
      this.favoriteIds = service.loadFavoriteIds();
      this.initialized = true;
    },

    isFavorite(dogId) {
      return this.favoriteIds.includes(Number(dogId));
    },

    toggleFavorite(dogId) {
      const id = Number(dogId);
      if (this.isFavorite(id)) {
        this.favoriteIds = this.favoriteIds.filter((item) => item !== id);
      } else {
        this.favoriteIds = [...this.favoriteIds, id];
      }
      service.saveFavoriteIds(this.favoriteIds);
    },

    removeFavorite(dogId) {
      const id = Number(dogId);
      this.favoriteIds = this.favoriteIds.filter((item) => item !== id);
      service.saveFavoriteIds(this.favoriteIds);
    },
  },
});

