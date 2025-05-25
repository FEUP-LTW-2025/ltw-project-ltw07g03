const searchServiceInput = document.querySelector('#search-service-input');
const categoryFilter = document.querySelector('#category-filter');
const serviceList = document.querySelector('.service-grid');

const budgetSliderInput = document.querySelector('#slider-service-budget');
const ratingSliderInput = document.querySelector('#slider-service-rating');
const budgetSliderValue = document.querySelector('#budget-value');
const ratingSliderValue = document.querySelector('#rating-value');

const dropdownToggles = document.querySelectorAll('[data-toggle-dropdown]');

function toggleDropdown(button, panelId) {
    document.querySelectorAll('.dropdown-panel').forEach(panel => {
        if (panel.id !== panelId) panel.classList.remove('active'); 
    });
    document.querySelector(`#${panelId}`).classList.toggle('active');
}

dropdownToggles.forEach(button => {
    const panelId = button.dataset.toggleDropdown;
    button.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown(button, panelId.substring(1));
    });
});

document.addEventListener('click', (e) => {
    dropdownToggles.forEach(button => {
        const panel = document.querySelector(button.dataset.toggleDropdown);
        if (!button.contains(e.target) && !panel.contains(e.target)) {
            panel.classList.remove('active');
        }
    });
});

// Initialize sliders and buttons 
function initializeFilters() {
    document.querySelectorAll('.clear-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const dropdown = btn.closest('.dropdown-panel');

            if (dropdown.id === 'price-dropdown') {
                budgetSliderInput.value = 5;
                const rangeValues = dropdown.querySelector('.range-values');
                rangeValues.innerHTML = '<span>5€</span><span>500€</span>';
            } else if (dropdown.id === 'rating-dropdown') {
                ratingSliderInput.value = 0;
                const rangeValues = dropdown.querySelector('.range-values');
                rangeValues.innerHTML = '<span>0 ⭐</span><span>5 ⭐</span>';
            }
            searchService();
            dropdown.classList.remove('active');
        });
    });

    // Apply button functionality 
    document.querySelectorAll('.apply-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            searchService();
            tn.closest('.dropdown-panel').classList.remove('active');
        });
    });

    // Price slider 
    if (budgetSliderInput) {
        budgetSliderInput.addEventListener('input', (event) => {
            const value = event.target.value;
            const dropdown = event.target.closest('.dropdown-panel');
            const rangeValues = dropdown.querySelector('.range-values');
            rangeValues.innerHTML = `<span>5€</span><span>${value}€</span><span>500€</span>`;
        });
    }

    // Rating slider 
    if (ratingSliderInput) {
        ratingSliderInput.addEventListener('input', (event) => {
            const value = event.target.value;
            const dropdown = event.target.closest('.dropdown-panel');
            const rangeValues = dropdown.querySelector('.range-values');
            rangeValues.innerHTML = `<span>0 ⭐</span><span>${value} ⭐</span><span>5 ⭐</span>`;
        });
    }
}

async function searchService() {
    if (!serviceList) return;

    const q = searchServiceInput?.value.trim() ?? '';
    const cat = categoryFilter?.value ?? '';
    const budget = budgetSliderInput?.value ?? '';
    const rating = parseFloat(ratingSliderInput?.value ?? '0');
    

    const url = new URL('../api/search_service.php', window.location);
    url.searchParams.set('search', q);
    if (cat) url.searchParams.set('category', cat);
    if (budget) url.searchParams.set('budget', budget);
    if (rating >= 0) url.searchParams.set('rating', rating.toString());
    

    const response = await fetch(url);
    if (!response.ok) return;

    const services = await response.json();
    clearServices();

    if (services.length === 0) {
        serviceList.innerHTML = '<p>No services found.</p>';
        return;
    }

    const filteredServices = rating > 0
        ? services.filter(service => (service.avgRating ?? 0) >= rating)
        : services;

    for (const service of filteredServices) {
        insertService(service);
    }

}

function clearServices() {
    serviceList.innerHTML = '';
}

function escapeHTML(str) {
    if (typeof str !== 'string') return '';
    return str.replace(/[&<>"']/g, match => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;',
        '"': '&quot;', "'": '&#039;'
    }[match]));
}

 function initSlider(slider) {
    const images = slider.querySelectorAll('.slider-image');
    const prevBtn = slider.querySelector('.slider-prev');
    const nextBtn = slider.querySelector('.slider-next');

    let currentIndex = 0;

    const showImage = (index) => {
        images.forEach((img, i) => {
            img.classList.toggle('active', i === index);
        });
    };

    prevBtn?.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    });

    nextBtn?.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    });
} 

function insertService(service) {
    const serviceId = service.serviceId ?? service.id ?? 0;
    const title = escapeHTML(service.title ?? 'Untitled');
    const price = escapeHTML(String(service.price ?? '0'));
    const description = escapeHTML(service.description ?? '');
    const images = service.images ?? [];

    const freelancer = service.freelancer ?? {};
    const freelancerId = freelancer.id ?? 0;
    const freelancerName = escapeHTML(freelancer.name ?? 'Unknown');
    const freelancerPic = escapeHTML(freelancer.profilePictureURL ?? '/assets/images/pfps/default.jpeg'
    );

    const rating = service.avgRating ?? 0;
    const ratingText = rating
        ? `⭐ ${escapeHTML(String(rating))} / 5`
        : '⭐ No ratings yet';

    const hasMultipleImages = images.length > 1;
    const sliderButtons = hasMultipleImages
        ? `<button class="slider-prev">‹</button><button class="slider-next">›</button>`
        : '';

    const sliderImages = images.map((img, index) => `
        <a href="/pages/service_detail.php?id=${serviceId}">
            <img src="${escapeHTML(img)}" alt="Service image ${index + 1}"
                 class="slider-image${index === 0 ? ' active' : ''}">
        </a>
    `).join('');

    const article = document.createElement('article');
    article.className = 'service-display';
    article.innerHTML = `
    <div class="service-slider" data-service-id="${serviceId}">
      ${sliderButtons}
      <div class="slider-images">
        ${sliderImages}
      </div>
    </div>
    <div class="service-info">
      <h3 class="service-title">${title}</h3>
      <p class="service-price">${price} €</p>
      <p class="service-description">${description}</p>
      <div class="freelancer-info">
        <a href="/pages/user.php?id=${freelancerId}">
          <img src="${freelancerPic}" alt="Freelancer profile" class="freelancer-pic">
          <span class="freelancer-name">${freelancerName}</span>
        </a>
      </div>
      <p class="service-rating">${ratingText}</p>
    </div>
  `;

    serviceList.appendChild(article);

    if (hasMultipleImages) {
        initSlider(article.querySelector('.service-slider'));
    }
}

const isServicesPage = window.location.pathname === '/pages/services.php';

if (isServicesPage) {
    window.addEventListener('DOMContentLoaded', () => {
        if (searchServiceInput) {
        searchServiceInput.addEventListener('input', searchService);
        }
        if (categoryFilter) {
        categoryFilter.addEventListener('change', searchService);
        }

        initializeFilters();

        searchService();
    });
}
