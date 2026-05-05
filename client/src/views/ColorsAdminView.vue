<template>
  <div class="container py-3">
    <div class="d-flex align-items-center mb-3 position-relative flex-wrap">
      <h1 class="m-0">Colors</h1>
      <i
        v-if="loading"
        class="bi bi-hourglass-split fs-3 col-auto p-0 ps-2"
      ></i>
      <p class="m-0 ms-2 text-muted">({{ totalCount }})</p>

      <div class="color-per-page">
        <SetSelectedPerPage :useCollectionStore="useCollectionStore" />
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-body">
        <form class="row g-2 align-items-end" @submit.prevent="createColor">
          <div class="col-12 col-md-6">
            <label for="colorName" class="form-label">Color name</label>
            <input
              id="colorName"
              v-model.trim="colorInput"
              class="form-control"
              type="text"
              maxlength="50"
              :disabled="creating"
              required
            />
            <div v-if="serverErrors.colorName" class="text-danger small mt-1">
              {{ serverErrors.colorName[0] }}
            </div>
          </div>
          <div class="col-12 col-md-auto">
            <button
              class="btn btn-primary"
              type="submit"
              :disabled="creating || !colorInput"
            >
              Add
            </button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="localError" class="alert alert-danger" role="alert">
      {{ localError }}
    </div>
    <div v-else-if="error" class="alert alert-danger" role="alert">
      An error occurred while processing the request.
    </div>

    <div v-if="!loading && items.length === 0" class="text-center text-muted">
      No colors have been added yet.
    </div>

    <template v-else>
      <div class="d-flex justify-content-end mt-2 mb-2">
        <Pagination :useCollectionStore="useCollectionStore" />
      </div>

      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th style="width: 90px">ID</th>
              <th>Color</th>
              <th class="text-end" style="width: 140px">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="color in items" :key="color.id">
              <td>{{ color.id }}</td>
              <td>{{ color.colorName ?? color.color }}</td>
              <td class="text-end">
                <button
                  class="btn btn-sm btn-outline-danger"
                  type="button"
                  :disabled="deletingId === color.id"
                  @click="deleteColor(color.id)"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
  </div>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { useColorStore } from "@/stores/colorStore";
import { useToastStore } from "@/stores/toastStore";
import Pagination from "@/components/Pagination/Pagination.vue";
import SetSelectedPerPage from "@/components/Pagination/SetSelectedPerPage.vue";

export default {
  name: "ColorsAdminView",
  components: { Pagination, SetSelectedPerPage },
  data() {
    return {
      useCollectionStore: useColorStore,
      creating: false,
      deletingId: null,
      colorInput: "",
      serverErrors: {},
      localError: null,
    };
  },
  computed: {
    ...mapState(useColorStore, ["items", "loading", "pagination", "error"]),
    totalCount() {
      return Number(this.pagination?.total ?? 0);
    },
  },
  methods: {
    ...mapActions(useColorStore, { getPaging: "getPaging", createAction: "create", deleteAction: "delete" }),
    async createColor() {
      this.creating = true;
      this.serverErrors = {};
      this.localError = null;
      try {
        await this.createAction({ colorName: this.colorInput });
        const toastStore = useToastStore();
        toastStore.messages.push("Color added successfully.");
        toastStore.show("Success");
        this.colorInput = "";
      } catch (err) {
        if (err?.response?.status === 422) {
          this.serverErrors = err.response.data?.errors ?? {};
        } else if (err?.response?.status === 403) {
          this.localError = "You do not have permission to add colors.";
        } else {
          this.localError = "An error occurred while saving.";
        }
      } finally {
        this.creating = false;
      }
    },
    async deleteColor(id) {
      if (!confirm("Are you sure you want to delete this color?")) return;
      this.deletingId = id;
      this.localError = null;
      try {
        await this.deleteAction(id);
        const toastStore = useToastStore();
        toastStore.messages.push("Color deleted successfully.");
        toastStore.show("Success");
      } catch (err) {
        if (err?.response?.status === 403) {
          this.localError = "You do not have permission to delete colors.";
        } else {
          this.localError = "An error occurred while deleting.";
        }
      } finally {
        this.deletingId = null;
      }
    },
  },
  async mounted() {
    await this.getPaging(1);
  },
};
</script>

<style scoped>
.color-per-page {
  margin-left: auto;
}

@media (min-width: 768px) {
  .color-per-page {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    margin-left: 0;
  }
}
</style>
