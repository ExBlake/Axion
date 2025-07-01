document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("video-modal");
    const modalTitle = document.getElementById("video-title");
    const modalDescription = document.getElementById("video-description");
    const modalCloseBtn = document.querySelector(".modal-close");
    const modalPlayer = document.getElementById("video-player");

    const videos = document.querySelectorAll(".video-card");

    videos.forEach(card => {
        card.addEventListener("click", () => {
            const title = card.querySelector(".video-title").textContent;
            const videoUrl = card.getAttribute("data-video-url") || "";
            const description = card.getAttribute("data-description") || "Descripción no disponible.";

            // Llenar contenido del modal
            modalTitle.textContent = title;
            modalDescription.textContent = description;

            modalPlayer.innerHTML = `
                <iframe width="100%" height="315" src="${videoUrl}" 
                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            `;

            modal.classList.add("show");
        });
    });

    modalCloseBtn.addEventListener("click", () => {
        modal.classList.remove("show");
        modalPlayer.innerHTML = "";
    });

    window.addEventListener("click", e => {
        if (e.target === modal) {
            modal.classList.remove("show");
            modalPlayer.innerHTML = "";
        }
    });
});
