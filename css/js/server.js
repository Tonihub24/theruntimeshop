const express = require('express');
const fs = require('fs');
const path = require('path');
const app = express();
const PORT = 3000;

// Log file paths
const apacheLogPath = '/var/log/apache2/error.log';
const fail2banLogPath = '/var/log/fail2ban.log';

// Serve static files (HTML, CSS, JS)
app.use(express.static(path.join(__dirname, 'public')));

// Apache logs endpoint
app.get('/logs/apache', (req, res) => {
  fs.readFile(apacheLogPath, 'utf8', (err, data) => {
    if (err) return res.status(500).send('Failed to load Apache logs.');
    res.type('text/plain').send(data);
  });
});

// Fail2Ban logs endpoint
app.get('/logs/fail2ban', (req, res) => {
  fs.readFile(fail2banLogPath, 'utf8', (err, data) => {
    if (err) return res.status(500).send('Failed to load Fail2Ban logs.');
    res.type('text/plain').send(data);
  });
});

app.listen(PORT, () => {
  console.log(`✅ Server running at http://localhost:${PORT}`);
});
