console.log("main.js loaded");

document.addEventListener("DOMContentLoaded", () => {
  const img = document.getElementById("mainProductImage");
  const zoom = document.getElementById("zoomResult");
  const thumbs = document.querySelectorAll(".thumbnail");
  const viewBtn = document.querySelectorAll(".view-full-btn");

  if (!img || !zoom) return;

  function setImage(src) {
    img.src = src;
    zoom.style.backgroundImage = `url(${src})`;
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

  thumbs.forEach(t => {
    t.addEventListener("click", () => {
      thumbs.forEach(x => x.classList.remove("active"));
      t.classList.add("active");
      setImage(t.dataset.image);
    });
  });

  viewBtns.forEach(btn => {
  btn.addEventListener("click", () => {
    const idx = images.findIndex(src => img.src.includes(src));
    openModal(idx !== -1 ? idx : 0);
  });
});

});
