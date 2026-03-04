import axios from "axios";

const api = axios.create({
  baseURL: "https://901wlr67-8000.asse.devtunnels.ms/api",
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;