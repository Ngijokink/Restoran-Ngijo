const KategoriNav = ({ kategoriList, kategoriAktif, onKategoriChange }) => (
  <nav
    className="flex gap-2 flex-wrap justify-start sm:justify-center px-4 sm:px-6 py-3 overflow-x-auto scrollbar-hide"
    style={{ backgroundColor: "var(--hijau-sedang)", borderBottom: "3px solid var(--emas)" }}
  >
    {kategoriList.map((k) => (
      <button
        key={k}
        onClick={() => onKategoriChange(k)}
        className="font-lora whitespace-nowrap rounded-full px-3 sm:px-4 py-1.5 text-xs sm:text-sm tracking-wide transition-all duration-200 flex-shrink-0"
        style={
          kategoriAktif === k
            ? { backgroundColor: "var(--emas)", border: "1px solid var(--emas)", color: "var(--hijau-tua)", fontWeight: 600 }
            : { backgroundColor: "transparent", border: "1px solid var(--hijau-terang)", color: "var(--hijau-pucat)" }
        }
      >
        {k}
      </button>
    ))}
  </nav>
);

export default KategoriNav;