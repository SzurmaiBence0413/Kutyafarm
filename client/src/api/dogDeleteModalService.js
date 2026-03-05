export default {
  getTitle() {
    return "Delete Dog";
  },

  getMessage(dogName = "") {
    return `Are you sure you want to delete ${dogName ? `"${dogName}"` : "this dog"}?`;
  },
};

