$cacheFile = '/var/www/html/waf/logs/geo_cache.json';
$geoCache  = [];

// Load existing cache if it exists and is readable
if (file_exists($cacheFile) && is_readable($cacheFile)) {
    $geoCache = json_decode(file_get_contents($cacheFile), true);
    if (!is_array($geoCache)) {
        // corrupted or invalid cache, reset it
        $geoCache = [];
    }
}

foreach ($lines as $line) {
    if (preg_match('/Ban\s+([0-9\.]+)/', $line, $m)) {
        $ip = $m[1];

        if (isset($geoCache[$ip])) {
            $geo = $geoCache[$ip];
        } else {
            $url  = "http://ip-api.com/json/" . urlencode($ip);
            $geo  = @json_decode(@file_get_contents($url));
            if ($geo && isset($geo->status) && $geo->status === 'success') {
                $geoCache[$ip] = [
                    'country' => $geo->country,
                    'lat'     => $geo->lat,
                    'lon'     => $geo->lon
                ];
            } else {
                // skip this IP if GeoIP failed
                continue;
            }
        }

        $data[] = [
           "ip"        => $ip,
           "country"   => $geoCache[$ip]['country'],
           "lat"       => $geoCache[$ip]['lat'],
           "lon"       => $geoCache[$ip]['lon'],
           "timestamp" => substr($line, 0, 19)
        ];

        if (count($data) >= 50) {
            break;
        }
    }
}

// Save updated cache
file_put_contents($cacheFile, json_encode($geoCache, JSON_PRETTY_PRINT));
