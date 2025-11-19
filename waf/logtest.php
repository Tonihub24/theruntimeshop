<?php
$log = '/var/log/fail2ban.log';
if (file_exists($log)) {
    echo "<pre>" . htmlspecialchars(file_get_contents($log)) . "</pre>";
} else {
    echo "Fail2Ban log not found.";
}
?>
