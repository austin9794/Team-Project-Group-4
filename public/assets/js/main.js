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

  const thumbnails = document.querySelectorAll(".thumbnail");
  const mainImage = document.getElementById("mainProductImage");

  if (!modal || thumbnails.length === 0) return;

  let currentIndex = 0;
  const images = Array.from(thumbnails).map(t => t.dataset.image);

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

  function showNext() {
    currentIndex = (currentIndex + 1) % images.length;
    modalImg.src = images[currentIndex];
  }

  function showPrev() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    modalImg.src = images[currentIndex];
  }

  thumbnails.forEach((thumb, i) => {
    thumb.addEventListener("click", () => openModal(i));
  });

  mainImage.addEventListener("click", () => openModal(0));

  closeBtn.addEventListener("click", closeModal);
  nextBtn.addEventListener("click", showNext);
  prevBtn.addEventListener("click", showPrev);

  modal.addEventListener("click", e => {
    if (e.target === modal) closeModal();
  });

  document.addEventListener("keydown", e => {
    if (!modal.classList.contains("active")) return;
    if (e.key === "Escape") closeModal();
    if (e.key === "ArrowRight") showNext();
    if (e.key === "ArrowLeft") showPrev();
  });
});
