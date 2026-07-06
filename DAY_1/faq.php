<?php
$pageTitle = 'FAQ EXAMPLE · Bootstrap v5.3';
$pageDescription = 'Frequently Asked Questions';
$pageBrand = 'FAQ Example';
include 'header.php';
?>
      <main class="my-5">
        <h2 class="display-6 text-center mb-4">Frequently Asked Questions</h2>
        <div class="accordion w-75 mx-auto" id="accordionFAQ">
          <div class="accordion-item">
            <h3 class="accordion-header" id="headingOne">
              <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseOne"
                aria-expanded="true"
                aria-controls="collapseOne"
              >
                What is this website used for?
              </button>
            </h3>
            <div
              id="collapseOne"
              class="accordion-collapse collapse show"
              aria-labelledby="headingOne"
              data-bs-parent="#accordionFAQ"
            >
              <div class="accordion-body">
                This is a dummy website built using <strong>Bootstrap 5</strong> to demonstrate responsive layouts, dark/light theme toggling, and clean HTML structure. You can use it as a starting template for your projects!
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="headingTwo">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseTwo"
                aria-expanded="false"
                aria-controls="collapseTwo"
              >
                How do I toggle between light and dark mode?
              </button>
            </h3>
            <div
              id="collapseTwo"
              class="accordion-collapse collapse"
              aria-labelledby="headingTwo"
              data-bs-parent="#accordionFAQ"
            >
              <div class="accordion-body">
                You can toggle the theme using the floating button located at the bottom-right corner of the screen. It allows you to select between Light, Dark, or Auto mode based on your system preferences.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="headingThree">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseThree"
                aria-expanded="false"
                aria-controls="collapseThree"
              >
                Is this template free to use and customize?
              </button>
            </h3>
            <div
              id="collapseThree"
              class="accordion-collapse collapse"
              aria-labelledby="headingThree"
              data-bs-parent="#accordionFAQ"
            >
              <div class="accordion-body">
                Yes! This template uses Bootstrap framework examples which are open-source and completely free to modify, customize, and deploy for commercial or personal use.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="headingFour">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseFour"
                aria-expanded="false"
                aria-controls="collapseFour"
              >
                How can I contact support?
              </button>
            </h3>
            <div
              id="collapseFour"
              class="accordion-collapse collapse"
              aria-labelledby="headingFour"
              data-bs-parent="#accordionFAQ"
            >
              <div class="accordion-body">
                If you have any questions or need technical support, you can navigate to the Support link in the header or check out the contact links provided in the footer below.
              </div>
            </div>
          </div>
        </div>
      </main>

<?php include 'footer.php'; ?>
