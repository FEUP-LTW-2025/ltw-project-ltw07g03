const searchServiceInput = document.querySelector('#search-service-input');
const categoryFilter = document.querySelector('#category-filter');
const serviceList = document.querySelector('.service-grid');

const budgetSliderInput = document.querySelector('#slider-service-budget');
const ratingSliderInput = document.querySelector('#slider-service-rating');

const dropdownToggles = document.querySelectorAll('[data-toggle-dropdown]');
const isServicesPage = window.location.pathname === '/pages/services.php';

// Initialize sliders with default values that won't filter out services
const DEFAULT_BUDGET = 500;
const DEFAULT_RATING = 0;

function initializeSliderValues() {
    if (budgetSliderInput) {
        budgetSliderInput.value = DEFAULT_BUDGET;
        updateSliderValue(budgetSliderInput, '€', false);
    }
    if (ratingSliderInput) {
        ratingSliderInput.value = DEFAULT_RATING;
        updateSliderValue(ratingSliderInput, ' ⭐', false);
    }
}

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
                budgetSliderInput.value = DEFAULT_BUDGET;
                updateSliderValue(budgetSliderInput, '€', false);
            } else if (dropdown.id === 'rating-dropdown') {
                ratingSliderInput.value = DEFAULT_RATING;
                updateSliderValue(ratingSliderInput, ' ⭐', false);
            }
            if (isServicesPage) {
                searchService();
            } else {
                filterCategoryServices();
            }
            dropdown.classList.remove('active');
        });
    });

    // Apply button functionality 
    document.querySelectorAll('.apply-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (isServicesPage) {
                searchService();
            } else {
                filterCategoryServices();
            }
            btn.closest('.dropdown-panel').classList.remove('active');
        });
    });

    // Price slider 
    if (budgetSliderInput) {
        budgetSliderInput.addEventListener('input', function() {
            updateSliderValue(this, '€', true);
        });

        budgetSliderInput.addEventListener('mouseup', function() {
            hideCurrentValue(this);
        });

        budgetSliderInput.addEventListener('touchend', function() {
            hideCurrentValue(this);
        });
    }

    // Rating slider 
    if (ratingSliderInput) {
        ratingSliderInput.addEventListener('input', function() {
            updateSliderValue(this, ' ⭐', true);
        });

        ratingSliderInput.addEventListener('mouseup', function() {
            hideCurrentValue(this);
        });

        ratingSliderInput.addEventListener('touchend', function() {
            hideCurrentValue(this);
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.slider-container')) {
            document.querySelectorAll('.current-value').forEach(value => {
                value.classList.remove('visible');
            });
        }
    });
}

function hideCurrentValue(slider) {
    const currentValue = slider.closest('.slider-container').querySelector('.current-value');
    if (currentValue) {
        setTimeout(() => {
            currentValue.classList.remove('visible');
        }, 1000);
    }
}

function updateSliderValue(slider, unit, showValue = true) {
    const currentValue = slider.closest('.slider-container').querySelector('.current-value');
    if (!currentValue) return;
    
    currentValue.textContent = slider.value + unit;
    if (showValue) {
        currentValue.classList.add('visible');
    } else {
        currentValue.classList.remove('visible');
    }
}

function filterCategoryServices() {
    if (!serviceList) return;

    const budget = parseFloat(budgetSliderInput?.value ?? DEFAULT_BUDGET);
    const rating = parseFloat(ratingSliderInput?.value ?? DEFAULT_RATING);
    const searchQuery = searchServiceInput?.value.trim().toLowerCase() ?? '';

    const services = Array.from(serviceList.querySelectorAll('.service-display'));

    services.forEach(service => {
        // Extract price (remove € symbol and parse)
        const priceText = service.querySelector('.service-price')?.textContent ?? '0';
        const price = parseFloat(priceText.replace(/[€\s]/g, ''));
        
        // Extract rating (handle both "X / 5" and "No ratings yet" formats)
        let serviceRating = 0;
        const ratingText = service.querySelector('.service-rating')?.textContent ?? '';
        if (!ratingText.includes('No ratings yet')) {
            const ratingMatch = ratingText.match(/(\d+(\.\d+)?)\s*\/\s*5/);
            if (ratingMatch) {
                serviceRating = parseFloat(ratingMatch[1]);
            }
        }
        
        const title = service.querySelector('.service-title')?.textContent?.toLowerCase() ?? '';
        const description = service.querySelector('.service-description')?.textContent?.toLowerCase() ?? '';

        const matchesPrice = price <= budget;
        const matchesRating = rating === 0 || serviceRating >= rating;
        const matchesSearch = searchQuery === '' || 
            title.includes(searchQuery) || 
            description.includes(searchQuery);

        service.style.display = (matchesPrice && matchesRating && matchesSearch) ? '' : 'none';
    });

    // Show "No services found" message
    let noServicesMessage = serviceList.querySelector('.no-services-message');
    const hasVisibleServices = services.some(service => service.style.display !== 'none');

    if (!hasVisibleServices) {
        if (!noServicesMessage) {
            noServicesMessage = document.createElement('p');
            noServicesMessage.className = 'no-services-message';
            noServicesMessage.textContent = 'No services found.';
            serviceList.appendChild(noServicesMessage);
        }
    } else if (noServicesMessage) {
        noServicesMessage.remove();
    }
}

async function searchService() {
    if (!serviceList) return;

    const q = searchServiceInput?.value.trim() ?? '';
    const cat = categoryFilter?.value ?? '';
    const budget = budgetSliderInput?.value ?? '';
    const rating = parseFloat(ratingSliderInput?.value ?? '0');

    const url = new URL('../api/search_service.php', window.location);
    url.searchParams.set("search", q);
    if (cat) url.searchParams.set("category", cat);
    if (budget) url.searchParams.set("budget", budget);
    if (rating >= 0) url.searchParams.set('rating', rating.toString());

    const response = await fetch(url);
    if (!response.ok) return;

    const services = await response.json();
    clearServices();

    if (services.length === 0) {
        serviceList.innerHTML = "<p>No services found.</p>";
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
    const images = slider.querySelectorAll(".slider-image");
    const prevBtn = slider.querySelector(".slider-prev");
    const nextBtn = slider.querySelector(".slider-next");

    let currentIndex = 0;

    const showImage = (index) => {
        images.forEach((img, i) => {
            img.classList.toggle("active", i === index);
        });
    };

    prevBtn?.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    });

    nextBtn?.addEventListener("click", () => {
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
    const freelancerPic = escapeHTML(freelancer.profilePictureURL ?? '/assets/images/pfps/default.jpeg');

    const rating = service.avgRating ?? 0;
    const ratingText = rating ? `⭐ ${escapeHTML(String(Math.round(rating * 100) / 100))} / 5` : '⭐ No ratings yet';

    const hasMultipleImages = images.length > 1;
    const sliderButtons = hasMultipleImages ? `<button class="slider-prev">‹</button><button class="slider-next">›</button>` : '';

    const sliderImages = images
        .map((img, index) => `
        <a href="/pages/service_detail.php?id=${serviceId}">
            <img src="${escapeHTML(img)}" alt="Service image ${index + 1}"
                 class="slider-image${index === 0 ? " active" : ""}">
        </a>
    `)
        .join("");

    const article = document.createElement("article");
    article.className = "service-display";
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

// Initialize everything when the DOM is ready
window.addEventListener('DOMContentLoaded', () => {
    initializeSliderValues();
    initializeFilters();
    
    if (searchServiceInput) {
        searchServiceInput.addEventListener('input', () => {
            if (isServicesPage) {
                searchService();
            } else {
                filterCategoryServices();
            }
        });
    }
    if (categoryFilter) {
        categoryFilter.addEventListener('change', searchService);
    }

    if (isServicesPage) {
        searchService();
    }
});

function showSnackbar(message, type = "info") {
    const container = document.getElementById("snackbar-container");
    if (!container) return;

    const snackbar = document.createElement("div");
    snackbar.className = `snackbar ${type}`;
    snackbar.textContent = message;

    const closeBtn = document.createElement("button");
    closeBtn.className = "snackbar-close";
    closeBtn.innerHTML = "×";
    closeBtn.onclick = function () {
        removeSnackbar(snackbar);
    };

    snackbar.appendChild(closeBtn);
    container.appendChild(snackbar);

    setTimeout(() => {
        snackbar.classList.add("show");
    }, 100);

    setTimeout(() => {
        removeSnackbar(snackbar);
    }, 5000);
}

function removeSnackbar(snackbar) {
    if (!snackbar.parentNode) return;

    snackbar.classList.remove("show");
    setTimeout(() => {
        if (snackbar.parentNode) {
            snackbar.parentNode.removeChild(snackbar);
        }
    }, 300);
}

