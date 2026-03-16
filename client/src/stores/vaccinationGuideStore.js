import { defineStore } from "pinia";
import service from "@/api/vaccinationGuideService";

function normalizeCard(item) {
  return {
    id: item.id || item.medicineName,
    name: item.shortName || item.medicineName,
    badge: item.badge || "General",
    description:
      item.description ||
      "Consult your veterinarian for schedule and suitability.",
    recommendedAge: item.recommendedAge || "Ask your veterinarian",
    frequency: item.frequency || "Based on your veterinarian's guidance",
    sideEffects: item.sideEffects || "Usually mild and temporary",
    displayOrder: Number(item.displayOrder) || 9999,
  };
}

export const useVaccinationGuideStore = defineStore("vaccinationGuide", {
  state: () => ({
    cards: [],
    loading: false,
    error: null,
    saving: false,
    savingErrors: null,
  }),
  actions: {
    async fetchGuideCards() {
      this.loading = true;
      this.error = null;

      try {
        const response = await service.getMedicines();
        const medicines = response?.data ?? [];

        this.cards = medicines
          .map(normalizeCard)
          .sort((a, b) => {
            if (a.displayOrder !== b.displayOrder) {
              return a.displayOrder - b.displayOrder;
            }
            return a.name.localeCompare(b.name);
          });
      } catch (error) {
        this.error = error;
      } finally {
        this.loading = false;
      }
    },

    async createMedicine(payload) {
      this.saving = true;
      this.savingErrors = null;

      try {
        const response = await service.createMedicine(payload);
        await this.fetchGuideCards();
        return response?.data ?? null;
      } catch (error) {
        this.savingErrors = error?.response?.data?.errors ?? null;
        throw error;
      } finally {
        this.saving = false;
      }
    },

    async deleteMedicine(id) {
      this.saving = true;
      this.savingErrors = null;

      try {
        const response = await service.deleteMedicine(id);
        await this.fetchGuideCards();
        return response?.data ?? null;
      } catch (error) {
        throw error;
      } finally {
        this.saving = false;
      }
    },
  },
});
