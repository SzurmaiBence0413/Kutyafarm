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
          })
          .slice(0, 6);
      } catch (error) {
        this.error = error;
      } finally {
        this.loading = false;
      }
    },
  },
});
