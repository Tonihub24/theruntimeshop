const express = require('express');
const fs = require('fs');
const readline = require('readline');
const app = express();
const PORT = 3000;

// Utility to read last N lines of a file
async function readLastLines(filePath, maxLines = 10) {
  return new Promise((resolve, reject) => {
    let lines = [];
    const rl = readline.createInterface({
      input: fs.createReadStream(filePath),
      crlfDelay: Infinity
    });

    rl.on('line', (line) => {
      lines.push(line);
      if (lines.length > maxLines) lines.shift(); // keep only last N lines
    });

    rl.on('close', () => resolve(lines));
    rl.on('error', reject);
  });
}

app.get('/logs/apache', async (req, res) => {
  try {
    const apacheLogs = await readLastLines('/var/log/apache2/error.log', 10);
    res.json({ logs: apacheLogs });
  } catch (err) {
    res.status(500).json({ error: 'Failed to read Apache logs' });
  }
});

app.get('/logs/fail2ban', async (req, res) => {
  try {
    const fail2banLogs = await readLastLines('/var/log/fail2ban.log', 10);
    res.json({ logs: fail2banLogs });
  } catch (err) {
    res.status(500).json({ error: 'Failed to read Fail2Ban logs' });
  }
});

app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});
