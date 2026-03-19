console.log("main.js loaded");

document.addEventListener("DOMContentLoaded", () => {
  const img = document.getElementById("mainProductImage");
  const zoom = document.getElementById("zoomResult");
  const thumbs = document.querySelectorAll(".thumbnail");
  const viewBtns = document.querySelectorAll(".view-full-btn");

  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const closeBtn = document.querySelector(".modal-close");
  const nextBtn = document.querySelector(".modal-nav.next");
  const prevBtn = document.querySelector(".modal-nav.prev");

  if (!img || !zoom) return;

  /* -----------------------------
     IMAGE + ZOOM
  ----------------------------- */

  function setImage(src) {
    img.src = src;
    zoom.style.backgroundImage = `url(${src})`;
    zoom.style.backgroundPosition = "50% 50%";
  }

  setImage(img.src);

  img.addEventListener("mouseenter", () => {
    zoom.style.display = "block";
  });

  img.addEventListener("mouseleave", () => {
    zoom.style.display = "none";
  });

  img.addEventListener("mousemove", e => {
    const rect = img.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    if (x < 0 || y < 0 || x > rect.width || y > rect.height) return;

    const xPct = (x / rect.width) * 100;
    const yPct = (y / rect.height) * 100;

    zoom.style.backgroundPosition = `${xPct}% ${yPct}%`;
  });

  /* -----------------------------
     THUMBNAILS
  ----------------------------- */

  thumbs.forEach((thumb, index) => {
    thumb.addEventListener("click", () => {
      thumbs.forEach(t => t.classList.remove("active"));
      thumb.classList.add("active");
      setImage(thumb.dataset.image);
      currentIndex = index;
    });
  });

  /* -----------------------------
     MODAL STATE
  ----------------------------- */

  let currentIndex = 0;

  function openModalByIndex(index) {
    if (typeof images === "undefined" || images.length === 0) return;

    currentIndex = index;
    modalImg.src = images[currentIndex];
    modal.classList.add("active");
    modal.setAttribute("aria-hidden", "false");
  }

  function closeModal() {
    modal.classList.remove("active");
    modal.setAttribute("aria-hidden", "true");
  }

  function showNext() {
    currentIndex = (currentIndex + 1) % images.length;
    modalImg.src = images[currentIndex];
  }

  function showPrev() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    modalImg.src = images[currentIndex];
  }

  /* -----------------------------
     VIEW FULL IMAGE BUTTON
  ----------------------------- */

  viewBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      if (typeof images === "undefined") return;

      const idx = images.findIndex(src => img.src.includes(src));
      openModalByIndex(idx !== -1 ? idx : 0);
    });
  });

  /* -----------------------------
     MODAL CONTROLS
  ----------------------------- */

  closeBtn?.addEventListener("click", closeModal);

  modal?.addEventListener("click", e => {
    if (e.target === modal) closeModal();
  });

  nextBtn?.addEventListener("click", e => {
    e.stopPropagation();
    showNext();
  });

  prevBtn?.addEventListener("click", e => {
    e.stopPropagation();
    showPrev();
  });

  /* -----------------------------
     KEYBOARD SUPPORT
  ----------------------------- */

  document.addEventListener("keydown", e => {
    if (!modal.classList.contains("active")) return;

    if (e.key === "ArrowRight") showNext();
    if (e.key === "ArrowLeft") showPrev();
    if (e.key === "Escape") closeModal();
  });
});

document.addEventListener("DOMContentLoaded", () => {
    const postcodeInput = document.querySelector("input[name='postcode']");

    if (!postcodeInput) return;

    postcodeInput.addEventListener("input", () => {
        let value = postcodeInput.value.toUpperCase().replace(/\s+/g, '');

        if (value.length > 3) {
            value = value.slice(0, -3) + ' ' + value.slice(-3);
        }

        postcodeInput.value = value;
    });
});

// Fade in when page loads
window.addEventListener("load", () => {
  document.body.classList.add("loaded");
});

const loader = document.getElementById("page-loader");

// Handle link clicks
document.querySelectorAll("a").forEach(link => {

  link.addEventListener("click", function (e) {

    // Ignore special cases
    if (
      this.target === "_blank" ||
      this.href.includes("#") ||
      this.href.startsWith("javascript:")
    ) return;

    // Ignore same-page clicks
    if (this.href === window.location.href) return;

    e.preventDefault();

    loader.classList.add("active");
    document.body.classList.add("fade-out");

    setTimeout(() => {
      window.location = this.href;
    }, 200);
  });

});
