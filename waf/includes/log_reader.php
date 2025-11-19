<?php
// log_reader.php — returns ModSecurity log data in JSON
header('Content-Type: application/json');

$logPath = '/var/log/apache2/modsec_audit.log'; // adjust path if needed

if (!file_exists($logPath)) {
    echo json_encode(['error' => 'ModSecurity log not found.']);
    exit;
}

$data = file_get_contents($logPath);

// Optionally shorten output (last 2000 chars for performance)
if (strlen($data) > 2000) {
    $data = substr($data, -2000);
}

echo json_encode(['data' => $data]);
?>
