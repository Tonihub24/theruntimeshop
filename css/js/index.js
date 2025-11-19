// === Toggle visibility of a form by ID ===
function toggleForm(formId) {
  // Hide all other forms first
  const allForms = document.querySelectorAll('.form-container');
  allForms.forEach(form => form.classList.remove('active'));

  // Find the target form
  const form = document.getElementById(formId);
  if (!form) {
    console.warn(`Form with ID '${formId}' not found.`);
    return;
  }

  // Toggle active class to show/hide + animate
  if (!form.classList.contains('active')) {
    // Force reflow so animation can restart even if toggled quickly
    form.classList.remove('active');
    void form.offsetWidth; // reflow trick
    form.classList.add('active');
  } else {
    form.classList.remove('active');
  }
}

// === Wait for DOM content to load ===
document.addEventListener("DOMContentLoaded", function () {
  const membership = document.getElementById('membership');
  const paypalContainer = document.getElementById('paypal-button-container');
  const signupButton = document.getElementById('signup-button');

  if (membership && paypalContainer && signupButton) {
    membership.addEventListener('change', function () {
      const isPro = this.value === 'pro';
      paypalContainer.style.display = isPro ? 'block' : 'none';
      signupButton.disabled = isPro; // Disable until PayPal is confirmed
    });
  } else {
    console.error('Membership or related elements not found in DOM.');
  }
});

// === Simulate PayPal confirmation ===
function confirmPaypal() {
  const signupButton = document.getElementById('signup-button');
  if (signupButton) {
    signupButton.disabled = false;
    alert("✅ PayPal payment confirmed. You can now complete signup.");
  } else {
    console.error('Signup button not found.');
  }
}
