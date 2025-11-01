function scrollToSection(id) {
    const section = document.getElementById(id);
    if (section) {
        section.scrollIntoView({
            behavior: "smooth",
        });
    }
}
// ...existing code...
window.scrollToSection = function (id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.scrollIntoView({ behavior: "smooth", block: "start" });
};
// Intersection Observer untuk animasi saat scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = "1";
        }
    });
}, observerOptions);

document.addEventListener("DOMContentLoaded", () => {
    const sectionsToObserve = document.querySelectorAll("#tentang");
    sectionsToObserve.forEach((section) => {
        observer.observe(section);
    });
});
