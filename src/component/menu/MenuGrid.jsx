import MenuCard from "./MenuCard";

const MenuGrid = ({ items, kategoriAktif }) => (
  <>
    <div className="flex items-center gap-2 sm:gap-3 mt-6 sm:mt-8 mb-4 sm:mb-5">
      <span style={{ color: "var(--hijau-sedang)", fontSize: "1.1rem" }}>🌿</span>
      <span
        className="font-playfair font-semibold text-lg sm:text-2xl"
        style={{ color: "var(--hijau-tua)" }}
      >
        {kategoriAktif === "Semua" ? "Daftar Menu" : kategoriAktif}
      </span>
      <div className="section-line" />
    </div>

    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-5">
      {items.map((item, i) => (
        <MenuCard key={item.id_menu} item={item} index={i} />
      ))}
    </div>
  </>
);

export default MenuGrid;