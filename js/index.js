// === Toggle visibility of a form by ID ===
function toggleForm(formId) {
  // Hide all other forms first
  const allForms = document.querySelectorAll('.form-container');
  allForms.forEach(form => {
    form.style.display = 'none';
    form.classList.remove('active'); // reset animation/visibility
  });

  // Find the target form
  const form = document.getElementById(formId);
  if (!form) {
    console.warn(`⚠️ Form with ID '${formId}' not found.`);
    return;
  }

  // Toggle the target form visibility
  const isHidden = form.style.display === 'none' || form.style.display === '';
  if (isHidden) {
    form.style.display = 'block';
    form.classList.add('active'); // triggers your CSS bubble animation
  } else {
    form.style.display = 'none';
    form.classList.remove('active');
  }
}

// === Wait for DOM content to be fully loaded ===
document.addEventListener("DOMContentLoaded", function () {
  const membership = document.getElementById('membership');
  const paypalContainer = document.getElementById('paypal-button-container');
  const signupButton = document.getElementById('signup-button');

  if (membership && paypalContainer && signupButton) {
    membership.addEventListener('change', function () {
      const isPro = this.value === 'pro';
      paypalContainer.style.display = isPro ? 'block' : 'none';
      signupButton.disabled = isPro; // Disable until PayPal confirmed
    });
  } else {
    console.error('⚠️ Membership or PayPal elements not found in DOM.');
  }
});

// === Simulate PayPal confirmation ===
function confirmPaypal() {
  const signupButton = document.getElementById('signup-button');
  if (signupButton) {
    signupButton.disabled = false;
    alert("✅ PayPal payment confirmed. You can now complete signup.");
  } else {
    console.error('⚠️ Signup button not found.');
  }
}
