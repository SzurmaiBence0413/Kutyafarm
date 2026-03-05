import apiClient from "./axiosClient";

export default {
  async getMedicines() {
    return await apiClient.get("/medicines");
  },
};
