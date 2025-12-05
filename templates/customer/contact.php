<?php
$title = 'Contact Us - Level Up Gaming';
require_once __DIR__ . '/../header.php';
?>

<style>
  .contact-hero {
    position: relative;
    overflow: hidden;
    color: white;
    padding: 4rem 2rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .contact-hero video {
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
  
  .contact-hero::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(94, 53, 242, 0.6);
    z-index: 1;
  }

  .contact-hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
  }

  .contact-hero p {
    font-size: 1.2rem;
    max-width: 600px;
    margin: 0 auto;
    opacity: 0.9;
    position: relative;
    z-index: 2;
  }

  .contact-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 1400px;
    margin: 0 auto;
    gap: 0;
    min-height: 600px;
  }

  .contact-text-section {
    padding: 4rem 3rem;
    background: var(--bg-primary);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .contact-image-section {
    position: relative;
    background: url('assets/images/bg3.jpg') center/cover no-repeat;
  }

  .contact-image-section::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, var(--bg-primary) 0%, transparent 100%);
  }

  .contact-form {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: var(--shadow);
    width: 100%;
    max-width: 500px;
  }

  .contact-form h2 {
    color: var(--text-primary);
    margin-bottom: 1.5rem;
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-weight: 600;
  }

  .form-group input,
  .form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    background: var(--bg-primary);
    color: var(--text-primary);
    font-size: 1rem;
  }

  .form-group textarea {
    min-height: 150px;
    resize: vertical;
  }

  .submit-btn {
    width: 100%;
    padding: 1rem;
    background: var(--highlight-color);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
  }

  .submit-btn:hover {
    background: var(--highlight-dark);
  }

  .contact-info {
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }

  .info-card {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: var(--shadow);
  }

  .info-card h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .info-card p {
    color: var(--text-secondary);
    line-height: 1.6;
  }

  .location-footer {
    background: var(--bg-secondary);
    padding: 3rem 2rem;
    text-align: center;
  }

  .location-footer h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  .location-footer p {
    color: var(--text-secondary);
    line-height: 1.6;
  }

  @media (max-width: 968px) {
    .contact-content {
      grid-template-columns: 1fr;
    }
    
    .contact-image-section {
      min-height: 400px;
    }
  }
</style>

<!-- Contact Hero -->
<section class="contact-hero">
  <video autoplay loop muted playsinline>
    <source src="<?= BASE_URL ?>assets/images/bg_video.mp4" type="video/mp4">
  </video>
  <div>
    <h1>Contact Us</h1>
    <p>Have questions? Want to leave feedback? We're here to help!</p>
  </div>
</section>

<!-- Contact Content -->
<div class="contact-content">
  <div class="contact-text-section">
    <div class="contact-form">
      <h2>Send Us a Message</h2>
      <form method="POST" action="/Team-Project-Group-4/public/index.php?page=contact-submit">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" required>
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit" class="submit-btn">Send Message</button>
      </form>
    </div>
  </div>
  
  <div class="contact-image-section"></div>
</div>

<?php require_once __DIR__ . '/../footer.php'; ?>