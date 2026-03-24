import apiClient from "./axiosClient";

export default {
  async createAdoptionRequest(data) {
    return await apiClient.post("/adoptions", data);
  },

  async getAdoptions() {
    return await apiClient.get("/adoptions");
  },

  async updateAdoptionStatus(id, status) {
    return await apiClient.patch(`/adoptions/${id}`, { status });
  },
};
