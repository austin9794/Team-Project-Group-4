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
