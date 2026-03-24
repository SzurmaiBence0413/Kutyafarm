import { defineStore } from "pinia";
import { ref } from "vue";
import service from "@/api/dogEditModalService";

export const useDogEditModalStore = defineStore("dogEditModal", () => {
  const isOpen = ref(false);
  const title = ref("");
  const dog = ref(null);

  function open(dogToEdit) {
    isOpen.value = true;
    title.value = service.getTitle();
    dog.value = dogToEdit ? { ...dogToEdit } : null;
  }

  function close() {
    isOpen.value = false;
    title.value = "";
    dog.value = null;
  }

  return {
    isOpen,
    title,
    dog,
    open,
    close,
  };
});
