// Selecciona el elemento con el ID 'open-menu', que es el botón para abrir el menú lateral
const openMenu = document.querySelector("#open-menu");

// Selecciona el elemento con el ID 'close-menu', que es el botón para cerrar el menú lateral
const closeMenu = document.querySelector("#close-menu");

// Selecciona el elemento 'aside', que representa la barra lateral
const aside = document.querySelector("aside");

// Añade un evento 'click' al botón de abrir el menú
openMenu.addEventListener("click", () => {
    // Al hacer clic en el botón, se añade la clase 'aside-visible' al 'aside'
    // Esto hace que el menú lateral sea visible
    aside.classList.add("aside-visible");
});

// Añade un evento 'click' al botón de cerrar el menú
closeMenu.addEventListener("click", () => {
    // Al hacer clic en el botón, se elimina la clase 'aside-visible' del 'aside'
    // Esto oculta el menú lateral
    aside.classList.remove("aside-visible");
});
