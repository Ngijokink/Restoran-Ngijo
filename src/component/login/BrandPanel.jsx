const BrandPanel = () => (
  <div
    className="hidden md:flex flex-1 flex-col items-center justify-center relative overflow-hidden px-8 lg:px-16"
    style={{ background: "linear-gradient(160deg, var(--hijau-tua) 0%, var(--hijau-sedang) 100%)" }}
  >
    <div className="deco-circle" style={{ width: 500, height: 500, top: -160, left: -160 }} />
    <div className="deco-circle" style={{ width: 340, height: 340, bottom: -100, right: -100 }} />
    <div className="deco-circle" style={{ width: 200, height: 200, top: "40%", left: "30%" }} />

    <div className="relative z-10 text-center">
      <div
        className="font-playfair tracking-widest leading-none emas-glow"
        style={{ fontSize: "clamp(3.5rem, 7vw, 5.5rem)", color: "var(--emas-muda)" }}
      >
        Ngijo
      </div>
    <br/>
      <p
        className="font-lora italic text-sm mt-3 tracking-widest"
        style={{ color: "var(--hijau-terang)", letterSpacing: "3px" }}
      >
        Warung Makan Tradisional
      </p>

      <div className="flex items-center justify-center gap-3 my-6">
        <div className="left-ornamen-garis" />
        <span style={{ color: "var(--emas)" }}>✿</span>
        <div className="left-ornamen-garis kanan" />
      </div>

      <p
        className="font-lora italic text-sm lg:text-base leading-relaxed max-w-xs mx-auto"
        style={{ color: "var(--coklat-muda)", opacity: 0.85 }}
      >
        "Sego panas, sambel mantap,<br />
        lan suwasana sing ora terlupakan."
      </p>
    </div>

    <div className="absolute bottom-8 flex gap-1.5 z-10">
      <div className="w-2 h-2 rounded-full" style={{ backgroundColor: "var(--emas)" }} />
      <div className="w-2 h-2 rounded-full opacity-50" style={{ backgroundColor: "var(--emas)" }} />
      <div className="w-2 h-2 rounded-full opacity-50" style={{ backgroundColor: "var(--emas)" }} />
    </div>
  </div>
);

export default BrandPanel;