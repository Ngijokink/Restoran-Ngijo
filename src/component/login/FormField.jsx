const FormField = ({ label, icon, children }) => (
  <div className="w-full mb-4 sm:mb-5">
    <label
      className="block text-xs font-semibold uppercase tracking-widest mb-1.5 sm:mb-2"
      style={{ color: "var(--hijau-tua)", letterSpacing: "1.5px" }}
    >
      {label}
    </label>
    <div className="relative">
      <span
        className="absolute left-3 sm:left-3.5 top-1/2 -translate-y-1/2 text-sm sm:text-base pointer-events-none"
        style={{ color: "var(--hijau-muda)" }}
      >
        {icon}
      </span>
      {children}
    </div>
  </div>
);

export default FormField;