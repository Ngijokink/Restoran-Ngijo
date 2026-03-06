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
    const res = await api.post("/login", { email, password });
    
    console.log("Response data:", res.data);
    console.log("Status Code:", res.status);

    if (res.status === 204 || !res.data) {
      alert("Backend sukses tapi gak ngasih data (204). Cek kodingan API lu.");
      return;
    }

    localStorage.setItem("token", res.data.token);
    navigate("/Dashboard");
  } catch (err) {
    console.error(err);
    alert("email lu salah.");
  }
};

  return (
    <div className="min-h-screen flex items-center justify-center bg-white">
      <div className="w-full max-w-sm bg-white p-6 rounded-lg shadow-md">
    <form onSubmit={handleLogin}>
      <h2 className="text-center">Login page</h2>
      <label className="block text-sm font-medium mb-1">Email</label>

      <input className="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
      onChange={(e) => setEmail(e.target.value)} 
      placeholder="Email" 
      />

      <label className="block text-sm font-medium mb-1">Password</label>

      <input className="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
       type="password" onChange={(e) => setPassword(e.target.value)} 
       placeholder="Password"
        />

      <button className="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition" type="submit">Login</button>
    </form>
    </div>
    </div>
  );
};

export default Login;