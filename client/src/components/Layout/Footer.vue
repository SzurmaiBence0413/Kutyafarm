<template>
  <footer class="footer text-light pt-5 pb-3">
    <div class="container">
      <div class="row gy-4">
        <!-- Column 1 -->
        <div class="col-12 col-md-6 col-lg-3">
          <div class="fw-bold fs-5 mb-3">🐶 DogShelter</div>
          <p class="text-secondary">
            Your trusted marketplace for finding and adopting healthy, happy
            puppies from verified breeders.
          </p>
        </div>

        <!-- Column 2 -->
        <div class="col-12 col-md-6 col-lg-3">
          <h5 class="mb-3">Quick Links</h5>
          <ul class="list-unstyled">
            <li class="mb-2">
              <RouterLink to="/" class="footer-link">Home</RouterLink>
            </li>
            <li class="mb-2">
              <RouterLink to="/dogs" class="footer-link"
                >Browse Dogs</RouterLink
              >
            </li>
            <li>
              <RouterLink to="/about" class="footer-link">About Us</RouterLink>
            </li>
          </ul>
        </div>

        <!-- Column 3 -->
        <div class="col-12 col-md-6 col-lg-3">
          <h5 class="mb-3">Resources</h5>
          <ul class="list-unstyled">
            <li class="mb-2">
              <a href="#" class="footer-link">Dog Care Tips</a>
            </li>
            <li class="mb-2">
              <a href="#" class="footer-link">Training Guides</a>
            </li>
            <li class="mb-2"><a href="#" class="footer-link">FAQs</a></li>
            <li class="mb-2">
              <a href="#" class="footer-link">Terms of Service</a>
            </li>
            <li><a href="#" class="footer-link">Privacy Policy</a></li>
          </ul>
        </div>

        <!-- Column 4 -->
        <div class="col-12 col-md-6 col-lg-3">
          <h5 class="mb-3">Contact Us</h5>
          <ul class="list-unstyled text-secondary">
            <li class="mb-2">📧 info@dogsheltert.com</li>
            <li class="mb-2">📞 06 20 123 456</li>
            <li>📍 2347 Bugyi Teleki út 32</li>
          </ul>
        </div>
      </div>

      <hr class="border-secondary my-4" />

      <div class="text-center text-secondary small">
        © 2026 DogShelter. All rights reserved.
      </div>
    </div>
  </footer>
</template>
<style scoped>
.footer {
  background: linear-gradient(to right, #0f1c2e, #0b1726);
  color: #fff;
  padding: 60px 20px 20px;
  font-size: 14px;
}

.footer-container {
  width: 100%;
  padding: 0 60px;
}

.footer-col h4 {
  margin-bottom: 16px;
  font-size: 16px;
}

.footer-col ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-col ul li {
  margin-bottom: 10px;
}

.footer-col a {
  color: #cfd8e3;
  text-decoration: none;
  transition: 0.2s;
}

.footer-col a:hover {
  color: #ffffff;
}

.brand .logo {
  font-weight: bold;
  font-size: 18px;
  margin-bottom: 12px;
}

.brand p {
  color: #cfd8e3;
  line-height: 1.6;
}

.contact li {
  margin-bottom: 10px;
}

.socials {
  margin-top: 15px;
  display: flex;
  gap: 10px;
}

.socials a {
  width: 32px;
  height: 32px;
  background-color: #1c2a3d;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  text-decoration: none;
  color: #fff;
  font-weight: bold;
  transition: 0.2s;
}

.socials a:hover {
  background-color: #ff7a00;
}

.footer-bottom {
  margin-top: 40px;
  text-align: center;
  padding-top: 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  color: #cfd8e3;
  font-size: 13px;
}
</style>