import apiClient from "./axiosClient";

export default {
  async getMedicines() {
    return await apiClient.get("/medicines");
  },
  async createMedicine(payload) {
    return await apiClient.post("/medicines", payload);
  },
  async updateMedicine(id, payload) {
    return await apiClient.patch(`/medicines/${id}`, payload);
  },
  async deleteMedicine(id) {
    return await apiClient.delete(`/medicines/${id}`);
  },
};
