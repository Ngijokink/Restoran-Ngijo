const LoadingState = () => (
  <div className="flex flex-col items-center justify-center py-16 sm:py-24 px-4">
    <span className="text-4xl sm:text-5xl block mb-4 animate-spin-leaf">🌿</span>
    <p className="font-lora italic text-sm sm:text-base text-center" style={{ color: "var(--hijau-sedang)" }}>
      Nyiapke menu sabar ya, Mas/Mbak...
    </p>
  </div>
);

export default LoadingState;