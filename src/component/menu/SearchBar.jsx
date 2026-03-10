const SearchBar = ({ value, onChange }) => (
  <div className="relative w-full max-w-xs sm:max-w-sm md:max-w-md mx-auto mb-3">
    <span
      className="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm sm:text-base pointer-events-none"
      style={{ color: "var(--hijau-muda)" }}
    >
      🔍
    </span>
    <input
      type="text"
      placeholder="Goleki menu..."
      value={value}
      onChange={(e) => onChange(e.target.value)}
      className="form-input w-full font-lora text-sm rounded-full pl-10 pr-4 py-2 sm:py-2.5 outline-none transition-all duration-200"
      style={{
        border: "2px solid var(--hijau-terang)",
        color: "var(--hijau-tua)",
        backgroundColor: "white",
      }}
    />
  </div>
);

export default SearchBar;