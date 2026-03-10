import { useEffect, useState } from "react";
import api from "../Service/Axios";

const dummyMenus = [
  { id_menu: 1, menu: "Nasi Liwet Jawa",      price: 18000, stock: 25, kategori: "Nasi" },
  { id_menu: 2, menu: "Ayam Bakar Kecap",     price: 25000, stock: 15, kategori: "Lauk" },
  { id_menu: 3, menu: "Tempe Orek Pedas",     price:  8000, stock: 30, kategori: "Lauk" },
  { id_menu: 4, menu: "Sayur Lodeh Terong",   price: 10000, stock:  0, kategori: "Sayur" },
  { id_menu: 5, menu: "Es Dawet Ngijo",       price:  8000, stock: 20, kategori: "Minuman" },
  { id_menu: 6, menu: "Teh Poci Gulo Batu",   price:  6000, stock: 50, kategori: "Minuman" },
  { id_menu: 7, menu: "Pecel Lele Sambal Ijo", price: 22000, stock: 10, kategori: "Lauk" },
  { id_menu: 8, menu: "Gudeg Yu Djum",        price: 20000, stock:  8, kategori: "Nasi" },
];

const useMenu = () => {
  const [menus, setMenus]               = useState([]);
  const [loading, setLoading]           = useState(true);
  const [search, setSearch]             = useState("");
  const [kategoriAktif, setKategoriAktif] = useState("Semua");

  useEffect(() => {
    api
      .get("/menus")
      .then((res) => {
        const data = res.data.data;
        setMenus(Array.isArray(data) ? data : dummyMenus);
      })
      .catch(() => setMenus(dummyMenus))
      .finally(() => setLoading(false));
  }, []);

  const kategoriList = [
    "Semua",
    ...Array.from(new Set(menus.map((m) => m.kategori).filter(Boolean))),
  ];

  const filteredMenus = menus.filter((m) => {
    const cocokKategori = kategoriAktif === "Semua" || m.kategori === kategoriAktif;
    const cocokSearch   = m.menu.toLowerCase().includes(search.toLowerCase());
    return cocokKategori && cocokSearch;
  });

  return {
    loading,
    search, setSearch,
    kategoriAktif, setKategoriAktif,
    kategoriList,
    filteredMenus,
  };
};
// contohh
export default useMenu;