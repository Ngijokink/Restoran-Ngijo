import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../Service/Axios.js";

const Login = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();
    try {
      const res = await api.post("/Login", { email, password });
      localStorage.setItem("token", res.data.token);
      navigate("/Dashboard");
    } catch {
      alert("Login gagal. Skill backend atau email lu salah.");
    }
  };

  return (
    <form onSubmit={handleLogin}>
      <input onChange={(e) => setEmail(e.target.value)} placeholder="Email" />
      <input type="password" onChange={(e) => setPassword(e.target.value)} placeholder="Password" />
      <button>Login</button>
    </form>
  );
};

export default Login;