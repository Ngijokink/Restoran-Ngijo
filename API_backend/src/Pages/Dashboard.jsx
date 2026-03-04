import { useEffect, useState } from "react";
import api from "../Service/Axios.js";

const Menu = () => {
  const [menus, setMenus] = useState([]);

  useEffect(() => {
    api.get("/menus").then((res) => setMenus(res.data));
  }, []);

  return (
    <div>
      <h1>Menu Restoran</h1>
      {menus.map((m) => (
        <div key={m.id}>
          <h3>{m.name}</h3>
          <p>Rp {m.price}</p>
        </div>
      ))}
    </div>
  );
};

export default Menu;