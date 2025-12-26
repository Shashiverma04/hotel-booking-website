function alert_send(ids,type, msg) {
    const bs_class = (type === "success") ? "alert-success" : "alert-danger";

    // Create the alert element
    const alertBox = document.createElement("div");
    alertBox.className = `alert ${bs_class} alert-dismissible fade show`;
    alertBox.role = "alert";
    alertBox.innerHTML = `
        <strong class="me-3">${msg}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Insert into a container
    const alertContainer = document.getElementById(ids) || document.body;
    alertContainer.prepend(alertBox);

    // Optional: auto-dismiss after a few seconds
    setTimeout(() => {
        alertBox.classList.remove("show");
        alertBox.addEventListener("transitionend", () => alertBox.remove());
    }, 5000);
}
