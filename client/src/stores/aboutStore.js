import { defineStore } from "pinia";
import service from "@/api/aboutService";

export const useAboutStore = defineStore("about", {
  state: () => ({
    page: null,
    loading: false,
    error: null,
  }),
  actions: {
    async fetchAboutPage() {
      this.loading = true;
      this.error = null;
      try {
        this.page = await service.getAboutPageData();
      } catch (error) {
        this.error = error;
      } finally {
        this.loading = false;
      }
    },
  },
});
