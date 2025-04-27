document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function() {
            menuToggle.classList.toggle('active');
            mainNav.classList.toggle('active');
        });
    }
    
    // Alert dismissal
    const alertCloseButtons = document.querySelectorAll('.alert .close-btn');
    
    alertCloseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.parentElement;
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        });
    });
    
    // Add animation classes to elements when they become visible
    const animatedElements = document.querySelectorAll('.hero, .features, .feature-card');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('hero') || entry.target.classList.contains('features')) {
                        entry.target.classList.add('fade-in');
                    } else if (entry.target.classList.contains('feature-card')) {
                        entry.target.classList.add('slide-up-in');
                    }
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        animatedElements.forEach(element => {
            observer.observe(element);
        });
    } else {
        // Fallback for browsers that don't support IntersectionObserver
        animatedElements.forEach(element => {
            if (element.classList.contains('hero') || element.classList.contains('features')) {
                element.classList.add('fade-in');
            } else if (element.classList.contains('feature-card')) {
                element.classList.add('slide-up-in');
            }
        });
    }
});