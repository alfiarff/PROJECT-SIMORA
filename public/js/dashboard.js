
// ✅ Tandai menu aktif berdasarkan URL saat ini
let list = document.querySelectorAll(".navigation li");

function setActiveMenu() {
    const currentPath = window.location.pathname;

    list.forEach((item) => {
        // ✅ Skip logo-item agar tidak ikut ter-highlight
        if (item.classList.contains("logo-item")) return;

        item.classList.remove("hovered");

        const link = item.querySelector("a");
        if (link) {
            const href = link.getAttribute("href");
            if (href && currentPath === href) {
                item.classList.add("hovered");
            }
        }
    });
}

// Jalankan saat halaman load
setActiveMenu();

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
};