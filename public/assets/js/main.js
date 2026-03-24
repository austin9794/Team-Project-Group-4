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

  if (loader) {
    loader.classList.remove("active");
  }
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

function showToast(message, type = "success") {
  let container = document.getElementById("toast-container");

  if (!container) {
    container = document.createElement("div");
    container.id = "toast-container";
    document.body.appendChild(container);
  }

  const toast = document.createElement("div");
  toast.className = `toast toast-${type}`;
  toast.innerText = message;

  container.appendChild(toast);

  setTimeout(() => {
    toast.classList.add("fade-out");
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

document.addEventListener("submit", function (e) {
  if (!e.target.classList.contains("add-to-cart-form")) return;

  e.preventDefault();

  const form = e.target;
  const btn = form.querySelector("button");
  const formData = new FormData(form);

  btn.disabled = true;

  fetch("index.php?page=add-to-basket", {
    method: "POST",
    body: formData,
    headers: {
      "X-Requested-With": "XMLHttpRequest"
    }
  })
    .then(res => res.json())
    .then(data => {

      if (!data.success) {
        showToast(data.message || "Error adding to basket", "error");
        return;
      }

      if (data.clamped) {
        showToast("Adjusted to available stock", "error");
      } else {
        showToast("Added to basket");
      }

      // Update basket count
      const basket = document.getElementById("basket-count");
      if (basket) {
        basket.textContent = data.basketCount;
      }

    })
    .catch(() => {
      showToast("Something went wrong", "error");
    })
    .finally(() => {
      btn.disabled = false;
    });
});