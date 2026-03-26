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

  async getUsers() {
    return await apiClient.get("/users");
  },

  async createDog(data) {
    return await apiClient.post("/dogs", data);
  },

  async createPhoto(data) {
    return await apiClient.post("/photos", data);
  },

  async createBreed(data) {
    return await apiClient.post("/breeds", data);
  },

  async deleteBreed(id) {
    return await apiClient.delete(`/breeds/${id}`);
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
