import { defineStore } from "pinia";
import service from "@/api/dogBrowseService";

class Pagination {
  constructor(current_page = 1, last_page = 1, total = 0) {
    this.current_page = current_page;
    this.last_page = last_page;
    this.total = total;
  }
}

export const useBreedStore = defineStore("breeds", {
  state: () => ({
    allItems: [],
    items: [],
    pagination: new Pagination(),
    selectedPerPage: 10,
    selectedPerPageList: [10, 30, 50, 100],
    loading: false,
    error: null,
  }),
  getters: {
    totalCount(state) {
      return Number(state.pagination?.total ?? state.allItems.length ?? 0);
    },
  },
  actions: {
    async setSelectedPerPage(value) {
      this.selectedPerPage = value;
      await this.getPaging(1);
    },
    async fetchAll() {
      const response = await service.getBreeds();
      const items = (response?.data ?? []).slice();
      items.sort((a, b) => (Number(b.id) || 0) - (Number(a.id) || 0));
      this.allItems = items;
    },
    async getPaging(page = null) {
      this.loading = true;
      this.error = null;
      try {
        if (!this.allItems.length) {
          await this.fetchAll();
        }

        const total = this.allItems.length;
        const perPage = Number(this.selectedPerPage) || 10;
        const all = perPage >= 1000000;
        const lastPage = all ? 1 : Math.max(1, Math.ceil(total / perPage));

        let current = page ? Number(page) : Number(this.pagination.current_page) || 1;
        if (!Number.isFinite(current)) current = 1;
        current = Math.min(Math.max(current, 1), lastPage);

        const start = (current - 1) * perPage;
        this.items = all ? this.allItems : this.allItems.slice(start, start + perPage);
        this.pagination = new Pagination(current, lastPage, total);
        return true;
      } catch (err) {
        this.error = err;
        throw err;
      } finally {
        this.loading = false;
      }
    },
    async create(data) {
      this.loading = true;
      this.error = null;
      try {
        await service.createBreed(data);
        this.allItems = [];
        await this.getPaging(1);
        return true;
      } catch (err) {
        this.error = err;
        throw err;
      } finally {
        this.loading = false;
      }
    },
    async delete(id) {
      this.loading = true;
      this.error = null;
      try {
        await service.deleteBreed(id);
        const current = Number(this.pagination.current_page) || 1;
        this.allItems = [];
        await this.getPaging(current);
        return true;
      } catch (err) {
        this.error = err;
        throw err;
      } finally {
        this.loading = false;
      }
    },
    reset() {
      this.allItems = [];
      this.items = [];
      this.pagination = new Pagination();
      this.selectedPerPage = this.selectedPerPageList[0];
      this.loading = false;
      this.error = null;
    },
  },
});

