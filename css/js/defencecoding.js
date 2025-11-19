document.addEventListener("DOMContentLoaded", () => {
  console.log("defencecoding.js loaded");

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.item').forEach(item => {
    observer.observe(item);
  });

  function getRuntimeRelevance(title) {
    const relevanceMap = {
      'Runtime Threats': 'Attacks like remote code injection and live process hijacking happen during runtime execution.',
      'Input Validation': 'Sanitizing input prevents attacks like XSS and SQLi while the app is live.',
      'Session Management': 'Active user sessions need secure handling to prevent hijacking at runtime.',
      'Rate Limiting': 'Stops brute force attacks and abuse in real-time by limiting request volume.',
      'Secure Headers': 'Headers like CSP and HSTS protect your app while it runs in the browser.',
      'File Permissions': 'Loose permissions are a major risk while your server is actively executing code.',
      'WAF Logs / Monitoring': 'Live attack detection depends on runtime log monitoring and firewall rules.',
      'System Hardening': 'Reducing surface area before and during runtime protects against exploitation.',
      'Server Tools (Apache, phpMyAdmin)': 'Your server tools must be secured during runtime to avoid being an attack vector.'
    };
    return relevanceMap[title] || '';
  }

  let hideTimeout;

  document.querySelectorAll('.item').forEach(item => {
    item.addEventListener('click', () => {
      const rawTitle = item.querySelector('h2').innerText;
      const title = rawTitle.replace(/^\d+\.\s*/, '').trim(); // ✅ remove "1. " prefix
      const desc = getRuntimeRelevance(title);

      if (desc) {
        const popup = document.getElementById('runtime-popup');
        document.getElementById('popup-title').innerText = title;
        document.getElementById('popup-description').innerText = desc;
        popup.classList.remove('hidden');

        if (hideTimeout) clearTimeout(hideTimeout);
        hideTimeout = setTimeout(() => {
          popup.classList.add('hidden');
        }, 10000);
      }
    });
  });
});
