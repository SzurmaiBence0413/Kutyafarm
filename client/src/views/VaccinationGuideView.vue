<template>
  <section class="vaccination-guide-view">
    <VaccinationHero />
    <VaccinationNotice />
    <VaccinationAdminForm />

    <div class="container mb-4">
      <div class="tag-row">
        <span class="tag">Core vaccines</span>
        <span class="tag">Legally required</span>
        <span class="tag">Recommended by risk</span>
        <span class="tag">Based on lifestyle</span>
      </div>
    </div>

    <div class="container">
      <div v-if="loading" class="text-center py-4">
        <div class="spinner-border text-warning" role="status"></div>
      </div>

      <div v-else-if="error" class="alert alert-danger">
        Could not load vaccination guide data. Please try again.
      </div>

      <div v-else class="row g-3">
        <div class="col-12 col-md-6 col-lg-4" v-for="card in cards" :key="card.id">
          <VaccinationCard
            :card="card"
            :canDelete="isAdmin && Number.isFinite(Number(card.id))"
            @delete="onDeleteCard"
          />
        </div>
      </div>
    </div>

    <VaccinationTips />
    <VaccinationCTA />
  </section>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { useVaccinationGuideStore } from "@/stores/vaccinationGuideStore";
import { useUserLoginLogoutStore } from "@/stores/userLoginLogoutStore";
import { useToastStore } from "@/stores/toastStore";
import VaccinationHero from "@/components/Vaccination/VaccinationHero.vue";
import VaccinationNotice from "@/components/Vaccination/VaccinationNotice.vue";
import VaccinationAdminForm from "@/components/Vaccination/VaccinationAdminForm.vue";
import VaccinationCard from "@/components/Vaccination/VaccinationCard.vue";
import VaccinationTips from "@/components/Vaccination/VaccinationTips.vue";
import VaccinationCTA from "@/components/Vaccination/VaccinationCTA.vue";

export default {
  name: "VaccinationGuideView",
  components: {
    VaccinationHero,
    VaccinationNotice,
    VaccinationAdminForm,
    VaccinationCard,
    VaccinationTips,
    VaccinationCTA,
  },
  computed: {
    ...mapState(useVaccinationGuideStore, ["cards", "loading", "error"]),
    ...mapState(useUserLoginLogoutStore, ["isLoggedIn"]),
    ...mapState(useUserLoginLogoutStore, { role: "role" }),
    isAdmin() {
      return this.isLoggedIn && this.role === 1;
    },
  },
  methods: {
    ...mapActions(useVaccinationGuideStore, ["fetchGuideCards", "deleteMedicine"]),
    async onDeleteCard(card) {
      const id = Number(card?.id);
      if (!Number.isFinite(id)) {
        useToastStore().messages.push("Cannot delete: missing ID.");
        useToastStore().show("Error");
        return;
      }
      try {
        await this.deleteMedicine(id);
        useToastStore().messages.push("Medicine deleted.");
        useToastStore().show("Success");
      } catch (error) {
        // Axios interceptor shows the toast; keep a generic fallback.
        if (!error?.response) {
          useToastStore().messages.push("Could not delete medicine.");
          useToastStore().show("Error");
        }
      }
    },
  },
  async mounted() {
    await this.fetchGuideCards();
  },
};
</script>

<style scoped>
.vaccination-guide-view {
  background: #f3f5f8;
  min-height: 100%;
}

.tag-row {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.tag {
  background: #fff;
  border: 1px solid #e6e8ed;
  border-radius: 999px;
  color: #b15000;
  font-size: 0.8rem;
  font-weight: 700;
  padding: 5px 10px;
}
</style>
