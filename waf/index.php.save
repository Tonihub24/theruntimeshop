
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>🛡️ RuntimeShop WAF Dashboard</title>
<style>
body {
  font-family: 'Poppins', sans-serif;
  background-color: #0f0f0f;
  color: #00ffc8;
  margin: 0;
  padding: 20px;
  text-align: center;
}
h1 { color: #31aff8; }
.card {
  background: #1a1a1a;
  border-radius: 10px;
  padding: 20px;
  margin: 20px auto;
  max-width: 800px;
  box-shadow: 0 0 10px #00ffc8;
}
pre {
  text-align: left;
  background: #000;
  padding: 10px;
  border-radius: 8px;
  overflow-x: auto;
  max-height: 400px;
}
</style>
</head>
<body>
  <h1>🛡️ RuntimeShop WAF Dashboard</h1>

  <div class="card">
    <h2>Apache ModSecurity Alerts</h2>
    <pre id="modsec">Loading...</pre>
  </div>

  <div class="card">
    <h2>Fail2Ban Banned IPs</h2>
    <pre id="fail2ban">Loading...</pre>
  </div>
<p id="updated">Loading log data...</p>

  <pre id="logData"></pre>

  <script>
async function fetchLogs() {
  try {
    // === ModSecurity logs ===
    const modsecRes = await fetch('includes/log_reader.php');
    const modsecData = await modsecRes.json();
    document.getElementById('modsec').textContent =
      modsecData.error || modsecData.data || "No data.";

    // === Fail2Ban logs ===
    const f2bRes = await fetch('includes/fail2ban_reader.php');
    const f2bData = await f2bRes.json();

    const fail2banBox = document.getElementById('fail2ban');
    fail2banBox.innerHTML = ''; // Clear old entries

    if (f2bData.error) {
      fail2banBox.textContent = f2bData.error;
    } else if (f2bData.data.length === 0) {
      fail2banBox.textContent = "No banned IPs detected.";
    } else {
      // Header with count
      const count = document.createElement('div');
      count.innerHTML = `<b>Total Banned IPs:</b> ${f2bData.count}`;
      count.style.color = '#00ffc8';
      fail2banBox.appendChild(count);

      // Add each IP with color
      f2bData.data.forEach((entry, index) => {
        const div = document.createElement('div');
        div.textContent = `${entry.time} → ${entry.ip}`;
        // Highlight newest bans red, older fade to gray
        const age = f2bData.data.length - index;
        div.style.color = age < 5 ? '#ff5555' : '#a0a0a0';
        fail2banBox.appendChild(div);
      });
    }

    // Show update time
    const updated = document.getElementById('updated');
    if (updated) {
      updated.textContent = "Last updated: " + new Date().toLocaleTimeString();
    }

  } catch (err) {
    console.error(err);
  }
}

// Initial load + auto-refresh every 10s
fetchLogs();
setInterval(fetchLogs, 10000);
</script>

</body>
</html>
