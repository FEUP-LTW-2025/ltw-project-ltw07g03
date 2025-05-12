document.querySelectorAll('.service-slider').forEach(slider => {
    const images = slider.querySelectorAll('.slider-image');
    let currentIndex = 0;

    function showImage(index) {
        images.forEach((img, i) => {
            img.classList.toggle('active', i === index);
        });
    }

    slider.querySelector('.slider-prev').addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    });

    slider.querySelector('.slider-next').addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    });
});
