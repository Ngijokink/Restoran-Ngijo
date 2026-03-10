import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../Service/Axios";

const useLogin = () => {
  const [email, setEmail]       = useState("");
  const [password, setPassword] = useState("");
  const [showPass, setShowPass] = useState(false);
  const [loading, setLoading]   = useState(false);
  const [error, setError]       = useState("");
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      const res = await api.post("/login", { email, password });

      if (res.status === 204 || !res.data) {
        setError("Server tidak mengembalikan data. Hubungi admin.");
        return;
      }

      if (!res.data.token) {
        setError("Token tidak ditemukan. Hubungi admin.");
        return;
      }

      localStorage.setItem("token", res.data.token);
      navigate("/menu");

    } catch (err) {
      console.error(err);

      if (err.response) {
        if (err.response.status === 401 || err.response.status === 422) {
          setError("Email atau password salah. Coba maneh, Mas/Mbak.");
        } else {
          setError(`Terjadi kesalahan server (${err.response.status}). Hubungi admin.`);
        }
      } else if (err.request) {
        setError("Tidak dapat terhubung ke server. Periksa koneksi internet.");
      } else {
        setError("Terjadi kesalahan. Silakan coba lagi.");
      }

    } finally {
      setLoading(false);
    }
  };

  const toggleShowPass = () => setShowPass((prev) => !prev);

  return {
    email, setEmail,
    password, setPassword,
    showPass, toggleShowPass,
    loading, error,
    handleLogin,
  };
};

export default useLogin;