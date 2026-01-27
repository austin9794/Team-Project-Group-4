document.addEventListener("DOMContentLoaded", () => {
  const img = document.getElementById("mainProductImage");
  const zoomResult = document.getElementById("zoomResult");
  const thumbnails = document.querySelectorAll(".thumbnail");

  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const closeBtn = document.querySelector(".modal-close");
  const nextBtn = document.querySelector(".modal-nav.next");
  const prevBtn = document.querySelector(".modal-nav.prev");
  const viewBtn = document.querySelector(".view-full-btn");

  if (!img || !zoomResult) return;

  // -------------------------
  // ZOOM PANEL (Amazon-style)
  // -------------------------
  function setZoomImage(src) {
    img.src = src;
    zoomResult.style.backgroundImage = `url(${src})`;
  }

  setZoomImage(img.src);

  img.addEventListener("mouseenter", () => {
    zoomResult.style.display = "block";
  });

  img.addEventListener("mouseleave", () => {
    zoomResult.style.display = "none";
  });

  img.addEventListener("mousemove", (e) => {
    const rect = img.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    if (x < 0 || y < 0 || x > rect.width || y > rect.height) return;

    const xPercent = (x / rect.width) * 100;
    const yPercent = (y / rect.height) * 100;

    zoomResult.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
  });

  // -------------------------
  // THUMBNAILS (swap image ONLY)
  // -------------------------
  thumbnails.forEach(thumb => {
    thumb.addEventListener("click", () => {
      thumbnails.forEach(t => t.classList.remove("active"));
      thumb.classList.add("active");
      setZoomImage(thumb.dataset.image);
    });

    // Preload
    const preload = new Image();
    preload.src = thumb.dataset.image;
  });

  // -------------------------
  // FULLSCREEN MODAL (button only)
  // -------------------------
  if (modal && modalImg && viewBtn) {
    const images = Array.from(thumbnails).map(t => t.dataset.image);
    let currentIndex = 0;

    function openModal(index) {
      currentIndex = index;
      modalImg.src = images[currentIndex];
      modal.classList.add("active");
      document.body.style.overflow = "hidden";
    }

    function closeModal() {
      modal.classList.remove("active");
      document.body.style.overflow = "";
    }

    viewBtn.addEventListener("click", () => {
      const idx = images.findIndex(src => img.src.includes(src));
      openModal(idx !== -1 ? idx : 0);
    });

    nextBtn?.addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % images.length;
      modalImg.src = images[currentIndex];
    });

    prevBtn?.addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      modalImg.src = images[currentIndex];
    });

    closeBtn?.addEventListener("click", closeModal);

    modal.addEventListener("click", e => {
      if (e.target === modal) closeModal();
    });

    document.addEventListener("keydown", e => {
      if (!modal.classList.contains("active")) return;
      if (e.key === "Escape") closeModal();
      if (e.key === "ArrowRight") nextBtn?.click();
      if (e.key === "ArrowLeft") prevBtn?.click();
    });
  }
});
