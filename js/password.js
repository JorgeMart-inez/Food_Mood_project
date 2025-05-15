window.addEventListener('DOMContentLoaded', () => {
    // EVENTO PARA CAMPO DE CONTRASEÑA EN LOGIN
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput  = document.getElementById("contrasenia");

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye-slash");
            this.classList.toggle("fa-eye");
        });
    }

    // EVENTOS PARA CAMPOS EN SIGNUP
    function togglePasswordField(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);

        if (input && icon) {
            icon.addEventListener("click", function () {
                const type = input.getAttribute("type") === "password" ? "text" : "password";
                input.setAttribute("type", type);
                icon.classList.toggle("fa-eye-slash");
                icon.classList.toggle("fa-eye");
            });
        }
    }

    togglePasswordField("contrasenia1", "togglePass1");
    togglePasswordField("contrasenia2", "togglePass2");
});
