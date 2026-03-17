document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.slide');
    const wrapper = document.getElementById('slidesWrapper');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const currentSlideEl = document.getElementById('currentSlide');
    const progressBar = document.getElementById('progressBar');
    
    let currentSlide = 0;
    const totalSlides = slides.length;
    
    // Configurar total en el UI
    document.getElementById('totalSlides').textContent = totalSlides;

    function updateSlides() {
        // Mover el wrapper
        wrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Actualizar clases active
        slides.forEach((slide, index) => {
            if (index === currentSlide) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        // Actualizar indicador
        currentSlideEl.textContent = currentSlide + 1;

        // Actualizar barra de progreso
        const progress = ((currentSlide + 1) / totalSlides) * 100;
        progressBar.style.width = `${progress}%`;

        // Actualizar botones
        prevBtn.disabled = currentSlide === 0;
        nextBtn.disabled = currentSlide === totalSlides - 1;
    }

    prevBtn.addEventListener('click', () => {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlides();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSlides();
        }
    });

    // Teclado
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight' || e.key === ' ' || e.key === 'PageDown') {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                updateSlides();
            }
        } else if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
            if (currentSlide > 0) {
                currentSlide--;
                updateSlides();
            }
        }
    });

    // Soporte para swipe en dispositivos móviles
    let touchStartX = 0;
    let touchEndX = 0;

    document.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    });

    document.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const threshold = 50; // mínima distancia de swipe
        if (touchEndX < touchStartX - threshold) {
            // Swipe a la izquierda (siguiente)
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                updateSlides();
            }
        }
        if (touchEndX > touchStartX + threshold) {
            // Swipe a la derecha (anterior)
            if (currentSlide > 0) {
                currentSlide--;
                updateSlides();
            }
        }
    }

    // Inicializar
    updateSlides();
});
