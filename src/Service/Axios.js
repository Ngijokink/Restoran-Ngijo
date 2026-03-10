import axios from "axios";

const api = axios.create({
  baseURL: "https://unbeaten-rarely-ardella.ngrok-free.dev/api",
  headers: {
    "Content-Type": "application/json",
    "ngrok-skip-browser-warning": "true",
  },
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});

export const getProduct = (callback) => {
  api
    .get("/")
    .then((res) => callback(res.data))
    .catch((err) => console.log(err));
};

export default api;