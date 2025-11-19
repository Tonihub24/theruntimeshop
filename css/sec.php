<?php
session_start();
$username = $_SESSION['username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Runtime Checklist</title>
  <link rel="stylesheet" href="/css/styles.css">
  <style>
    body { background: #111; color: #0ff; font-family: 'Courier New', monospace; padding: 2rem; }
    h1 { text-align: center; }
    .checklist { max-width: 600px; margin: auto; }
    .item { margin: 1rem 0; }
    .result { margin-top: 2rem; padding: 1rem; border: 2px solid #0ff; border-radius: 8px; background: #000; }
    .btn { background: #0ff; color: #000; border: none; padding: 0.5rem 1rem; font-weight: bold; cursor: pointer; margin-top: 1rem; }
  </style>
</head>
<body>
<button type="button" onclick="runPrecautionaryInspection()" class="btn" style="margin-left: 1rem;">
  Inspect My Runtime Environment
</button>
<button class="btn" onclick="scanSecurityHeaders('theruntimeshop.com')">🔍 Check Security Headers</button>

<div style="padding: 1.5rem; background-color: #111; color: #0ff; border-radius: 8px;">
  <h2>🌐 Runtime Security Scanner</h2>
  <input type="text" id="domainInput" placeholder="Enter domain (e.g. theruntimeshop.com)" 
         style="padding: 0.5rem; width: 70%; font-size: 1rem; border-radius: 4px;">
  
  <br><br>

  <button onclick="scanSecurityHeaders()" style="padding: 0.5rem 1rem; margin-right: 1rem;">🔍 Check Security Headers</button>
  <button onclick="checkSSLLabs()" style="padding: 0.5rem 1rem;">🔐 Run SSL Labs Scan</button>

  <div id="result" style="margin-top: 1.5rem;"></div>
</div>

<script>
async function scanSecurityHeaders() {
  const domain = document.getElementById("domainInput").value.trim();
  if (!domain) return alert("Please enter a valid domain name.");

  const url = `https://securityheaders.com/?q=${domain}&followRedirects=on&hide=on&json`;

  try {
    const response = await fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent(url)}`);
    const data = await response.json();

    let html = "<h3>🛡️ Security Headers Report</h3><ul>";
    html += `<li><strong>Grade:</strong> ${data.grade || 'N/A'}</li>`;
    data.headers && Object.entries(data.headers).forEach(([key, value]) => {
      html += `<li><strong>${key}:</strong> ${value}</li>`;
    });
    html += "</ul>";
    document.getElementById("result").innerHTML = html;
  } catch (err) {
    document.getElementById("result").innerHTML = "<p style='color: orange;'>⚠️ Could not fetch Security Headers scan.</p>";
    console.error(err);
  }
}

async function checkSSLLabs() {
  const domain = document.getElementById("domainInput").value.trim();
  if (!domain) return alert("Please enter a valid domain name.");

  const url = `https://api.ssllabs.com/api/v3/analyze?host=${domain}`;
  document.getElementById("result").innerHTML = "<p>⏳ Running SSL Labs scan... please wait ~1 minute.</p>";

  try {
    const pollSSL = async () => {
      const res = await fetch(url);
      const data = await res.json();
      if (data.status === 'READY') return data;
      if (data.status === 'ERROR') throw new Error("SSL Labs returned an error.");
      await new Promise(resolve => setTimeout(resolve, 5000));
      return await pollSSL();
    };

    const result = await pollSSL();
    const endpoint = result.endpoints[0];

    let html = "<h3>🔐 SSL Labs Report</h3><ul>";
    html += `<li><strong>Grade:</strong> ${endpoint.grade || 'N/A'}</li>`;
    html += `<li><strong>IP:</strong> ${endpoint.ipAddress}</li>`;
    html += `<li><strong>Host:</strong> ${result.host}</li>`;
    html += `<li><strong>Supports TLS 1.3:</strong> ${endpoint.details.tlsVersion === "TLS 1.3" ? "Yes" : "No"}</li>`;
    html += "</ul>";

    document.getElementById("result").innerHTML = html;
  } catch (error) {
    document.getElementById("result").innerHTML = "<p style='color: red;'>❌ SSL scan failed.</p>";
    console.error(error);
  }
}
</script>




<h1>🛠 Runtime Readiness Checklist</h1>
<p style="text-align:center;">Hello, <?php echo htmlspecialchars($username); ?>. Check off what you've completed:</p>

<div class="checklist">
  <form id="runtimeForm">
    <div class="item" title="Connects your domain name to your web server via DNS records.">
      <input type="checkbox" name="item" value="1"> ✅ Domain name registered and DNS configured
    </div>
    <div class="item" title="Ensures secure HTTPS connection between browser and server.">
      <input type="checkbox" name="item" value="1"> ✅ SSL/TLS certificate installed (e.g., ZeroSSL, Let's Encrypt)
    </div>
    <div class="item" title="Uploaded code through VS Code or Git for version control.">
      <input type="checkbox" name="item" value="1"> ✅ Website deployed using VS Code or Git
    </div>
    <div class="item" title="Prevents XSS and SQL injection by cleaning form inputs.">
      <input type="checkbox" name="item" value="1"> ✅ HTML/PHP forms sanitized and validated
    </div>
    <div class="item" title="Protects server from brute-force attacks and restricts open ports.">
      <input type="checkbox" name="item" value="1"> ✅ Fail2Ban, UFW or similar protections in place
    </div>
    <div class="item" title="Secures session cookies using flags like HttpOnly, Secure, SameSite.">
      <input type="checkbox" name="item" value="1"> ✅ Sessions protected using secure cookie flags
    </div>
    <div class="item" title="Ensures disaster recovery by backing up databases.">
      <input type="checkbox" name="item" value="1"> ✅ Database backups (mysqldump or automated)
    </div>
    <div class="item" title="Confirms site passes speed, SEO, and security header audits.">
      <input type="checkbox" name="item" value="1"> ✅ Site passes Lighthouse + SecurityHeader scans
    </div>

    <hr>

    <h3 style="color:#0ff;">🚀 Advanced Production Checklist</h3>

    <div class="item" title="Blocks clickjacking and forces HTTPS using Apache/Nginx headers.">
      🔐 Apache/Nginx security headers set (`X-Frame-Options`, `HSTS`, `Permissions-Policy`)
    </div>
    <div class="item" title="Ensures sensitive files like .env and .git are not accessible on live server.">
      🧱 `.env` / `.git` / `config.php` protected from public access
    </div>
    <div class="item" title="Shows friendly error pages to users, logs real errors privately.">
      🔧 Production error logging enabled, error display turned off
    </div>
    <div class="item" title="Prevents abuse by limiting DB permissions. Avoid root or GRANT ALL.">
      🔑 Database user limited (no `GRANT ALL`, root login disabled)
    </div>
    <div class="item" title="Helps users stay informed when pages are missing or broken.">
      📁 Custom 404, 403, 500 error pages configured
    </div>
    <div class="item" title="Checks for missing pages and JavaScript errors across devices.">
      🧪 Broken links + console errors tested on desktop and mobile
    </div>
    <div class="item" title="Speeds up site by caching assets and serving them from edge servers.">
      📦 CDN (e.g. Cloudflare) and asset caching enabled
    </div>
    <div class="item" title="Validates authentication logic under various user flows.">
      🔄 Forms tested: login, logout, session timeout
    </div>
    <div class="item" title="Removes sensitive Git history and files from production.">
      🧬 Version control hygiene: `.git` not deployed
    </div>

    <button type="button" onclick="checkRuntime()" class="btn">Analyze Readiness</button>
  </form>

  <div id="result" class="result" style="display:none;"></div>
</div>



    <button type="button" onclick="checkRuntime()" class="btn">Analyze Readiness</button>
  </form>

  <div id="result" class="result" style="display:none;"></div>
</div>

<script>
function checkRuntime() {
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  let checked = 0;

  checkboxes.forEach(cb => {
    if (cb.checked) checked++;
  });

  const resultDiv = document.getElementById('result');
  const total = checkboxes.length;
  const percent = Math.round((checked / total) * 100);

  let feedback = `<h3>🔍 Readiness Score: ${percent}%</h3><ul>`;
  if (percent === 100) {
    feedback += `<li>✅ All systems ready. You're runtime strong! 🚀</li>`;
  } else {
    feedback += `<li>❌ You still have ${total - checked} critical runtime tasks to complete.</li>`;
    if (checked < 4) {
      feedback += `<li>⚠️ Consider reviewing <a href="/defencecoding.html" style="color:#0ff;">Defence Coding</a> & <a href="/SystemHardeningpage1.html" style="color:#0ff;">System Hardening</a>.</li>`;
    } else {
      feedback += `<li>🛠 You’re close! Look at <a href="/runtimeshoppro.php" style="color:#0ff;">RuntimeShop Pro</a> for next steps.</li>`;
    }
  }
  feedback += '</ul>';

  resultDiv.innerHTML = feedback;
  resultDiv.style.display = 'block';
}
</script>
<script>
// ========== SECURITY INSPECTION ========== //
function runPrecautionaryInspection() {
  let warnings = [];

  // 1. Check HTTPS
  if (location.protocol !== 'https:') {
    warnings.push("⚠️ You're not using HTTPS. Your connection may be insecure.");
  }

  // 2. Check for open DevTools
  let devtoolsOpen = false;
  const element = new Image();
  Object.defineProperty(element, 'id', {
    get: function () {
      devtoolsOpen = true;
      throw new Error("DevTools detection triggered");
    }
  });
  console.dir(element); // triggers get

  // 3. Inspect all forms (should use POST)
  const forms = document.querySelectorAll('form');
  forms.forEach(form => {
    if (form.method.toLowerCase() !== 'post') {
      warnings.push("⚠️ One of your forms is not using POST. This may expose sensitive data.");
    }
  });

  // 4. Console Log exposure warning
  warnings.push("ℹ️ Avoid logging sensitive data using console.log in production.");

  // Display results
  const resultDiv = document.getElementById('result');
  let html = "<h3>🧪 Precautionary Inspection Report</h3><ul>";
  if (warnings.length === 0 && !devtoolsOpen) {
    html += "<li>✅ All precautionary checks passed. You’re good!</li>";
  } else {
    warnings.forEach(warn => {
      html += `<li>${warn}</li>`;
    });
    if (devtoolsOpen) {
      html += "<li>⚠️ Developer tools appear to be open. Be cautious with exposed JS variables.</li>";
    }
  }
  html += "</ul>";

  resultDiv.innerHTML += html;
  resultDiv.style.display = 'block';
}

// Auto-run inspection
window.onload = function () {
  setTimeout(runPrecautionaryInspection, 2000);
};
</script>
<script>
async function scanSecurityHeaders(domain) {
  const url = `https://securityheaders.com/?q=${domain}&followRedirects=on&hide=on&json`;

  try {
    const response = await fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent(url)}`);
    const data = await response.json();

    let html = "<h3>🛡️ Security Headers Report</h3><ul>";
    html += `<li><strong>Grade:</strong> ${data.grade || 'N/A'}</li>`;
    data.headers && Object.entries(data.headers).forEach(([key, value]) => {
      html += `<li><strong>${key}:</strong> ${value}</li>`;
    });
    html += "</ul>";

    document.getElementById("result").innerHTML += html;
  } catch (err) {
    document.getElementById("result").innerHTML += "<p style='color: orange;'>⚠️ Could not fetch SecurityHeaders scan. Possibly blocked by CORS or rate limit.</p>";
    console.error(err);
  }
}
</script>



</body>
</html>
