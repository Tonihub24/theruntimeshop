$logFile = '/var/log/fail2ban.log'; // or error.log
$lines = file($logFile);
$threats = [];

foreach ($lines as $line) {
  if (strpos($line, 'Ban') !== false) {
    preg_match('/Ban\s(\d+\.\d+\.\d+\.\d+)/', $line, $matches);
    if (isset($matches[1])) {
      $ip = $matches[1];
      // Use geoip or static lookup for now
      $threats[] = [
        'ip' => $ip,
        'country' => 'Unknown',
        'lat' => 20,
        'lon' => 0,
        'timestamp' => date('Y-m-d H:i:s')
      ];
    }
  }
}
echo json_encode($threats);
