<?php
session_start();
// Optionally enforce authentication if needed
// if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
//     http_response_code(403);
//     echo json_encode(['error' => 'Access denied']);
//     exit;
//}

header('Content-Type: application/json');

$logPath   = '/var/log/fail2ban.log';        // Path to Fail2Ban log
$cacheFile = '/var/www/html/waf/logs/geo_cache.json';

if (!file_exists($logPath)) {
    echo json_encode(['error' => 'Fail2Ban log not found.']);
    exit;
}

$data = @file($logPath);
if ($data === false) {
    echo json_encode(['error' => 'Unable to read Fail2Ban log.']);
    exit;
}

// Read only last 100 lines (or adjust number)
$recent = array_slice($data, -100);

// Load or initialize geo‑cache
$geoCache = [];
if (file_exists($cacheFile) && is_readable($cacheFile)) {
    $tmp = @json_decode(file_get_contents($cacheFile), true);
    if (is_array($tmp)) {
        $geoCache = $tmp;
    }
}

$bannedIPs = [];
foreach ($recent as $line) {
    if (preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}).*Ban\s+([\d\.]+)/', $line, $matches)) {
        $time = $matches[1];
        $ip   = $matches[2];

        if (isset($geoCache[$ip])) {
            $geo = $geoCache[$ip];
        } else {
            $url = "http://ip-api.com/json/" . urlencode($ip);
            $geo = @json_decode(@file_get_contents($url));
            if (!$geo || !isset($geo->status) || $geo->status !== 'success') {
                continue;
            }
            // Cache only the needed info
            $geoCache[$ip] = [
                'country' => $geo->country,
                'lat'     => $geo->lat,
                'lon'     => $geo->lon
            ];
        }

        $bannedIPs[] = [
            'ip'      => $ip,
            'time'    => $time,
            'country' => $geoCache[$ip]['country'],
            'lat'     => $geoCache[$ip]['lat'],
            'lon'     => $geoCache[$ip]['lon']
        ];

        if (count($bannedIPs) >= 50) {
            break;
        }
    }
}

// Show most recent first
$bannedIPs = array_reverse($bannedIPs);

$response = [
    'count'        => count($bannedIPs),
    'data'         => $bannedIPs,
    'last_updated' => date('Y-m-d H:i:s')
];

// Save cache (overwrite) — ensure write permission
@file_put_contents($cacheFile, json_encode($geoCache, JSON_PRETTY_PRINT));

echo json_encode($response);
exit;
?>
