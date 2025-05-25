const searchServiceInput = document.querySelector("#search-service-input");
const categoryFilter = document.querySelector("#category-filter");
const serviceList = document.querySelector(".service-grid");
const budgetSliderValue = document.querySelector("#budget-value");
const budgetSliderInput = document.querySelector("#slider-service-budget");
const ratingSliderValue = document.querySelector("#rating-value");
const ratingSliderInput = document.querySelector("#slider-service-rating");

async function searchService() {
    if (!serviceList) return;

    const q = searchServiceInput?.value.trim() ?? "";
    const cat = categoryFilter?.value ?? "";
    const budget = budgetSliderInput?.value ?? "";
    const rating = ratingSliderInput?.value ?? "";

    const url = new URL("/api/search_service.php", window.location.origin);
    url.searchParams.set("search", q);
    if (cat) url.searchParams.set("category", cat);
    if (budget) url.searchParams.set("budget", budget);
    if (rating) url.searchParams.set("rating", rating);

    const response = await fetch(url);
    if (!response.ok) return;

    const services = await response.json();
    clearServices();

    if (services.length === 0) {
        serviceList.innerHTML = "<p>No services found.</p>";
        return;
    }

    for (const service of services) {
        insertService(service);
    }
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
    const title = escapeHTML(service.title ?? "Untitled");
    const price = escapeHTML(String(service.price ?? "0"));
    const description = escapeHTML(service.description ?? "");
    const images = service.images ?? [];

    const freelancer = service.freelancer ?? {};
    const freelancerId = freelancer.id ?? 0;
    const freelancerName = escapeHTML(freelancer.name ?? "Unknown");
    const freelancerPic = escapeHTML(freelancer.profilePictureURL ?? "/assets/images/pfps/default.jpeg");

    const rating = service.avgRating ?? 0;
    const ratingText = rating ? `⭐ ${escapeHTML(String(rating.toFixed(1)))} / 5` : "⭐ No ratings yet";

    const hasMultipleImages = images.length > 1;
    const sliderButtons = hasMultipleImages ? `<button class="slider-prev">‹</button><button class="slider-next">›</button>` : "";

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
        initSlider(article.querySelector(".service-slider"));
    }
}

function clearServices() {
    serviceList.innerHTML = "";
}

function escapeHTML(str) {
    if (typeof str !== "string") return "";
    return str.replace(/[&<>"']/g, (match) => ({
        "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;",
    }[match]));
}

const isServicesPage = window.location.pathname === "/pages/services.php";

if (isServicesPage) {
    if (searchServiceInput) {
        searchServiceInput.addEventListener("input", searchService);
    }
    if (categoryFilter) {
        categoryFilter.addEventListener("change", searchService);
    }
    if (budgetSliderInput) {
        budgetSliderInput.addEventListener("change", searchService);
        budgetSliderInput.addEventListener("change", (event) => {
            budgetSliderValue.textContent = event.target.value;
        });
        budgetSliderValue.textContent = budgetSliderInput.value;
    }
    if (ratingSliderInput) {
        ratingSliderInput.addEventListener("change", searchService);
        ratingSliderInput.addEventListener("change", (event) => {
            ratingSliderValue.textContent = event.target.value;
        });
        ratingSliderValue.textContent = ratingSliderInput.value;
    }

    window.addEventListener("DOMContentLoaded", searchService);
}

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
