const searchServiceInput = document.querySelector('#search-service-input');
const serviceList = document.querySelector('.service-grid');

async function searchService() {
    const response = await fetch('../api/search_service.php?search=' + encodeURIComponent(searchServiceInput.value));
    if (!response.ok) return;

    const services = await response.json();
    clearServices();

    for (const service of services) {
        insertService(service);
    }
}

function insertService(service) {
    const serviceId = service.serviceId ?? service.id ?? 0;
    const title = escapeHTML(service.title ?? 'Untitled');
    const price = escapeHTML(String(service.price ?? '0'));
    const description = escapeHTML(service.description ?? '');
    const image = escapeHTML(service.images?.[0] ?? '/assets/images/pfps/default.jpeg');

    const freelancer = service.freelancer ?? {};
    const freelancerName = escapeHTML(freelancer.name ?? 'Unknown');
    const freelancerId = freelancer.id ?? 0;
    const freelancerPic = escapeHTML(freelancer.profilePictureURL ?? '/assets/images/pfps/default.jpeg');

    const rating = service.avgRating ?? 0;
    const ratingText = rating !== 0 ? `⭐ ${escapeHTML(String(rating))} / 5` : '⭐ No ratings yet';

    const article = document.createElement('article');
    article.className = 'service-display';

    article.innerHTML = `
        <a href="/pages/service_detail.php?id=${serviceId}">
            <img src="${image}" alt="Service image" class="service-image">
        </a>
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
}

function clearServices() {
    serviceList.innerHTML = '';
}

function escapeHTML(str) {
    return str.replace(/[&<>"']/g, function (match) {
        const escape = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        };
        return escape[match];
    });
}

searchServiceInput.addEventListener('input', searchService);
