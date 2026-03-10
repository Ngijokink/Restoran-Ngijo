const ErrorAlert = ({ message }) => (
  <div
    className="animate-shake flex items-start sm:items-center gap-2 rounded-md px-3 sm:px-3.5 py-2.5 text-xs sm:text-sm mb-4 sm:mb-5 w-full"
    style={{ background: "#fff5f5", border: "1px solid #fca5a5", color: "#b91c1c" }}
  >
    <span className="mt-0.5 sm:mt-0 flex-shrink-0">⚠️</span>
    <span>{message}</span>
  </div>
);

export default ErrorAlert;