const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
const sign_in_btn2 = document.querySelector("#sign-in-btn2");
const sign_up_btn2 = document.querySelector("#sign-up-btn2");

function updateTitle() {
    const isSignUp = container.classList.contains("sign-up-mode");
    const isSignUp2 = container.classList.contains("sign-up-mode2");

    if (isSignUp) {
        document.title = "Registro – Suits";
    } else if (isSignUp2) {
        document.title = "Registro – Suits";
    } else {
        document.title = "Iniciar Sesión – Suits";
    }
}

sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
    updateTitle();
});

sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
    updateTitle();
});

sign_up_btn2.addEventListener("click", () => {
    container.classList.add("sign-up-mode2");
    updateTitle();
});

sign_in_btn2.addEventListener("click", () => {
    container.classList.remove("sign-up-mode2");
    updateTitle();
});

// Actualizar el título al cargar la página según el estado inicial
updateTitle();