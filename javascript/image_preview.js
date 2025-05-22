function setupImagePreview(fileInputId, previewContainerId, options = {}) {
    const input = document.getElementById(fileInputId);
    const previewContainer = document.getElementById(previewContainerId);
    const label = options.labelId ? document.getElementById(options.labelId) : null;
    const shape = options.shape || 'circle';

    if (!input || !previewContainer) return;

    if (label) label.style.display = "none"; // Initially hide the label

    if (!input.dataset.listenerAttached) {
        input.addEventListener("change", () => {
            previewContainer.innerHTML = ""; // Clear old previews

            if (input.files.length > 0 && label) {
                label.style.display = "block";
            } else if (label) {
                label.style.display = "none";
            }
            
            [...input.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const wrapper = document.createElement("div");
                    wrapper.classList.add("preview-image-wrapper");

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.classList.add("preview-image");

                    if (shape === 'rectangle') {
                        previewContainer.classList.add("service-preview-container");
                    } else {
                        previewContainer.classList.add("profile-preview-container");
                    }

                    const removeBtn = document.createElement("button");
                    removeBtn.textContent = "x";
                    removeBtn.classList.add("remove-image-btn");

                    removeBtn.addEventListener("click", () => {
                        wrapper.remove();

                        // If there are no more previews left 
                        if (previewContainer.children.length === 0 && label) {
                            input.value = "";
                            label.style.display = "none";
                        }
                    });

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });

        input.dataset.listenerAttached = "true";
    }
}

window.addEventListener("DOMContentLoaded", () => {
    //Profile forms (circle with label)
    setupImagePreview("registerPicture", "profile-preview-container", {
        labelId: "profilePreviewLabel",
        shape: "circle"
    });

    setupImagePreview("editProfilePicture", "profile-preview-container", {
        labelId: "profilePreviewLabel",
        shape: "circle"
    });

    //Service creation form (rectangular, no label)
    setupImagePreview("images", "service-preview-container", {
        shape: "rectangle"
    });
});