import formatRupiah from "../../Utils/formatRupiah";

const MenuCard = ({ item, index }) => (
  <div
    className="card-accent relative bg-white rounded overflow-hidden animate-fadeUp transition-all duration-300 hover:-translate-y-1"
    style={{
      border: "1px solid rgba(82,183,136,0.25)",
      boxShadow: "0 4px 20px rgba(26,61,43,0.08)",
      animationDelay: `${index * 0.07}s`,
    }}
    onMouseEnter={(e) => (e.currentTarget.style.boxShadow = "0 12px 32px rgba(26,61,43,0.18)")}
    onMouseLeave={(e) => (e.currentTarget.style.boxShadow = "0 4px 20px rgba(26,61,43,0.08)")}
  >
    {/* Badge habis */}
    {item.stock === 0 && (
      <div
        className="absolute top-2.5 right-0 text-white text-xs font-bold tracking-wide uppercase px-2 py-0.5"
        style={{ backgroundColor: "#e57373" }}
      >
        Habis
      </div>
    )}

    {/* Header card */}
    <div
      className="card-header-deco relative overflow-hidden px-4 sm:px-5 pt-3.5 pb-3"
      style={{ background: "linear-gradient(135deg, var(--hijau-tua), var(--hijau-sedang))" }}
    >
      <div
        className="font-playfair font-semibold text-white leading-snug pr-6"
        style={{ fontSize: "clamp(0.9rem, 2.5vw, 1.1rem)" }}
      >
        {item.menu}
      </div>
      {item.kategori && (
        <span
          className="inline-block text-xs font-bold uppercase rounded-sm mt-1.5 px-2 py-0.5"
          style={{ backgroundColor: "var(--emas)", color: "var(--hijau-tua)", letterSpacing: "1px" }}
        >
          {item.kategori}
        </span>
      )}
    </div>

    <div className="menu-divider" />

    {/* Body card */}
    <div className="flex justify-between items-end px-4 sm:px-5 pt-3 pb-3.5">
      <div>
        <span
          className="block font-lora text-xs uppercase tracking-wide mb-0.5"
          style={{ color: "#999" }}
        >
          Harga
        </span>
        <div
          className="font-playfair font-semibold"
          style={{ fontSize: "clamp(1rem, 3vw, 1.25rem)", color: "var(--hijau-sedang)" }}
        >
          {formatRupiah(item.price)}
        </div>
      </div>
      <div className="text-right">
        <div
          className="text-xl sm:text-2xl font-bold leading-none"
          style={{ color: item.stock === 0 ? "#e57373" : "var(--hijau-muda)" }}
        >
          {item.stock}
        </div>
        <div
          className="font-lora text-xs uppercase tracking-wide"
          style={{ color: item.stock === 0 ? "#e57373" : "#aaa" }}
        >
          Stok
        </div>
      </div>
    </div>
  </div>
);

export default MenuCard;