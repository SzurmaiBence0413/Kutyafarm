<template>
  <section class="adoptions-view">
    <div class="container py-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title m-0">Adoptions</h1>
        <button class="btn btn-outline-secondary" type="button" @click="fetchAdoptions" :disabled="loading">
          {{ loading ? "Loading..." : "Refresh" }}
        </button>
      </div>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-warning" role="status"></div>
      </div>

      <div v-else-if="error" class="alert alert-danger" role="alert">
        Could not load adoption requests. Please try again.
      </div>

      <div v-else class="card-like">
        <p class="mb-3 text-muted">
          Showing {{ items.length }} request{{ items.length === 1 ? "" : "s" }}.
        </p>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width: 90px">ID</th>
                <th style="width: 240px">Dog</th>
                <th>Requester</th>
                <th style="width: 160px">Phone</th>
                <th style="width: 140px">City</th>
                <th>Status</th>
                <th v-if="isAdmin" style="width: 220px">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in items" :key="row.id">
                <td>#{{ row.id }}</td>
                <td>
                  <div class="fw-semibold">{{ row.dog?.dogName || "-" }}</div>
                  <div class="text-muted small">Chip: {{ row.dog?.chipNumber || "-" }}</div>
                </td>
                <td>
                  <div class="fw-semibold">{{ row.fullName }}</div>
                  <div class="text-muted small">{{ row.email }}</div>
                  <div v-if="row.message" class="small mt-1 message">
                    {{ row.message }}
                  </div>
                </td>
                <td>{{ row.phone }}</td>
                <td>{{ row.city }}</td>
                <td>
                  <span class="badge" :class="statusBadgeClass(row.status)">
                    {{ row.status }}
                  </span>
                </td>
                <td v-if="isAdmin">
                  <div class="d-flex gap-2">
                    <button
                      class="btn btn-sm btn-success"
                      type="button"
                      :disabled="actionLoadingId === row.id || row.status === 'approved'"
                      @click="updateStatus(row.id, 'approved')"
                    >
                      Approve
                    </button>
                    <button
                      class="btn btn-sm btn-danger"
                      type="button"
                      :disabled="actionLoadingId === row.id || row.status === 'rejected'"
                      @click="updateStatus(row.id, 'rejected')"
                    >
                      Reject
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="items.length === 0">
                <td :colspan="isAdmin ? 7 : 6" class="text-center text-muted py-4">
                  No adoption requests yet.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapState } from "pinia";
import { useUserLoginLogoutStore } from "@/stores/userLoginLogoutStore";
import adoptionService from "@/api/adoptionService";
import { useToastStore } from "@/stores/toastStore";

export default {
  name: "AdoptionsView",
  data() {
    return {
      items: [],
      loading: false,
      error: null,
      actionLoadingId: null,
    };
  },
  computed: {
    ...mapState(useUserLoginLogoutStore, ["role"]),
    isAdmin() {
      return this.role === 1;
    },
  },
  methods: {
    statusBadgeClass(status) {
      if (status === "approved") return "text-bg-success";
      if (status === "rejected") return "text-bg-danger";
      return "text-bg-secondary";
    },
    async fetchAdoptions() {
      this.loading = true;
      this.error = null;
      try {
        const response = await adoptionService.getAdoptions();
        this.items = response?.data ?? response ?? [];
      } catch (err) {
        this.error = err;
      } finally {
        this.loading = false;
      }
    },
    async updateStatus(id, status) {
      if (!this.isAdmin) return;
      this.actionLoadingId = id;
      try {
        await adoptionService.updateAdoptionStatus(id, status);
        const toast = useToastStore();
        toast.messages.push(`Request #${id} set to "${status}".`);
        toast.show("Success");
        await this.fetchAdoptions();
      } catch (err) {
      } finally {
        this.actionLoadingId = null;
      }
    },
  },
  async mounted() {
    await this.fetchAdoptions();
  },
};
</script>

<style scoped>
.adoptions-view {
  background: #f5f6f8;
  min-height: 100%;
}

.page-title {
  font-size: 2.3rem;
  font-weight: 700;
  letter-spacing: 0.2px;
}

.card-like {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid #e9eaed;
  padding: 18px;
}

.message {
  white-space: pre-wrap;
}
</style>
