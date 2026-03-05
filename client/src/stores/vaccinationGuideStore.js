import { defineStore } from "pinia";
import service from "@/api/vaccinationGuideService";

const GUIDE_DETAILS = {
  dhpp: {
    badge: "Core",
    shortName: "DHPP",
    description:
      "Combination vaccine that protects against distemper, hepatitis, parainfluenza, and parvovirus.",
    recommendedAge: "6-8 weeks old",
    frequency: "Every 3-4 weeks until 16 weeks",
    sideEffects: "Mild fever, tiredness, soreness at injection site",
  },
  rabies: {
    badge: "Legal",
    shortName: "Rabies Vaccine",
    description:
      "Legally required vaccine that protects against fatal rabies infection.",
    recommendedAge: "12-16 weeks old",
    frequency: "First dose at 12-16 weeks, then annual/3-year booster",
    sideEffects: "Low energy, slight swelling, temporary discomfort",
  },
  bordetella: {
    badge: "Lifestyle",
    shortName: "Bordetella (Kennel Cough)",
    description:
      "Recommended for dogs that attend daycare, grooming, boarding, or social training classes.",
    recommendedAge: "8 weeks and older",
    frequency: "Every 6-12 months based on exposure risk",
    sideEffects: "Sneezing, mild cough, short-term lethargy",
  },
  leptospirosis: {
    badge: "Risk-Based",
    shortName: "Leptospirosis",
    description:
      "Protects against bacterial infection that can affect dogs and humans in wet environments.",
    recommendedAge: "12 weeks and older",
    frequency: "Two initial doses, then yearly booster",
    sideEffects: "Mild fever, reduced appetite, temporary soreness",
  },
  "canine influenza": {
    badge: "Lifestyle",
    shortName: "Canine Influenza (Dog Flu)",
    description:
      "Protects against canine flu strains for dogs in social environments.",
    recommendedAge: "8 weeks and older",
    frequency: "Two-dose series, then annual booster",
    sideEffects: "Sleepiness, injection site swelling, mild fever",
  },
  "lyme disease": {
    badge: "Risk-Based",
    shortName: "Lyme Disease Vaccine",
    description:
      "Recommended in tick-prone areas to reduce the risk of Lyme disease.",
    recommendedAge: "9 weeks and older",
    frequency: "Two-dose series, then annual booster",
    sideEffects: "Fatigue, tenderness, short-lived fever",
  },
};

const PRIORITY_ORDER = [
  "DHPP",
  "Rabies",
  "Bordetella",
  "Leptospirosis",
  "Canine Influenza",
  "Lyme disease",
];

function normalizeName(value) {
  return (value || "").trim().toLowerCase();
}

function getGuideDetail(name) {
  return GUIDE_DETAILS[normalizeName(name)] || null;
}

function mapCard(name) {
  const details = getGuideDetail(name);
  return {
    id: normalizeName(name),
    name: details?.shortName || name,
    badge: details?.badge || "General",
    description:
      details?.description ||
      "Consult your veterinarian for schedule and suitability.",
    recommendedAge: details?.recommendedAge || "Ask your veterinarian",
    frequency: details?.frequency || "Based on your veterinarian's guidance",
    sideEffects: details?.sideEffects || "Usually mild and temporary",
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

        const availableNames = medicines.map((item) => item.medicineName);
        const availableSet = new Set(availableNames.map(normalizeName));

        const selected = PRIORITY_ORDER.filter((name) =>
          availableSet.has(normalizeName(name))
        );

        if (selected.length < 6) {
          for (const name of availableNames) {
            if (!selected.includes(name)) {
              selected.push(name);
            }
            if (selected.length >= 6) break;
          }
        }

        this.cards = selected.slice(0, 6).map(mapCard);
      } catch (error) {
        this.error = error;
      } finally {
        this.loading = false;
      }
    },
  },
});
