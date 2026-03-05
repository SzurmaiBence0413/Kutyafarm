import { defineStore } from "pinia";
import service from "@/api/dogEditModalService";

export const useDogEditModalStore = defineStore("dogEditModal", {
  state: () => ({
    isOpen: false,
    title: "",
    dog: null,
  }),
  actions: {
    open(dog) {
      this.isOpen = true;
      this.title = service.getTitle();
      this.dog = dog ? { ...dog } : null;
    },
    close() {
      this.isOpen = false;
      this.title = "";
      this.dog = null;
    },
  },
});

