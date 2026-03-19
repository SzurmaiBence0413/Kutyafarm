import axios from "axios";
import { useUserLoginLogoutStore } from "@/stores/userLoginLogoutStore";
import { useToastStore } from "@/stores/toastStore";

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

apiClient.interceptors.request.use(
  (config) => {
    const token = useUserLoginLogoutStore().token;
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error),
);

apiClient.interceptors.response.use(
  (response) => response.data,
  (error) => {
    const userStore = useUserLoginLogoutStore();
    const toastStore = useToastStore();

    if (error.response) {
      const status = error.response.status;
      let message = error.response.data.message || "Hiba tortent";
      const requestUrl = String(error.config?.url || "");
      const isLoginRequest = requestUrl.includes("/users/login");

      if (status === 422) {
        return Promise.reject(error);
      }

      if (status === 401) {
        if (!isLoginRequest && userStore.token) {
          userStore.item = null;
          localStorage.removeItem("user_data");
          return Promise.reject(error);
        }

        toastStore.messages.push(message);
        toastStore.show("Error");
        return Promise.reject(error);
      }

      if (status === 500) {
        if (message.includes("1451")) {
          message = "A sor nem torolheto, mert mar szerepel egy masik tablaban!";
        } else {
          message = "Szerver oldali hiba tortent a muvelet soran.";
        }
      }

      toastStore.messages.push(message);
      toastStore.show("Error");
    } else {
      toastStore.messages.push("A szerver nem erheto el.");
      toastStore.show("Error");
    }

    return Promise.reject(error);
  },
);

export default apiClient;
