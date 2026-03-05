import { defineStore } from "pinia";
import service from "@/api/dogDeleteModalService";

export const useDogDeleteModalStore = defineStore("dogDeleteModal", {
  state: () => ({
    isOpen: false,
    dogId: null,
    dogName: "",
    title: "",
    message: "",
  }),
  actions: {
    open(dog) {
      this.isOpen = true;
      this.dogId = dog?.id ?? null;
      this.dogName = dog?.name ?? "";
      this.title = service.getTitle();
      this.message = service.getMessage(this.dogName);
    },
    close() {
      this.isOpen = false;
      this.dogId = null;
      this.dogName = "";
      this.title = "";
      this.message = "";
    },
  },
});

