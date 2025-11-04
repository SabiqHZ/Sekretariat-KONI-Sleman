// Smooth scroll function
function scrollToSection(id) {
    const section = document.getElementById(id);
    if (section) {
        section.scrollIntoView({
            behavior: "smooth",
            block: "start",
        });
    }
}

// Make scrollToSection available globally
window.scrollToSection = scrollToSection;

// Intersection Observer for scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("visible");
        }
    });
}, observerOptions);

// Initialize animations when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
    // Observe stat cards
    const statCards = document.querySelectorAll(".stat-card");
    statCards.forEach((card) => {
        observer.observe(card);
    });

    // Observe action cards
    const actionCards = document.querySelectorAll(".action-card");
    actionCards.forEach((card) => {
        observer.observe(card);
    });

    // Observe activity items
    const activityItems = document.querySelectorAll(".activity-item");
    activityItems.forEach((item) => {
        observer.observe(item);
    });

    // Add active state to navigation based on scroll position
    const sections = document.querySelectorAll("section[id]");
    const navButtons = document.querySelectorAll("nav .btn");

    window.addEventListener("scroll", () => {
        let current = "";

        sections.forEach((section) => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;

            if (window.pageYOffset >= sectionTop - 200) {
                current = section.getAttribute("id");
            }
        });

        navButtons.forEach((btn) => {
            btn.classList.remove("active");
            if (btn.getAttribute("onclick")?.includes(current)) {
                btn.classList.add("active");
            }
        });
    });

    // Add animation delay to elements
    const animatedElements = document.querySelectorAll(
        ".stat-card, .action-card, .activity-item",
    );
    animatedElements.forEach((el, index) => {
        el.style.animationDelay = `${(index % 3) * 0.2}s`;
    });

    // Counter animation for statistics
    const animateCounter = (element, target) => {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 30);
    };

    // Animate counters when they become visible
    const counterObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (
                    entry.isIntersecting &&
                    !entry.target.classList.contains("animated")
                ) {
                    const target = parseInt(entry.target.textContent);
                    entry.target.textContent = "0";
                    animateCounter(entry.target, target);
                    entry.target.classList.add("animated");
                }
            });
        },
        { threshold: 0.5 },
    );

    // Observe stat numbers
    const statNumbers = document.querySelectorAll(".stat-number");
    statNumbers.forEach((num) => {
        counterObserver.observe(num);
    });
});

// Handle window resize
let resizeTimer;
window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        // Re-calculate positions or animations if needed
        console.log("Window resized");
    }, 250);
});

// Add loading state handler
window.addEventListener("load", () => {
    document.body.classList.add("loaded");
});

// Prevent default anchor behavior for smooth scroll
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = this.getAttribute("href").substring(1);
        scrollToSection(target);
    });
});
// ===================================
// PROFILE DROPDOWN FUNCTIONALITY
// ===================================

document.addEventListener("DOMContentLoaded", function () {
    const profileButton = document.getElementById("profileButton");
    const dropdownMenu = document.getElementById("dropdownMenu");

    if (profileButton && dropdownMenu) {
        // Toggle dropdown when clicking profile button
        profileButton.addEventListener("click", function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle("show");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (e) {
            if (
                !profileButton.contains(e.target) &&
                !dropdownMenu.contains(e.target)
            ) {
                dropdownMenu.classList.remove("show");
            }
        });

        // Close dropdown when pressing Escape key
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape") {
                dropdownMenu.classList.remove("show");
            }
        });

        // Prevent dropdown from closing when clicking inside it
        dropdownMenu.addEventListener("click", function (e) {
            // Allow form submission and links to work
            if (e.target.tagName !== "A" && e.target.tagName !== "BUTTON") {
                e.stopPropagation();
            }
        });
    }
});

// Optional: Add smooth close animation before navigation
document.querySelectorAll(".dropdown-item").forEach((item) => {
    item.addEventListener("click", function (e) {
        const dropdown = document.getElementById("dropdownMenu");
        if (dropdown && !this.closest("form")) {
            // Add a small delay for visual feedback
            dropdown.style.transition = "all 0.2s ease";
        }
    });
});
