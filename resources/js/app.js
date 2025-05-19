import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

// DARK MODE TOGGLE BUTTON
const themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
const themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

// Force dark mode as default if no theme is set
if (!localStorage.getItem("color-theme")) {
    localStorage.setItem("color-theme", "dark");
    document.documentElement.classList.add("dark");
}

// Show correct icon based on theme
if (localStorage.getItem("color-theme") === "dark") {
    document.documentElement.classList.add("dark");
    themeToggleLightIcon?.classList.remove("hidden");
} else {
    document.documentElement.classList.remove("dark");
    themeToggleDarkIcon?.classList.remove("hidden");
}

const themeToggleBtn = document.getElementById("theme-toggle");

themeToggleBtn?.addEventListener("click", function () {
    themeToggleDarkIcon?.classList.toggle("hidden");
    themeToggleLightIcon?.classList.toggle("hidden");

    if (localStorage.getItem("color-theme") === "light") {
        document.documentElement.classList.add("dark");
        localStorage.setItem("color-theme", "dark");
    } else {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("color-theme", "light");
    }
});
