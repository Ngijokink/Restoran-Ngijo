import useLogin from "../Hooks/useLogin";
import BrandPanel from "../component/login/BrandPanel";
import LoginForm from "../component/login/LoginForm";

const Login = () => {
  const {
    email, setEmail,
    password, setPassword,
    showPass, toggleShowPass,
    loading, error,
    handleLogin,
  } = useLogin();

  return (
    <div
      className="min-h-screen flex flex-col md:flex-row font-lora"
      style={{ backgroundColor: "var(--hijau-tua)" }}
    >
      <BrandPanel />

      <LoginForm
        email={email}
        setEmail={setEmail}
        password={password}
        setPassword={setPassword}
        showPass={showPass}
        toggleShowPass={toggleShowPass}
        loading={loading}
        error={error}
        onSubmit={handleLogin}
      />
    </div>
  );
};

export default Login;