import { Routes, Route } from "react-router-dom";
import Login from "./Pages/Login";
import axios from "./Service/Axios";
import Menu from "./Pages/Menu";
function App() {
  return (
    <Routes>
      <Route path="/" element={<Login />} />
      <Route path="/Menu" element={<Menu />} />
    </Routes>
  );
}

export default App;