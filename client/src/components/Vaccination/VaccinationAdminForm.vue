<template>
  <div v-if="isAdmin" class="container mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
          <div>
            <h2 class="h5 mb-1">Add new guide item</h2>
            <p class="text-muted mb-0">
              This will create a new medicine in the vaccination guide.
            </p>
          </div>
          <button
            class="btn btn-outline-secondary btn-sm"
            type="button"
            @click="collapsed = !collapsed"
          >
            {{ collapsed ? "Show form" : "Hide form" }}
          </button>
        </div>

        <form v-if="!collapsed" class="row g-3" @submit.prevent="onSubmit">
          <div class="col-12 col-md-6">
            <label class="form-label">Medicine name *</label>
            <input
              v-model.trim="form.medicineName"
              type="text"
              class="form-control"
              :class="{ 'is-invalid': fieldErrors.medicineName }"
              placeholder="e.g. DHPP"
              maxlength="100"
              required
            />
            <div v-if="fieldErrors.medicineName" class="invalid-feedback">
              {{ fieldErrors.medicineName }}
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label">Short name</label>
            <input
              v-model.trim="form.shortName"
              type="text"
              class="form-control"
              :class="{ 'is-invalid': fieldErrors.shortName }"
              placeholder="Optional"
              maxlength="120"
            />
            <div v-if="fieldErrors.shortName" class="invalid-feedback">
              {{ fieldErrors.shortName }}
            </div>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label">Badge</label>
            <input
              v-model.trim="form.badge"
              type="text"
              class="form-control"
              :class="{ 'is-invalid': fieldErrors.badge }"
              placeholder="Core / Required / Risk-based"
              maxlength="50"
            />
            <div v-if="fieldErrors.badge" class="invalid-feedback">
              {{ fieldErrors.badge }}
            </div>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label">Display order</label>
            <input
              v-model="form.displayOrder"
              type="number"
              class="form-control"
              :class="{ 'is-invalid': fieldErrors.displayOrder }"
              min="1"
              max="9999"
              placeholder="1"
            />
            <div v-if="fieldErrors.displayOrder" class="invalid-feedback">
              {{ fieldErrors.displayOrder }}
            </div>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label">Recommended age</label>
            <input
              v-model.trim="form.recommendedAge"
              type="text"
              class="form-control"
              :class="{ 'is-invalid': fieldErrors.recommendedAge }"
              placeholder="e.g. 6–8 weeks"
              maxlength="120"
            />
            <div v-if="fieldErrors.recommendedAge" class="invalid-feedback">
              {{ fieldErrors.recommendedAge }}
            </div>
          </div>

          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea
              v-model.trim="form.description"
              class="form-control"
              :class="{ 'is-invalid': fieldErrors.description }"
              rows="3"
              placeholder="Short explanation..."
              maxlength="1000"
            />
            <div v-if="fieldErrors.description" class="invalid-feedback">
              {{ fieldErrors.description }}
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label">Frequency</label>
            <input
              v-model.trim="form.frequency"
              type="text"
              class="form-control"
              :class="{ 'is-invalid': fieldErrors.frequency }"
              placeholder="e.g. Booster every 1–3 years"
              maxlength="180"
            />
            <div v-if="fieldErrors.frequency" class="invalid-feedback">
              {{ fieldErrors.frequency }}
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label">Common side effects</label>
            <input
              v-model.trim="form.sideEffects"
              type="text"
              class="form-control"
              :class="{ 'is-invalid': fieldErrors.sideEffects }"
              placeholder="e.g. Mild soreness, sleepiness"
              maxlength="180"
            />
            <div v-if="fieldErrors.sideEffects" class="invalid-feedback">
              {{ fieldErrors.sideEffects }}
            </div>
          </div>

          <div class="col-12 d-flex align-items-center justify-content-between">
            <div v-if="genericError" class="text-danger small">
              {{ genericError }}
            </div>

            <div class="ms-auto d-flex gap-2">
              <button class="btn btn-outline-secondary" type="button" @click="onReset">
                Reset
              </button>
              <button class="btn btn-warning" type="submit" :disabled="saving">
                <span
                  v-if="saving"
                  class="spinner-border spinner-border-sm me-2"
                  role="status"
                  aria-hidden="true"
                ></span>
                Create
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { useUserLoginLogoutStore } from "@/stores/userLoginLogoutStore";
import { useVaccinationGuideStore } from "@/stores/vaccinationGuideStore";
import { useToastStore } from "@/stores/toastStore";

function firstError(errors, key) {
  const value = errors?.[key];
  if (!value) return null;
  return Array.isArray(value) ? value[0] : String(value);
}

export default {
  name: "VaccinationAdminForm",
  data() {
    return {
      collapsed: true,
      genericError: null,
      fieldErrors: {},
      form: {
        medicineName: "",
        shortName: "",
        badge: "",
        description: "",
        recommendedAge: "",
        frequency: "",
        sideEffects: "",
        displayOrder: "",
      },
    };
  },
  computed: {
    ...mapState(useUserLoginLogoutStore, ["isLoggedIn"]),
    ...mapState(useUserLoginLogoutStore, { role: "role" }),
    ...mapState(useVaccinationGuideStore, ["saving", "savingErrors"]),
    isAdmin() {
      return this.isLoggedIn && this.role === 1;
    },
  },
  watch: {
    savingErrors: {
      handler(value) {
        if (!value) return;
        this.fieldErrors = {
          medicineName: firstError(value, "medicineName"),
          shortName: firstError(value, "shortName"),
          badge: firstError(value, "badge"),
          description: firstError(value, "description"),
          recommendedAge: firstError(value, "recommendedAge"),
          frequency: firstError(value, "frequency"),
          sideEffects: firstError(value, "sideEffects"),
          displayOrder: firstError(value, "displayOrder"),
        };
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions(useVaccinationGuideStore, ["createMedicine"]),
    onReset() {
      this.genericError = null;
      this.fieldErrors = {};
      this.form = {
        medicineName: "",
        shortName: "",
        badge: "",
        description: "",
        recommendedAge: "",
        frequency: "",
        sideEffects: "",
        displayOrder: "",
      };
    },
    async onSubmit() {
      this.genericError = null;
      this.fieldErrors = {};

      if (!this.form.medicineName) {
        this.fieldErrors = { medicineName: "Medicine name is required." };
        return;
      }

      const payload = {
        medicineName: this.form.medicineName,
        shortName: this.form.shortName || null,
        badge: this.form.badge || null,
        description: this.form.description || null,
        recommendedAge: this.form.recommendedAge || null,
        frequency: this.form.frequency || null,
        sideEffects: this.form.sideEffects || null,
        displayOrder:
          this.form.displayOrder === "" || this.form.displayOrder === null
            ? null
            : Number(this.form.displayOrder),
      };

      try {
        await this.createMedicine(payload);
        useToastStore().messages.push("Medicine created.");
        useToastStore().show("Success");
        this.onReset();
        this.collapsed = true;
      } catch (error) {
        if (error?.response?.status === 422) return;
        this.genericError = "Could not create medicine. Please try again.";
      }
    },
  },
};
</script>

<style scoped>
.card {
  border-radius: 14px;
}
</style>

