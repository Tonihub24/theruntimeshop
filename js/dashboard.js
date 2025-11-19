document.addEventListener('DOMContentLoaded', function () {
  // === NAV BUTTON: Change "Deploys" link ===
  document.querySelectorAll('.nav-button a').forEach(button => {
    if (button.innerText.trim() === "Deploys") {
      button.href = "Runtimeshoppro.php";
    }
  });

  // === LOGOUT BUTTON FUNCTIONALITY ===
  const logoutBtn = document.getElementById('logout-btn');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', function () {
      window.location.href = 'logout.php';
    });
  }

  // === MODAL FUNCTIONS ===
  window.showModal = () => document.getElementById('defenceModal').style.display = 'block';
  window.hideModal = () => document.getElementById('defenceModal').style.display = 'none';
  window.showRuntimeModal = () => document.getElementById('runtimeModal').style.display = 'block';
  window.hideRuntimeModal = () => document.getElementById('runtimeModal').style.display = 'none';

  // === TECH LOGO TOGGLE ===
  const techLogos = document.querySelector('.left-nav .tech-logos');
  let logosVisible = true;
  if (techLogos) {
    techLogos.classList.add('visible');
    setInterval(() => {
      logosVisible = !logosVisible;
      techLogos.classList.toggle('visible', logosVisible);
    }, 8000);
  }

  const secondTechLogos = document.querySelector(".second-left-tech-logos");
  let secondVisible = true;
  if (secondTechLogos) {
    secondTechLogos.classList.add("visible");
    setInterval(() => {
      secondVisible = !secondVisible;
      secondTechLogos.classList.toggle("visible", secondVisible);
    }, 5000);
  }

  // === CHAT BUTTON SLIDE TOGGLE ===
  const chatBtn = document.getElementById('chat-button-container');
  let chatVisible = false;
  if (chatBtn) {
    chatBtn.classList.remove('slide-visible');
    setInterval(() => {
      chatVisible = !chatVisible;
      chatBtn.classList.toggle('slide-visible', chatVisible);
    }, 5000);
  }

  // === SYSTEM HARDENING HOVER ACCESSIBILITY ===
  const hardeningWrapper = document.querySelector('.system-hardening-wrapper');
  const accessibilityHint = document.querySelector('.system-hardening-wrapper .hover-accessibility');
  if (hardeningWrapper && accessibilityHint) {
    hardeningWrapper.addEventListener('mouseenter', () => accessibilityHint.style.display = 'block');
    hardeningWrapper.addEventListener('mouseleave', () => accessibilityHint.style.display = 'none');
  }

  // === MAP TOGGLE FUNCTION (tab popup) ===
  const mapTabBtn = document.getElementById('map-toggle-btn');
  const mapTab = document.getElementById('map-tab');
  const mapPopup = document.getElementById('map-popup');

  function toggleMapPopup() {
    if (mapPopup) {
      mapPopup.style.display = (mapPopup.style.display === 'none' || mapPopup.style.display === '') ? 'block' : 'none';
    }
  }
  if (mapTabBtn) mapTabBtn.addEventListener('click', toggleMapPopup);
  if (mapTab) mapTab.addEventListener('click', toggleMapPopup);

  // === HOVER POPUP (SPROUT CARD) ===
  const popup = document.getElementById('hover-popup');
  const sproutCard = document.querySelector('.dev-profile-card.badge-sprout');
  if (sproutCard && popup) {
    sproutCard.addEventListener('mouseenter', () => popup.style.display = 'block');
    sproutCard.addEventListener('mouseleave', () => popup.style.display = 'none');
  }

 // === LEFT MAP SHOW/CLOSE FUNCTION ===

  const leftMapBtn = document.getElementById("left-map-btn");
  const mapContainer = document.getElementById("left-map");
  const closeMapBtn = document.getElementById("close-map-btn");

  if (leftMapBtn && mapContainer && closeMapBtn) {
    leftMapBtn.addEventListener("click", () => {
      mapContainer.classList.add("show");
      leftMapBtn.classList.add("hidden"); 
    });

    window.showMapFromSidebar = function(profileType) {
      mapContainer.classList.add("show");
      leftMapBtn.classList.add("hidden");
    };

    closeMapBtn.addEventListener("click", () => {
      mapContainer.classList.remove("show");
      leftMapBtn.classList.remove("hidden");
    });
  } else {
    console.warn("⚠️ Map toggle elements not found.");
  }
});

// Handles lesson expand/collapse
function toggleLesson(el) {
  el.classList.toggle("open");
  const lessonList = el.nextElementSibling;
  if (lessonList && lessonList.classList.contains("lesson-list")) {
    lessonList.classList.toggle("visible");
  }
}
