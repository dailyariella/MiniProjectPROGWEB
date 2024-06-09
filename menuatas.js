document.addEventListener('DOMContentLoaded', function () {
    const floatingSearch1 = document.getElementById('searchbar');
    const floatingSearch = document.getElementById('searchbar2');

    window.addEventListener('scroll', function () {
        const fs1 = floatingSearch1.getBoundingClientRect();
        if (fs1.bottom <= 0) {
            floatingSearch.style.opacity = '1';
            floatingSearch.style.pointerEvents = 'auto';
            floatingSearch.style.transition = 'opacity 0.2s ease-in-out';
        } else {
            floatingSearch.style.opacity = '0';
            floatingSearch.style.pointerEvents = 'none';
            floatingSearch.style.transition = 'opacity 0.2s ease-in-out';
        }
    });
});
