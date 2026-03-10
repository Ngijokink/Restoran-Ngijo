const MenuHeader = () => (
  <header style={{ backgroundColor: "var(--hijau-tua)" }}>
    <div
      className="header-stripe relative px-4 sm:px-6 md:px-10 py-8 sm:py-10 text-center"
      style={{ background: "linear-gradient(135deg, var(--hijau-tua) 0%, var(--hijau-sedang) 60%, var(--hijau-tua) 100%)" }}
    >
      <div className="flex items-center justify-center gap-3 sm:gap-4 mb-3">
        <div className="ornamen-garis" />
        <span style={{ color: "var(--emas)", fontSize: "18px" }}>✿</span>
        <div className="ornamen-garis" />
      </div>

      <h1
        className="font-playfair font-semibold uppercase tracking-widest leading-none emas-glow"
        style={{ fontSize: "clamp(2rem, 10vw, 5rem)", color: "var(--emas-muda)" }}
      >
        Ngijo
      </h1>

      <p
        className="font-lora italic mt-1.5 opacity-90 text-sm sm:text-base"
        style={{ color: "var(--hijau-terang)", letterSpacing: "2px" }}
      >
        Warung Makan Tradisional
      </p>

      <p
        className="mt-2 text-xs tracking-widest uppercase opacity-80"
        style={{ color: "var(--coklat-muda)" }}
      >
        Mlaku · Mangan · Marisi
      </p>
    </div>

    <div
      className="batik-border-stripe relative overflow-hidden"
      style={{ height: "20px", backgroundColor: "var(--emas)" }}
    />
  </header>
);

export default MenuHeader;