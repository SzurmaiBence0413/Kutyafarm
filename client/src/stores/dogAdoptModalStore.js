import { defineStore } from "pinia";
import { ref } from "vue";
import service from "@/api/dogAdoptModalService";

export const useDogAdoptModalStore = defineStore("dogAdoptModal", () => {
  const isOpen = ref(false);
  const title = ref("");
  const dog = ref(null);

  function open(dogToAdopt) {
    isOpen.value = true;
    title.value = service.getTitle();
    dog.value = dogToAdopt ? { ...dogToAdopt } : null;
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

