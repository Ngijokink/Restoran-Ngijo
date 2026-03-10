import useMenu from "../Hooks/useMenu";
import MenuHeader from "../component/menu/MenuHeader";
import KategoriNav from "../component/menu/KategoriNav";
import SearchBar from "../component/menu/SearchBar";
import MenuGrid from "../component/menu/MenuGrid";
import LoadingState from "../component/menu/LoadingState";
import EmptyState from "../component/menu/EmptyState";

const Menu = () => {
  const {
    loading,
    search, setSearch,
    kategoriAktif, setKategoriAktif,
    kategoriList,
    filteredMenus,
  } = useMenu();

  return (
    <div className="batik-bg min-h-screen font-lora overflow-x-hidden">
      <MenuHeader />

      {!loading && (
        <KategoriNav
          kategoriList={kategoriList}
          kategoriAktif={kategoriAktif}
          onKategoriChange={setKategoriAktif}
        />
      )}

      <main className="w-full max-w-xs sm:max-w-2xl md:max-w-4xl lg:max-w-6xl mx-auto px-3 sm:px-4 md:px-6 pb-16 pt-6 sm:pt-8">
        {loading ? (
          <LoadingState />
        ) : (
          <>
            <SearchBar value={search} onChange={setSearch} />

            <p
              className="font-lora text-center text-xs italic mb-4 sm:mb-6 opacity-80"
              style={{ color: "var(--hijau-sedang)" }}
            >
              {filteredMenus.length} menu ditemukan
            </p>

            {filteredMenus.length === 0 ? (
              <EmptyState />
            ) : (
              <MenuGrid items={filteredMenus} kategoriAktif={kategoriAktif} />
            )}
          </>
        )}
      </main>

      <footer
        className="text-center py-5 sm:py-6 font-lora italic text-xs tracking-widest"
        style={{ backgroundColor: "var(--hijau-tua)", color: "var(--hijau-terang)" }}
      >
        ✿ &nbsp; Salam seko Warung Ngijo &nbsp; ✿
      </footer>
    </div>
  );
};

export default Menu;