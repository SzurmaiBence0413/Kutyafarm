import { defineStore } from "pinia";
import service from "@/api/favoritesService";
import { useUserLoginLogoutStore } from "@/stores/userLoginLogoutStore";

export const useFavoritesStore = defineStore("favorites", {
  state: () => ({
    favoriteIds: [],
    initialized: false,
    loadedUserId: null,
    loading: false,
  }),

  getters: {
    favoritesCount(state) {
      return state.favoriteIds.length;
    },
  },

  actions: {
    async initFavorites(force = false) {
      const userStore = useUserLoginLogoutStore();

      if (!userStore.isLoggedIn) {
        this.resetFavorites();
        return;
      }

      const userId = Number(userStore.item?.id);
      if (!force && this.initialized && this.loadedUserId === userId) return;

      this.loading = true;
      try {
        const response = await service.getFavorites();
        const favorites = response?.data ?? [];
        this.favoriteIds = favorites
          .map((favorite) => Number(favorite.dogId))
          .filter((dogId) => Number.isInteger(dogId));
        this.initialized = true;
        this.loadedUserId = userId;
      } finally {
        this.loading = false;
      }
    },

    isFavorite(dogId) {
      return this.favoriteIds.includes(Number(dogId));
    },

    async toggleFavorite(dogId) {
      const userStore = useUserLoginLogoutStore();
      if (!userStore.isLoggedIn) return false;

      const id = Number(dogId);
      if (this.isFavorite(id)) {
        await this.removeFavorite(id);
      } else {
        await service.addFavorite(id);
        this.favoriteIds = [...this.favoriteIds, id];
      }
      return true;
    },

    async removeFavorite(dogId) {
      const id = Number(dogId);
      await service.removeFavorite(id);
      this.favoriteIds = this.favoriteIds.filter((item) => item !== id);
    },

    resetFavorites() {
      this.favoriteIds = [];
      this.initialized = false;
      this.loadedUserId = null;
      this.loading = false;
    },
  },
});

