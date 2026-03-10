import FormField from "./FormField";
import ErrorAlert from "./ErrorAlert";

const LoginForm = ({
  email, setEmail,
  password, setPassword,
  showPass, toggleShowPass,
  loading, error,
  onSubmit,
}) => (
  <div
    className="relative w-full md:w-[400px] lg:w-[440px] flex-shrink-0 flex flex-col justify-center px-6 sm:px-10 md:px-12 py-12 md:py-0 min-h-screen"
    style={{ backgroundColor: "var(--krem)", boxShadow: "-8px 0 40px rgba(0,0,0,0.3)" }}
  >
    <div className="batik-strip" />

    <div className="min-h-screen flex flex-col justify-center ">

      {/* Logo — mobile only */}
      <div className="md:hidden text-center mb-8">
        <h1
          className="font-playfair tracking-widest"
          style={{ fontSize: "clamp(2.8rem, 10vw, 3.5rem)", color: "var(--hijau-tua)" }}
        >
          Ngijo
        </h1>
        <p
          className="font-lora italic text-sm mt-1 tracking-widest"
          style={{ color: "var(--hijau-sedang)" }}
        >
          Warung Makan Tradisional
        </p>
      </div>

      {/* Heading */}
      <div className="mb-7">
        <h2
          className="font-playfair font-semibold leading-tight"
          style={{ fontSize: "clamp(1.6rem, 4vw, 2rem)", color: "var(--hijau-tua)" }}
        >
          Sugeng Rawuh 🌿
        </h2>
        <p
          className="font-lora italic text-sm mt-1.5 opacity-80"
          style={{ color: "var(--hijau-sedang)" }}
        >
          Masuk untuk kelola warung sampeyan
        </p>
      </div>

      {/* Form */}
      <form onSubmit={onSubmit} className="w-full max-w-sm">
        {error && <ErrorAlert message={error} />}

        <FormField label="Email">
          <input
            className="form-input w-full font-lora text-sm rounded-md pl-10 pr-4 py-3 outline-none transition-all duration-200"
            type="email"
            placeholder="contoh@email.com"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
            autoComplete="email"
            style={{
              border: "1.5px solid var(--hijau-terang)",
              backgroundColor: "white",
              color: "var(--hijau-tua)",
            }}
          />
        </FormField>

        <FormField label="Password">
          <input
            className="form-input w-full font-lora text-sm rounded-md pl-10 pr-11 py-3 outline-none transition-all duration-200"
            type={showPass ? "text" : "password"}
            placeholder="Kata sandi sampeyan"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
            autoComplete="current-password"
            style={{
              border: "1.5px solid var(--hijau-terang)",
              backgroundColor: "white",
              color: "var(--hijau-tua)",
            }}
          />
          <button
            type="button"
            onClick={toggleShowPass}
            aria-label="Toggle password"
            className="absolute right-3.5 top-1/2 -translate-y-1/2 bg-transparent border-0 cursor-pointer text-base p-0 leading-none"
            style={{ color: "var(--hijau-muda)" }}
          >
            {showPass ? "🙈" : "👁️"}
          </button>
        </FormField>
        <br/>
        <button
          type="submit"
          disabled={loading}
          className="w-full mt-4 py-3 rounded-md text-sm font-semibold transition-all duration-200 flex items-center justify-center bg-green-800"
        >
          {loading && (
            <span
              className="inline-block w-4 h-4 rounded-full mr-2 align-middle animate-spin-btn"
              style={{ border: "2px solid rgba(255,255,255,0.4)", borderTopColor: "white" }}
            />
          )}
          {loading ? "Sabar..." : "Mlebu · Masuk"}
        </button>
      </form>

      {/* Ornamen bawah */}
      <div className="flex items-center gap-3 mt-8 w-full">
        <div className="flex-1 h-px opacity-50" style={{ backgroundColor: "var(--hijau-terang)" }} />
        <span style={{ color: "var(--emas)" }}>✿</span>
        <div className="flex-1 h-px opacity-50" style={{ backgroundColor: "var(--hijau-terang)" }} />
      </div>

      <p
        className="text-center mt-4 text-xs italic opacity-75 tracking-wide"
        style={{ color: "var(--hijau-sedang)" }}
      >
        Warung Ngijo · Mlaku, Mangan, Marisi
      </p>

    </div>
  </div>
);

export default LoginForm;