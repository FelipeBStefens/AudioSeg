const password = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const passwordIcon = document.getElementById("passwordIcon");

togglePassword.addEventListener("click", () => {
    
    const showPassword = password.type === "password";

    password.type = showPassword ? "text" : "password";

    passwordIcon.textContent = showPassword
        ? "visibility_off"
        : "visibility";

    togglePassword.setAttribute(
        "aria-label",
        showPassword ? "Ocultar senha" : "Mostrar senha"
    );

    togglePassword.setAttribute(
        "aria-pressed",
        String(showPassword)
    );
});