<template>
  <section class="browse-dogs-view">
    <div class="container py-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-title m-0">Browse Dogs</h1>
        <button
          v-if="canCreateDog"
          class="btn btn-warning text-white"
          @click="isAddFormOpen = !isAddFormOpen"
        >
          {{ isAddFormOpen ? "Cancel" : "Add Dog" }}
        </button>
      </div>

      <AddDogForm
        v-if="isAddFormOpen && canCreateDog"
        :breeds="breeds"
        :colors="colors"
        :loading="formLoading"
        mode="create"
        @submit="createDogHandler"
        @close="closeForm"
      />

      <DogEditModal
        :isOpen="editModalOpen"
        :title="editModalTitle"
        :dog="editModalDog"
        :breeds="breeds"
        :colors="colors"
        :loading="formLoading"
        @close="closeEditModal"
        @submit="submitEditHandler"
      />

      <DogDeleteConfirmModal
        :isOpen="deleteModalOpen"
        :title="deleteModalTitle"
        :message="deleteModalMessage"
        @cancel="closeDeleteModal"
        @confirm="confirmDeleteDog"
      />

      <DogBrowseFilters
        :searchText="searchText"
        :selectedBreed="selectedBreed"
        :breedOptions="breedOptions"
        @update:searchText="setSearchText"
        @update:selectedBreed="setSelectedBreed"
      />

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-warning" role="status"></div>
      </div>

      <div v-else-if="error" class="alert alert-danger" role="alert">
        Could not load dogs. Please try again.
      </div>

      <template v-else>
        <p class="results mb-4">Showing {{ filteredDogs.length }} dogs</p>

        <div class="row g-4">
          <div
            class="col-12 col-sm-6 col-lg-4 col-xl-3"
            v-for="dog in filteredDogs"
            :key="dog.id"
          >
            <DogCard
              :dog="dog"
              :isFavorite="isFavorite(dog.id)"
              :canManage="canCreateDog"
              @toggle-favorite="toggleFavorite"
              @edit="openEditForm"
              @delete="openDeleteModal"
            />
          </div>
        </div>
      </template>
    </div>
  </section>
</template>

<script>
import { mapActions, mapState } from "pinia";
import { useDogBrowseStore } from "@/stores/dogBrowseStore";
import { useDogDeleteModalStore } from "@/stores/dogDeleteModalStore";
import { useDogEditModalStore } from "@/stores/dogEditModalStore";
import { useFavoritesStore } from "@/stores/favoritesStore";
import { useUserLoginLogoutStore } from "@/stores/userLoginLogoutStore";
import DogBrowseFilters from "@/components/Dogs/DogBrowseFilters.vue";
import DogCard from "@/components/Dogs/DogCard.vue";
import AddDogForm from "@/components/Dogs/AddDogForm.vue";
import DogDeleteConfirmModal from "@/components/Dogs/DogDeleteConfirmModal.vue";
import DogEditModal from "@/components/Dogs/DogEditModal.vue";

export default {
  name: "DogsView",
  components: {
    DogBrowseFilters,
    DogCard,
    AddDogForm,
    DogDeleteConfirmModal,
    DogEditModal,
  },
  data() {
    return {
      isAddFormOpen: false,
    };
  },

  computed: {
    ...mapState(useDogBrowseStore, [
      "loading",
      "formLoading",
      "error",
      "searchText",
      "selectedBreed",
      "breedOptions",
      "breeds",
      "colors",
      "filteredDogs",
    ]),
    ...mapState(useUserLoginLogoutStore, ["isLoggedIn", "role"]),
    ...mapState(useDogDeleteModalStore, {
      deleteModalOpen: "isOpen",
      deleteModalTitle: "title",
      deleteModalMessage: "message",
      deleteDogId: "dogId",
    }),
    ...mapState(useFavoritesStore, ["favoriteIds"]),
    ...mapState(useDogEditModalStore, {
      editModalOpen: "isOpen",
      editModalTitle: "title",
      editModalDog: "dog",
    }),
    canCreateDog() {
      return this.isLoggedIn && [1, 2].includes(this.role);
    },
  },

  methods: {
    ...mapActions(useDogBrowseStore, [
      "fetchDogs",
      "createDog",
      "updateDog",
      "deleteDog",
      "setSearchText",
      "setSelectedBreed",
    ]),
    ...mapActions(useFavoritesStore, ["initFavorites", "toggleFavorite", "isFavorite"]),
    ...mapActions(useDogDeleteModalStore, {
      openDeleteState: "open",
      closeDeleteModal: "close",
    }),
    ...mapActions(useDogEditModalStore, {
      openEditState: "open",
      closeEditModal: "close",
    }),
    async createDogHandler(formData) {
      try {
        await this.createDog(formData);
        this.closeForm();
      } catch (error) {}
    },
    closeForm() {
      this.isAddFormOpen = false;
    },
    openEditForm(dog) {
      this.openEditState(dog);
    },
    async submitEditHandler(formData) {
      if (!this.editModalDog?.id) return;
      try {
        await this.updateDog(this.editModalDog.id, formData);
        this.closeEditModal();
      } catch (error) {}
    },
    openDeleteModal(dogId) {
      const dog = this.filteredDogs.find((item) => item.id === dogId);
      this.openDeleteState(dog || { id: dogId, name: "" });
    },
    async confirmDeleteDog() {
      if (!this.deleteDogId) return;
      try {
        await this.deleteDog(this.deleteDogId);
        this.closeDeleteModal();
      } catch (error) {}
    },
  },

  async mounted() {
    this.initFavorites();
    await this.fetchDogs();
  },
};
</script>

<style scoped>
.browse-dogs-view {
  background: #f5f6f8;
  min-height: 100%;
}

.page-title {
  font-size: 2.6rem;
  font-weight: 700;
  letter-spacing: 0.2px;
}

.results {
  color: #4c5568;
  font-size: 1.06rem;
}

@media (max-width: 768px) {
  .page-title {
    font-size: 2rem;
  }
}
</style>
