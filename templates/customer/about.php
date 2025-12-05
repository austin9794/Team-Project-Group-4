<?php
$title = 'About Us - Level Up Gaming';
require_once __DIR__ . '/../header.php';
?>

<style>
  .about-hero {
    position: relative;
    overflow: hidden;
    color: white;
    padding: 4rem 2rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .about-hero video {
    position: absolute;
    top: 50%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    transform: translate(-50%, -50%);
    z-index: 0;
    object-fit: cover;
  }
  
  .about-hero::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(94, 53, 242, 0.6);
    z-index: 1;
  }
  
  .about-hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
  }

  .about-section h2 {
    display: inline-block;
    padding: 0.35em 1.2em;
    border: 2.5px solid var(--highlight-color);
    border-radius: 1.5em;
    background: transparent;
    color: inherit;
    margin-bottom: 1.2rem;
    box-sizing: border-box;
  }
  
  .about-hero p {
    font-size: 1.2rem;
    max-width: 600px;
    margin: 0 auto;
    opacity: 0.9;
    position: relative;
    z-index: 2;
  }
  
  .about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 1400px;
    margin: 0 auto;
    gap: 0;
    min-height: 600px;
  }

  .about-text-section {
    padding: 4rem 3rem;
    background: var(--bg-primary);
  }

  .about-image-section {
    position: relative;
    background: url('assets/images/bg2.jpg') center/cover no-repeat;
  }

  .about-image-section::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, var(--bg-primary) 0%, transparent 100%);
  }
  
  .about-section {
    margin-bottom: 3rem;
  }

  @media (max-width: 968px) {
    .about-content {
      grid-template-columns: 1fr;
    }
    
    .about-image-section {
      min-height: 400px;
    }
  }
  
  .about-section h2 {
    font-size: 2rem;
    color: var(--text-primary);
    margin-bottom: 1rem;
    border-bottom: 3px solid var(--highlight-color);
    padding-bottom: 0.5rem;
  }
  
  .about-section p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-secondary);
    margin-bottom: 1rem;
  }
  
  .values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
  }
  
  .value-card {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    box-shadow: var(--shadow);
  }
  
  .value-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--highlight-color);
  }
  
  .value-icon svg {
    width: 48px;
    height: 48px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
  }
  
  .value-card h3 {
    color: var(--highlight-color);
    margin-bottom: 0.5rem;
  }
  
  .team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
  }
  
  .team-member {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    box-shadow: var(--shadow);
  }
  
  .team-member-avatar {
    font-size: 4rem;
    margin-bottom: 1rem;
  }
  
  .team-member h3 {
    color: var(--highlight-color);
    margin-bottom: 0.5rem;
  }
  
  .team-member p {
    color: var(--text-secondary);
    font-size: 0.9rem;
  }
</style>

<!-- About Hero -->
<section class="about-hero">
  <video autoplay loop muted playsinline>
    <source src="<?= BASE_URL ?>assets/images/bg_video.mp4" type="video/mp4">
  </video>
  <h1>About Us</h1>
</section>

<!-- About Content -->
<div class="about-content">
  <div class="about-text-section">
    <!-- Company Story Section -->
    <section class="about-section">
      <h2>Level Up's Story</h2>
      <p>
        As an up-and-coming company in the heart of Birmingham, we strive to provide the 
        best service to our local community and home country. We pride ourselves in partnering with industry-leading 
        manufacturers to provide you with the most affordable and the highest performing hardware 
        to Level Up your gaming experience!
      </p>
      <p>
        We currently only ship to the United Kingdom, but are looking to expand our services to Europe 
        and other countries soon!
      </p>
    </section>

    <!-- Contact Section -->
    <section class="about-section">
      <h2>Want to Get In Touch?</h2>
      <p>
        Contact us for any queries or feedback <a href="index.php?page=contact" style="color: var(--highlight-color); font-weight: bold; text-decoration: underline;">here</a>!
      </p>
      <p style="margin-top: 1rem;">
        For Business inquiries, email us at <strong>Business@LevelUpGaming.com</strong>, or Call us at <strong>+44 12 3456 7890</strong>
      </p>
    </section>
  </div>
  
  <div class="about-image-section"></div>
</div>

<?php include __DIR__ . '/../footer.php'; ?></script>