import apiClient from "./axiosClient";

export default {
  getFavorites() {
    return apiClient.get("/favourites");
  },

  addFavorite(dogId) {
    return apiClient.post("/favourites", { dogId: Number(dogId) });
  },

  removeFavorite(dogId) {
    return apiClient.delete(`/favourites/${Number(dogId)}`);
  },
};

