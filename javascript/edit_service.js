document.addEventListener("DOMContentLoaded", function () {
    const editButton = document.getElementById("toggle-edit-btn");
    const saveButton = document.getElementById("toggle-save-btn");

    if (!editButton || !saveButton) {
        return;
    }

    editButton.addEventListener("click", function () {
        editButton.style.display = "none";
        saveButton.style.display = "inline-block";

        document.querySelectorAll(".editable").forEach((el) => {
            if (["P", "H2"].includes(el.tagName)) {
                el.contentEditable = true;
                el.style.border = "1px dashed #ccc";
                el.style.padding = "5px";
                el.dataset.originalText = el.innerText;
            }
        });

        const priceSpan = document.querySelector(".price-value");
        if (priceSpan) {
            priceSpan.contentEditable = true;
            priceSpan.style.border = "1px dashed #ccc";
            priceSpan.style.padding = "5px";
            priceSpan.dataset.originalText = priceSpan.innerText;
        }

        const deliveryParagraph = document.querySelector(".service-detail-delivery");
        if (deliveryParagraph) {
            const match = deliveryParagraph.innerText.match(/(\d+)\s*day[s]?/);
            if (match) {
                const span = document.createElement("span");
                span.contentEditable = true;
                span.classList.add("editable-delivery-days");
                span.style.border = "1px dashed #ccc";
                span.style.padding = "2px";
                span.dataset.originalText = match[1];
                span.innerText = match[1];

                const daySuffix = document.createElement("span");
                daySuffix.classList.add("day-suffix");
                daySuffix.innerText = match[1] == 1 ? " day" : " days";

                deliveryParagraph.innerHTML = `<strong>Delivery Time:</strong> `;
                deliveryParagraph.appendChild(span);
                deliveryParagraph.appendChild(daySuffix);

                span.addEventListener("input", () => {
                const val = parseInt(span.innerText.trim());
                if (!isNaN(val)) {
                    daySuffix.innerText = val === 1 ? " day" : " days";
                }
            });
        }
    }
});

    saveButton.addEventListener("click", function () {
        const deliveryDays = document.querySelector(".editable-delivery-days");
        if (deliveryDays) {
            const value = deliveryDays.innerText.trim();
            if (!/^\d+$/.test(value)) {
                alert("Delivery time must be a whole number.");
                deliveryDays.focus();
                return;
            }
        }

        const priceSpan = document.querySelector(".price-value");
        if (priceSpan) {
            const priceText = priceSpan.innerText.trim();
            if (!/^\d+(\.\d{1,2})?$/.test(priceText)) {
                alert("Price must be a valid number (e.g.: 100 or 99.99).");
                priceSpan.focus();
                return;
            }
        }

        editButton.style.display = "inline-block";
        saveButton.style.display = "none";

        const updatedData = {};

        document.querySelectorAll(".editable").forEach((el) => {
            const field = el.dataset.field;
            if (field) {
                updatedData[field] = el.innerText.trim();
                el.contentEditable = false;
                el.style.border = "";
                el.style.padding = "";
            }
        });

        if (priceSpan) {
            updatedData["price"] = parseFloat(priceSpan.innerText.trim());
            priceSpan.contentEditable = false;
            priceSpan.style.border = "";
            priceSpan.style.padding = "";
        }

        if (deliveryDays) {
            updatedData["deliveryTime"] = parseInt(deliveryDays.innerText.trim());
            deliveryDays.contentEditable = false;
            deliveryDays.style.border = "";
            deliveryDays.style.padding = "";
        }

        updatedData["serviceId"] = document.querySelector(".service-slider").dataset.serviceId;

        console.log(updatedData);

        fetch("/actions/action_update_service.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(updatedData),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log("Server response:", data);
                alert("Service updated successfully!");
            })
            .catch((error) => {
                console.error("Update error:", error);
                alert("Error updating service.");
            });
    });
});
