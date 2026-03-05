import apiClient from "./axiosClient";

export default {
  async getDogs() {
    return await apiClient.get("/dogs");
  },

  async getBreeds() {
    return await apiClient.get("/breeds");
  },

  async getColors() {
    return await apiClient.get("/colors");
  },

  async getPhotos() {
    return await apiClient.get("/photos");
  },

  async createDog(data) {
    return await apiClient.post("/dogs", data);
  },

  async createPhoto(data) {
    return await apiClient.post("/photos", data);
  },

  async deletePhoto(id) {
    return await apiClient.delete(`/photos/${id}`);
  },

  async getRandomDogImage() {
    const response = await fetch("https://dog.ceo/api/breeds/image/random");
    const payload = await response.json();
    return payload?.message || "";
  },

  async updateDog(id, data) {
    return await apiClient.patch(`/dogs/${id}`, data);
  },

  async deleteDog(id) {
    return await apiClient.delete(`/dogs/${id}`);
  },
};
