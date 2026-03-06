import { useEffect, useState } from "react";
import api from "../Service/Axios";

const Menu = () => {

  const [menus, setMenus] = useState([]);

useEffect(() => {
  api.get("/menu")
    .then((res) => {
      console.log("API RESPONSE:")
      const data = res.data.data;
      setMenus(Array.isArray(data) ? data : []); // ✅ Guard against non-arrays
    })
    .catch((err) => {
      console.log(err);
    });
}, []);

  return (
    <div>
      <h1>Menu Restoran</h1>

      {menus.map((m) => (
        <div key={m.id_menu}>
          <h3>{m.menu}</h3>
          <p>Rp {m.price}</p>
          <p>stock {m.stock}</p>
        </div>
      ))}

    </div>
  );
};

export default Menu;