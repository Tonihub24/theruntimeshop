<?php
session_start();
require_once 'runtimeshop_dbconn.php';

// ✅ Redirect to dashboard if already logged in
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
  
/* Inquiry Modal Overlay */
#inquiryModal {
  display: none; /* Hidden by default */
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(247, 245, 245, 0.7); /* dark overlay */
  justify-content: center;
  align-items: center; /* vertically center the modal */
  z-index: 9999;
}

/* The white card/modal */
.modal-card {
  background: #eeeeec;
  border: 2px solid #00ffff;
  border-radius: 10px;
  box-shadow: 0 0 25px rgba(0, 255, 255, 0.3);
  padding: 20px;
  width: 100%;
  max-width: 800px;
  max-height: 85vh;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  position: relative;
  animation: fadeIn 0.4s ease;
}
#inspect-lessons {
  margin-top: -90px;   /* move UP */
  padding-top: 0;
}


/* iframe should fill the modal */
#inquiryFrame {
  width: 100%;
  height: 70vh;
  border: none;
  border-radius: 8px;
}

/* Close Button */
.close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  background: #00ffff;
  color: #0d1117;
  font-size: 24px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
  padding: 4px 8px;
}
.close-btn:hover {
  background: #00cccc;
}
/* Fixed tier section at top */
.tier-levels {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%; /* make full width */
  display: flex;
  justify-content: space-evenly; /* spread buttons evenly */
  align-items: center;
  flex-wrap: nowrap; /* prevent wrapping */
  background: rgba(0, 0, 0, 0.7);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  padding: 12px 0;
  border-bottom: 2px solid #00ffff;
  z-index: 1000;
  box-sizing: border-box;
}


/* Style for each tier button */
.tier-levels button {
  background: linear-gradient(135deg, #00ffff, #0088ff);
  color: #fff;
  font-weight: bold;
  border: none;
  border-radius: 8px;
  padding: 12px 22px;
  min-width: 180px; /* ensures all buttons look consistent */
  cursor: pointer;
  transition: all 0.3s ease;
  white-space: nowrap; /* keep text in one line */
}

.tier-levels button:hover {
  background: linear-gradient(135deg, #31aff8, #0066cc);
  transform: scale(1.05);
}


/* Smooth animation */
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
html, body {
  background: #e3f2fa !important;
  color: #f8f4f4;
  min-height: 300vh;

}

#particles-js {
  position: fixed;
  top: 0;
  left: 0;
  width: 50%;
  height: 100%;
  background: #ffffff;   /* WHITE background */
  z-index: -1;           /* behind everything */
}



</style>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RuntimeShop Login</title>


  <!-- ✅ CSS Files -->
  <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="login_forms/forms.css?v=<?php echo time(); ?>">
  <link rel="icon" type="image/png" href="logos/runtimeshoplogo.png">

  <script>
    function toggleForm(formId) {
      const forms = document.querySelectorAll('.form-container');
      forms.forEach(f => f.classList.add('hidden'));
      document.getElementById(formId).classList.remove('hidden');
    }

    // ✅ PayPal toggle for Pro membership
    function confirmPaypal() {
      alert("Redirecting to PayPal... (simulation)");
      // window.location.href = "https://www.paypal.com"; // enable this when ready
    }

    document.addEventListener("DOMContentLoaded", () => {
      const membership = document.getElementById("membership");
      const paypalContainer = document.getElementById("paypal-button-container");
      if (membership) {
        membership.addEventListener("change", () => {
          paypalContainer.style.display = (membership.value === "pro") ? "block" : "none";
        });
      }
    });
  </script>
</head>

<body>
  <div id="particles-js"></div> <!-- ✅ This goes right here -->





  <!-- Site Logo -->
  <img src="logos/runnlogos666.png" alt="RuntimeShop Logo" class="site-logo">

<!-- 🫧 Two Bubbles --> <div class="bubble-buttons"> <div class="bubble" onclick="toggleForm('login-form')">Login</div> <div class="bubble" onclick="toggleForm('signup-form')">Signup</div>
</div>



 


  <main>
    <!-- Display any errors -->
    <?php if (isset($_GET['error'])): ?>
      <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <div id="auth-forms">
      <!-- Login Form -->
           <div id="login-form" class="form-container">
        <form action="/runtimeshop_login.php" method="post" class="bubble-form">
          <h2></h2>
          <input type="text" id="login-username" name="username" placeholder="Username" required>
          <input type="password" id="login-password" name="pwd" placeholder="Password" required>
          <button type="submit">Login</button>
 <p id="toggle-text">Don’t have an account? <a href="#" onclick="toggleForm('signup-form')">Sign up</a></p>
        </form>
      </div>

      <!-- Signup Form -->
     
      <div id="signup-form" class="form-container hidden">
        <form action="/runtimeshop_signup.php" method="post" class="bubble-form">
          <h2></h2>
          <input type="text" id="signup-username" name="username" placeholder="Username" required>
          <input type="password" id="signup-password" name="pwd" placeholder="Password" required>
          <input type="email" id="signup-email" name="email" placeholder="Email" required>

          <label for="membership">Membership Type</label>
          <select id="membership" name="membership" required>
            <option value="regular">Regular (Free)</option>
            <option value="pro">Pro (Paid)</option>
          </select>

          <!-- Experience Level -->
          <label for="profileType">Experience Level</label>ana
          <select id="profileType" name="profileType" required>
            <option value="">-- Select your level --</option>
            <option value="frontend"> New (Sprout Stacker)</option>
            <option value="stacklearner">📚 Intermediate (Stack Learner)</option>
            <option value="fullstacker">🧱 Experienced (Full Stacker)</option>
          </select>

          <!-- PayPal (hidden until Pro is selected) -->
          <div id="paypal-button-container" style="display: none; margin-top: 10px;">
            <button type="button" onclick="confirmPaypal()" style="padding: 10px; background-color: #31aff8; border: none; border-radius: 5px; font-weight: bold;">
              Welcome Pay with PayPal Below
            </button>
          </div>

          <button type="submit" name="signup-submit" id="signup-button">Signup</button>
          <p>Already have an account? <a href="#" onclick="toggleForm('login-form')">Login</a></p>
        </form>

      </div>
    </div>

<section id="inspect-lessons" style="color: #31aff8;">
  <h2>
    Master scalable CRUD-based web systems aligned with enterprise standards
  </h2>

  <p>
    Learn how to manage and protect modern web applications using CRUD workflows
    and real-time security monitoring.
  </p>

  <p>
    Detect and block malicious activity before deployment and in production — all in real time.
  </p>

  <ul>
    <li>Implement server-side execution flows with controlled data handling</li>
    <li>Use browser developer tools to safely debug, analyze performance, and identify vulnerabilities</li>
    <li>Track performance, network traffic, and suspicious behavior in real time</li>
    <li>Follow the lifecycle: Code Editing → Server Execution → Security Monitoring → Protection Deployment</li>
  </ul>
</section>

<section class="hero">

  <h1>           </h1>
  <p>Interested?</p>
</p>
  <a href="#" id="startLearningBtn" class="btn">Have a look</a>
</section>



  </main>


<section class="Inquiry" style="text-align:center; padding:50px 20px;">
  <h1 style="color:#00ffff;"></h1>
  <p style="color:#8b949e;">Have a vision? We’ll help you build it — from concept to deployment.</p>
  <a href="#" id="inquiryBtn" class="btn" 
     style="background:#00ffff; color:#1764d8; padding:3px 12px; border-radius:5px; font-weight:bold; text-decoration:none;">
     Design Inquire
  </a>
</section>
<!-- Inquiry Modal -->
<div id="inquiryModal">
  <div class="modal-card">
    <button class="close-btn">&times;</button>
    <iframe id="inquiryFrame" src="/projectinquiry.html"></iframe>
  </div>
  </div>



 <script src="js/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  // ---------- Inquiry Modal ----------
  const inquiryBtn = document.getElementById("inquiryBtn");
  const inquiryModal = document.getElementById("inquiryModal");
  const inquiryClose = inquiryModal ? inquiryModal.querySelector(".close-btn") : null;

  if (inquiryBtn && inquiryModal && inquiryClose) {
    inquiryBtn.addEventListener("click", e => {
      e.preventDefault();
      inquiryModal.style.display = "flex";
      document.body.style.overflow = "hidden";
    });
    inquiryClose.addEventListener("click", () => {
      inquiryModal.style.display = "none";
      document.body.style.overflow = "auto";
    });
    window.addEventListener("click", event => {
      if (event.target === inquiryModal) {
        inquiryModal.style.display = "none";
        document.body.style.overflow = "auto";
      }
    });
  }

  // ---------- Learning Modal ----------
  const learningModal = document.getElementById("learningModal");
  const startLearningBtn = document.getElementById("startLearningBtn");
  const learningClose = learningModal ? learningModal.querySelector(".close") : null;

  if (startLearningBtn && learningModal && learningClose) {
    startLearningBtn.addEventListener("click", e => {
      e.preventDefault();
      learningModal.style.display = "flex";
      document.body.style.overflow = "hidden";
    });
    learningClose.addEventListener("click", () => {
      learningModal.style.display = "none";
      document.body.style.overflow = "auto";
    });
    window.addEventListener("click", event => {
      if (event.target === learningModal) {
        learningModal.style.display = "none";
        document.body.style.overflow = "auto";
      }
    });
  }

  // ---------- Login/Signup Form Toggle ----------
  const loginForm = document.querySelector('#login-form form');
  const bubbleButtons = document.querySelector('.bubble-buttons');

  if (loginForm) {
    loginForm.addEventListener('submit', e => {
      e.preventDefault();
      if (bubbleButtons) bubbleButtons.classList.add('hidden');
      document.getElementById('login-form').classList.add('hidden');
      document.getElementById('signup-form').classList.add('hidden');
      setTimeout(() => loginForm.submit(), 500);
    });
  }

  // ---------- Particles.js ----------
  if (window.particlesJS) {
   particlesJS("particles-js", {
  particles: {
    number: { value: 80, density: { enable: true, value_area: 800 } },
    color: { value: "#1f2937" }, /* dark gray */
    shape: { type: "circle" },
    opacity: { value: 0.4, random: true },
    size: { value: 3, random: true },
    line_linked: {
      enable: true,
      distance: 150,
      color: "#60a5fa", /* soft blue */
      opacity: 0.3,
      width: 4
    },
    move: { enable: true, speed: 2 }
  },
  interactivity: {
    events: {
      onhover: { enable: true, mode: "grab" },
      onclick: { enable: true, mode: "push" }
    },
    modes: {
      grab: { distance: 140, line_linked: { opacity: 0.4 } },
      push: { particles_nb: 4 }
    }
  },
  retina_detect: true
});

  }
});
</script>
<!-- Learning Modal -->
<div id="learningModal" class="modal" style="
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.7);
  justify-content: center;
  align-items: center;
  z-index: 9999;
">
  <div class="modal-content" style="
    background: #0d1117;
    border: 2px solid #00ffff;
    border-radius: 10px;
    box-shadow: 0 0 25px rgba(0,255,255,0.3);
    width: 900px;
    max-width: 900px;
    max-height: 70vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    position: relative;
    animation: fadeIn 0.4s ease;
  ">
    <button class="close" style="
      position: absolute;
      top: 10px; right: 15px;
      background: #00ffff;
      color: #0d1117;
      font-size: 24px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
      padding: 4px 8px;
    ">&times;</button>

    <!-- Load your learning content here -->
    <iframe 
      src="/stacklearning.html" 
      title="Stack Learning Path"
      frameborder="0"
      style="width:100%; height:90vh; border:none; border-radius:8px;">
    </iframe>
  </div>
</div>





</body>
</html>
