import { Routes, Route } from "react-router-dom"
import Login from "./Pages/Login";
import Dashbord from "./Pages/Dashboard";
import ProtectedRoute from "./ProtectedRoute/Protected.Route";
import axios from "./Service/Axios"

 function App() {
  return (
    <Routes>
      <Route path="/" element={<Login />} />
      <Route path="/dashboard" element={<Dashboard />} />
    </Routes>
  );
}

export default App
