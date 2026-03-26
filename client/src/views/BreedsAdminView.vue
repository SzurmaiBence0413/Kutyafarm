<template>
  <div class="container py-3">
    <div class="d-flex align-items-center mb-3 position-relative flex-wrap">
      <h1 class="m-0">Breeds</h1>
      <i
        v-if="loading"
        class="bi bi-hourglass-split fs-3 col-auto p-0 ps-2"
      ></i>
      <p class="m-0 ms-2 text-muted">({{ totalCount }})</p>
      
      <div class="breed-per-page">
        <SetSelectedPerPage :useCollectionStore="useCollectionStore" />
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-body">
        <form class="row g-2 align-items-end" @submit.prevent="createBreed">
          <div class="col-12 col-md-6">
            <label for="breed" class="form-label">Breed name</label>
            <input
              id="breed"
              v-model.trim="breedInput"
              class="form-control"
              type="text"
              maxlength="50"
              :disabled="creating"
              required
            />
            <div v-if="serverErrors.breed" class="text-danger small mt-1">
              {{ serverErrors.breed[0] }}
            </div>
          </div>
          <div class="col-12 col-md-auto">
            <button
              class="btn btn-primary"
              type="submit"
              :disabled="creating || !breedInput"
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
      Hiba történt a művelet közben.
    </div>

    <div v-if="!loading && items.length === 0" class="text-center text-muted">
      Nincs még felvitt breed.
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
              <th>Breed</th>
              <th class="text-end" style="width: 140px">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="breed in items" :key="breed.id">
              <td>{{ breed.id }}</td>
              <td>{{ breed.breed }}</td>
              <td class="text-end">
                <button
                  class="btn btn-sm btn-outline-danger"
                  type="button"
                  :disabled="deletingId === breed.id"
                  @click="deleteBreed(breed.id)"
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
import { useBreedStore } from "@/stores/breedStore";
import { useToastStore } from "@/stores/toastStore";
import Pagination from "@/components/Pagination/Pagination.vue";
import SetSelectedPerPage from "@/components/Pagination/SetSelectedPerPage.vue";

export default {
  name: "BreedsAdminView",
  components: { Pagination, SetSelectedPerPage },
  data() {
    return {
      useCollectionStore: useBreedStore,
      creating: false,
      deletingId: null,
      breedInput: "",
      serverErrors: {},
      localError: null,
    };
  },
  computed: {
    ...mapState(useBreedStore, ["items", "loading", "pagination", "error"]),
    totalCount() {
      return Number(this.pagination?.total ?? 0);
    },
  },
  methods: {
    ...mapActions(useBreedStore, { getPaging: "getPaging", createAction: "create", deleteAction: "delete" }),
    async createBreed() {
      this.creating = true;
      this.serverErrors = {};
      this.localError = null;
      try {
        await this.createAction({ breed: this.breedInput });
        const toastStore = useToastStore();
        toastStore.messages.push("Breed felvéve");
        toastStore.show("Success");
        this.breedInput = "";
      } catch (err) {
        if (err?.response?.status === 422) {
          this.serverErrors = err.response.data?.errors ?? {};
        } else if (err?.response?.status === 403) {
          this.localError = "Nincs jogosultságod breedet felvinni.";
        } else {
          this.localError = "Hiba történt a mentés közben.";
        }
      } finally {
        this.creating = false;
      }
    },
    async deleteBreed(id) {
      if (!confirm("Biztosan törlöd ezt a breedet?")) return;
      this.deletingId = id;
      this.localError = null;
      try {
        await this.deleteAction(id);
        const toastStore = useToastStore();
        toastStore.messages.push("Breed törölve");
        toastStore.show("Success");
      } catch (err) {
        if (err?.response?.status === 403) {
          this.localError = "Nincs jogosultságod breedet törölni.";
        } else {
          this.localError = "Hiba történt a törlés közben.";
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
.breed-per-page {
  margin-left: auto;
}

@media (min-width: 768px) {
  .breed-per-page {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    margin-left: 0;
  }
}
</style>
