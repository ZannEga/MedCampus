<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MedCampus - Your University Health Partner</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <header>
    <div class="container">
      <a href="{{ url('/') }}" class="logo">
        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
        MedCampus
      </a>
      <nav>
        <ul>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#location">Location</a></li>
        </ul>
      </nav>
      <div class="auth-buttons">
        <a href="{{ url('/login') }}" class="btn btn-outline">Login</a>
        <a href="{{ url('/register') }}" class="btn btn-primary">Register</a>
      </div>
    </div>
  </header>

  <main>
    <section class="hero" id="about">
      <div class="container">
        <div class="hero-content">
          <span class="badge">Campus Health Excellence</span>
          <h1>Your University<br><span class="highlight">Health Partner</span></h1>
          <p>Dedicated healthcare services for students and faculty. Experience professional medical care, mental health support, and wellness programs right on campus.</p>
          <div class="hero-actions">
            <a href="{{ url('/register') }}" class="btn btn-primary">Book Appointment</a>
            <a href="#services" class="btn btn-outline">Learn More</a>
          </div>
          <div class="social-proof">
            <div class="avatars"><div></div><div></div><div></div></div>
            <span>Joined by over 5,000+ students this semester</span>
          </div>
        </div>
        <div class="hero-image">
          <img src="{{ asset('img/gambar_klinik.png') }}" alt="Clinic Reception">
          <div class="floating-card">
            <div class="floating-card-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div class="floating-card-text">
              <h4>24/7 Support</h4>
              <p>Emergency campus response</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="services" id="services">
      <div class="container">
        <div class="section-header">
          <h2>Comprehensive Care Services</h2>
          <p>Everything you need for your physical and mental well-being while on campus.</p>
        </div>
        <div class="services-grid">
          <article class="service-card">
            <div class="service-icon">
              <svg viewBox="0 0 24 24"><path d="M11 2.05v2.01c-4.96.49-8.94 4.47-9.43 9.43h2.01c.46-3.86 3.56-6.96 7.42-7.42M13 2.05c5.05.5 9.14 4.75 9.45 9.95h-2c-.3-4.1-3.5-7.4-7.45-7.95M12 11a4 4 0 1 0 0 8 4 4 0 0 0 0-8"/></svg>
            </div>
            <h3>General Clinic</h3>
            <p>Primary care, annual check-ups, immunizations, and general health screenings.</p>
            <a href="{{ url('/login') }}" class="service-link">View Schedule &rarr;</a>
          </article>
          <article class="service-card">
            <div class="service-icon">
              <svg viewBox="0 0 24 24"><path d="M12 4c-3 0-5 2-5 5 0 2.5 1.5 4.5 3 6l2 5 2-5c1.5-1.5 3-3.5 3-6 0-3-2-5-5-5z"/></svg>
            </div>
            <h3>Dental Care</h3>
            <p>Professional cleanings, cavity fillings, and oral health consultations for all students.</p>
            <a href="{{ url('/login') }}" class="service-link">Book Session &rarr;</a>
          </article>
          <article class="service-card">
            <div class="service-icon">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
            </div>
            <h3>Pharmacy</h3>
            <p>On-campus pharmacy providing prescription fulfillment, over-the-counter medications, and health advice.</p>
            <a href="{{ url('/login') }}" class="service-link">Order Refill &rarr;</a>
          </article>
        </div>
      </div>
    </section>

    <section class="location" id="location">
      <div class="container">
        <div class="location-wrapper">
          <div class="location-info">
            <h2>Find Us on Campus</h2>
            <p>We are located at the heart of the university for easy access between lectures and dorms.</p>
            <div class="contact-list">
              <div class="contact-item">
                <div class="contact-icon"><svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></div>
                <div class="contact-text"><h4>Main Clinic Location</h4><p>Jl. Mulyorejo Utara No. 201</p></div>
              </div>
              <div class="contact-item">
                <div class="contact-icon"><svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></div>
                <div class="contact-text"><h4>Contact Support</h4><p>+62 8127790926 • campus-health@university.edu</p></div>
              </div>
              <div class="contact-item">
                <div class="contact-icon"><svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg></div>
                <div class="contact-text"><h4>Office Hours</h4><p>Mon-Fri: 8:00 AM - 7:00 PM • Sat: 9:00 AM - 1:00 PM</p></div>
              </div>
            </div>
          </div>
          <div class="location-map">
            <img src="https://placehold.co/600x400/407a68/ffffff?text=Map+Illustration" alt="Campus Map Location">
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="container">
      <div class="footer-top">
        <div class="footer-brand">
          <div class="logo">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
            MedCampus
          </div>
          <p>Providing the highest standard of medical care for the future leaders of our society.</p>
        </div>
        <div class="footer-links">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="#about">About Us</a></li>
            <li><a href="javascript:void(0)" onclick="Toast.show('Medical Staff coming soon.', 'info')">Medical Staff</a></li>
            <li><a href="javascript:void(0)" onclick="Toast.show('Doctor Schedule coming soon.', 'info')">Doctor Schedule</a></li>
            <li><a href="{{ url('/login') }}">Patient Portal</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h4>Services</h4>
          <ul>
            <li><a href="{{ url('/service-guide') }}">General Medicine</a></li>
            <li><a href="{{ url('/service-guide') }}">Counseling Center</a></li>
            <li><a href="{{ url('/service-guide') }}">Dental Clinic</a></li>
            <li><a href="{{ url('/service-guide') }}">Emergency Care</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h4>Support</h4>
          <ul>
            <li><a href="javascript:void(0)" onclick="Toast.show('FAQ coming soon.', 'info')">FAQ</a></li>
            <li><a href="javascript:void(0)" onclick="Toast.show('Terms of Service is not available in the demo.', 'info')">Terms of Service</a></li>
            <li><a href="javascript:void(0)" onclick="Toast.show('Privacy Policy is not available in the demo.', 'info')">Privacy Policy</a></li>
            <li><a href="javascript:void(0)" onclick="Toast.show('Contact Us coming soon.', 'info')">Contact Us</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2026 MedCampus University Health Service. All rights reserved.</p>
        <div class="social-links">
          <a href="javascript:void(0)" onclick="Toast.show('Twitter is not available in the demo.', 'info')">Twitter</a>
          <a href="javascript:void(0)" onclick="Toast.show('Instagram is not available in the demo.', 'info')">Instagram</a>
          <a href="javascript:void(0)" onclick="Toast.show('LinkedIn is not available in the demo.', 'info')">LinkedIn</a>
        </div>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/utils.js') }}"></script>
  <script src="js/guest.js"></script>
</body>
</html>
