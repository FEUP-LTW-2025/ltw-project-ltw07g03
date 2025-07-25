document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".close-purchase-btn").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            const purchaseId = this.dataset.purchaseId;
            const freelancerId = this.dataset.freelancerId;
            const csrfToken = this.dataset.csrfToken;
            const buttonEl = this;

            if (!csrfToken) {
                console.error("CSRF token not found");
                return;
            }

            fetch("/actions/action_close_purchase.php", {
                method: "POST",
                body: new URLSearchParams({
                    purchaseId: purchaseId,
                    freelancerId: freelancerId,
                    csrf_token: csrfToken,
                }),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
                .then(() => {
                    const statusLine = buttonEl
                        .closest(".service-info")
                        .querySelector(".service-delivery");
                    if (statusLine) {
                        statusLine.innerHTML = "Status: closed";
                    }

                    buttonEl.remove();
                })
                .catch((err) => console.error("Error closing purchase:", err));
        });
    });
});
