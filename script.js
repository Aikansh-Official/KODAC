document.addEventListener('DOMContentLoaded', function() {
    // Menu toggle functionality
    const menuButton = document.querySelector('.menu-button');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const mobileMenu = document.querySelector('.mobile-menu');
    let menuOpen = false;

    // Set CSS variable for mobile menu height
    function setMenuHeight() {
        const mobileMenuContent = document.querySelector('.mobile-menu-content');
        if (mobileMenuContent) {
            const height = mobileMenuContent.scrollHeight;
            document.documentElement.style.setProperty('--menu-height', height + 'px');
        }
    }

    setMenuHeight();
    window.addEventListener('resize', setMenuHeight);

    // Toggle menu function
    function toggleMenu() {
        menuOpen = !menuOpen;
        
        if (menuOpen) {
            dropdownMenu.classList.add('active');
            mobileMenu.classList.add('active');
        } else {
            dropdownMenu.classList.remove('active');
            mobileMenu.classList.remove('active');
        }
    }

    // Event listeners
    menuButton.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMenu();
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (menuOpen && !dropdownMenu.contains(e.target) && !mobileMenu.contains(e.target)) {
            toggleMenu();
        }
    });

    // Prevent clicks inside dropdown from closing it
    dropdownMenu.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Animation for body type cards
    const cards = document.querySelectorAll('.body-type-card');
    
    // Add fade-in animation when page loads
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
        }, 100 * (index + 1));
    });

    // Sign out button functionality
    const signOutButton = document.querySelector('.dropdown-button');
    if (signOutButton) {
        signOutButton.addEventListener('click', function() {
            console.log('User signed out');
            // Add actual sign out logic here
        });
    }
});