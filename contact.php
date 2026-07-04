<?php
$pageTitle = 'CONTACT EXAMPLE · Bootstrap v5.3';
$pageDescription = 'Contact Us Page Example';
$pageBrand = 'Contact Example';
include 'header.php';
?>
      <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Get in Touch</h1>
        <p class="fs-5 text-body-secondary">
          Have questions about our pricing, features, or enterprise solutions? We'd love to hear from you. Send us a message and our team will get back to you within 24 hours.
        </p>
      </div>
    </header>

    <main class="my-5">
      <div class="row g-5">
        <div class="col-md-7 col-lg-8">
          <h3 class="mb-4">Send us a Message</h3>
          <form class="needs-validation" novalidate>
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">First name</label>
                <input
                  type="text"
                  class="form-control"
                  id="firstName"
                  placeholder="John"
                  required
                />
              </div>

              <div class="col-sm-6">
                <label for="lastName" class="form-label">Last name</label>
                <input
                  type="text"
                  class="form-control"
                  id="lastName"
                  placeholder="Doe"
                  required
                />
              </div>

              <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  placeholder="you@example.com"
                  required
                />
              </div>

              <div class="col-12">
                <label for="subject" class="form-label">Subject</label>
                <select class="form-select" id="subject" required>
                  <option value="">Choose a topic...</option>
                  <option>General Inquiry</option>
                  <option>Technical Support</option>
                  <option>Billing & Pricing</option>
                  <option>Partnership Opportunities</option>
                </select>
              </div>

              <div class="col-12">
                <label for="message" class="form-label">Message</label>
                <textarea
                  class="form-control"
                  id="message"
                  rows="5"
                  placeholder="How can we help you today?"
                  required
                ></textarea>
              </div>
            </div>

            <hr class="my-4" />

            <button class="w-100 btn btn-bd-primary btn-lg" type="submit">
              Send Message
            </button>
          </form>
        </div>
      </div>
    </main>

<?php include 'footer.php'; ?>
