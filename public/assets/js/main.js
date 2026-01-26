document.addEventListener('DOMContentLoaded', () => {

  const mainImage = document.getElementById('mainProductImage');
  const thumbnails = document.querySelectorAll('.thumbnail');
  const zoomContainer = document.querySelector('.zoom-container');
  const zoomImage = document.querySelector('.zoom-image');

  // Exit if we're not on a product detail page
  if (!mainImage || thumbnails.length === 0) return;

  // Thumbnail switching
  thumbnails.forEach(thumb => {
    thumb.addEventListener('click', () => {
      mainImage.src = thumb.dataset.image;

      thumbnails.forEach(t => t.classList.remove('active'));
      thumb.classList.add('active');
    });
  });

  // Preload images
  thumbnails.forEach(thumb => {
    const img = new Image();
    img.src = thumb.dataset.image;
  });

  // Hover zoom (desktop only)
  if (zoomContainer && zoomImage) {
    zoomContainer.addEventListener('mousemove', e => {
      const rect = zoomContainer.getBoundingClientRect();
      const x = ((e.clientX - rect.left) / rect.width) * 100;
      const y = ((e.clientY - rect.top) / rect.height) * 100;

      zoomImage.style.transformOrigin = `${x}% ${y}%`;
      zoomImage.style.transform = 'scale(1.8)';
    });

    zoomContainer.addEventListener('mouseleave', () => {
      zoomImage.style.transform = 'scale(1)';
      zoomImage.style.transformOrigin = 'center center';
    });
  }

});

document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const closeBtn = document.querySelector(".modal-close");
  const nextBtn = document.querySelector(".modal-nav.next");
  const prevBtn = document.querySelector(".modal-nav.prev");
  const viewBtn = document.querySelector(".view-full-btn");

  const mainImage = document.getElementById("mainProductImage");
  const thumbnails = document.querySelectorAll(".thumbnail");

  // Safety guard
  if (!modal || !modalImg || !mainImage) return;

  // Build image list from thumbnails
  const images = Array.from(thumbnails).map(t => t.dataset.image);
  let currentIndex = 0;

  // --- Helpers ---
  function openModal(index) {
    if (!images.length) return;

    currentIndex = index;
    modalImg.src = images[currentIndex];

    modal.classList.add("active");
    modal.setAttribute("aria-hidden", "false");
    document.body.style.overflow = "hidden";
  }

  function closeModal() {
    modal.classList.remove("active");
    modal.setAttribute("aria-hidden", "true");
    document.body.style.overflow = "";
  }

  function showNext() {
    currentIndex = (currentIndex + 1) % images.length;
    modalImg.src = images[currentIndex];
  }

  function showPrev() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    modalImg.src = images[currentIndex];
  }

  // --- Thumbnail click ---
  thumbnails.forEach((thumb, index) => {
    thumb.addEventListener("click", () => {
      openModal(index);
    });
  });

  // --- View full image button ---
  if (viewBtn) {
    viewBtn.addEventListener("click", () => {
      const currentSrc = mainImage.src;
      const foundIndex = images.findIndex(img => currentSrc.includes(img));
      openModal(foundIndex !== -1 ? foundIndex : 0);
    });
  }

  // --- Modal controls ---
  closeBtn?.addEventListener("click", closeModal);
  nextBtn?.addEventListener("click", showNext);
  prevBtn?.addEventListener("click", showPrev);

  // Click outside image closes modal
  modal.addEventListener("click", e => {
    if (e.target === modal) closeModal();
  });

  // Keyboard support
  document.addEventListener("keydown", e => {
    if (!modal.classList.contains("active")) return;

    if (e.key === "Escape") closeModal();
    if (e.key === "ArrowRight") showNext();
    if (e.key === "ArrowLeft") showPrev();
  });
});
