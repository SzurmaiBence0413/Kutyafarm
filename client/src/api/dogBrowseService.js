import apiClient from "./axiosClient";

export default {
  async getDogs() {
    return await apiClient.get("/dogs");
  },

  async getBreeds() {
    return await apiClient.get("/breeds");
  },

  async getPhotos() {
    return await apiClient.get("/photos");
  },
};
