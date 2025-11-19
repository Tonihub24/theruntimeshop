<?php
header('Content-Type: application/json');

// Run the Fail2Ban command securely
$sshdStatus = shell_exec("sudo fail2ban-client status sshd");
$lines = explode("\n", $sshdStatus);
$blockedIps = [];

foreach ($lines as $line) {
    if (strpos($line, 'Banned IP list:') !== false) {
        $parts = explode(":", $line);
        if (isset($parts[1])) {
            $ips = preg_split('/\s+/', trim($parts[1]));
            $blockedIps = array_filter($ips);
            break;
        }
    }
}

echo json_encode([
    "service" => "sshd",
    "banned_ips" => array_values($blockedIps),
]);
