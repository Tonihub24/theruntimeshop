<?php
// fail2ban_latest.php
header('Content-Type: application/json');

// Path to your Fail2Ban log file (adjust if needed)
$logFile = '/var/log/fail2ban.log';

// Number of recent entries to return
$maxEntries = 10;

if (!file_exists($logFile)) {
    echo json_encode([]);
    exit;
}

// Read the file lines (last 500 lines to keep it light)
$lines = array_slice(file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), -500);

$entries = [];

// Parse relevant lines: look for "Ban" or "Found" or "Unban"
foreach (array_reverse($lines) as $line) {
    if (preg_match('/^(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}),\d+ fail2ban\.\w+ +\[\d+\]: (NOTICE|INFO) +\[apache-malicious-scan\] (Ban|Unban|Found) (\d+\.\d+\.\d+\.\d+)$/', $line, $matches)) {
        $entries[] = [
            'time' => $matches[1],
            'action' => strtolower($matches[3]),  // ban, unban, found
            'ip' => $matches[4]
        ];
        if (count($entries) >= $maxEntries) {
            break;
        }
    }
}

// Return newest first
echo json_encode(array_reverse($entries));
