import { defineStore } from "pinia";
import service from "@/api/userLoginLogoutService";
import { useToastStore } from "./toastStore";
import { useFavoritesStore } from "./favoritesStore";

export const useUserLoginLogoutStore = defineStore("userLoginLogout", {
  state: () => ({
    item: JSON.parse(localStorage.getItem("user_data")) || null,
    loading: false,
    error: null,
    rolNames: ["Admin", "Orokbefogado"],
  }),

  getters: {
    token() {
      return this.item ? this.item.token : null;
    },
    role() {
      return this.item ? this.item.role : null;
    },
    userName() {
      return this.item ? this.item.name : null;
    },
    userNameWithRole() {
      if (!this.item) return null;
      return `${this.item.name}: ${this.rolNames[this.item.role - 1]}`;
    },
    isLoggedIn() {
      return this.item !== null;
    },
  },

  actions: {
    canAccess(requiredRoles) {
      if (!requiredRoles || requiredRoles.length === 0) return true;
      if (!this.isLoggedIn) return false;
      return requiredRoles.includes(this.role);
    },

    async login(data) {
      try {
        this.loading = true;
        this.error = null;
        const response = await service.login(data);
        this.item = response.data;
        localStorage.setItem("user_data", JSON.stringify(response.data));
        useFavoritesStore().resetFavorites();
        return true;
      } catch (err) {
        this.error = err;
        throw err;
      } finally {
        this.loading = false;
      }
    },

    async register(data) {
      try {
        this.loading = true;
        this.error = null;
        await service.register(data);
        return true;
      } catch (err) {
        this.error = err;
        throw err;
      } finally {
        this.loading = false;
      }
    },

    async logout() {
      try {
        this.error = null;
        this.loading = true;
        await service.logout();
        this.item = null;
        localStorage.removeItem("user_data");
        useFavoritesStore().resetFavorites();

        const toastStore = useToastStore();
        toastStore.messages.push("Sikeres kijelentkezes");
        toastStore.show("Success");
        return true;
      } catch (err) {
        this.error = err;
        this.item = null;
        useFavoritesStore().resetFavorites();
        throw err;
      } finally {
        this.loading = false;
      }
    },

    async getMeRefresh() {
      try {
        this.error = null;
        this.loading = true;
        const response = await service.getMeRefresh();
        this.item.name = response.data.name;
        this.item.email = response.data.email;
        return true;
      } catch (err) {
        this.error = err;
        throw err;
      } finally {
        this.loading = false;
      }
    },
  },
});
