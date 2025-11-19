<?php
session_start();

// Check user logged in (adjust if you want)
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}

$logFile = '/var/log/csp-violations.log';
$maxEntries = 50; // max entries to show

// Read the log file lines into an array
if (!file_exists($logFile)) {
    die("Log file not found.");
}

$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (!$lines) {
    $lines = [];
}

// Reverse so newest entries show first
$lines = array_reverse($lines);

// Limit to max entries
$lines = array_slice($lines, 0, $maxEntries);

$reports = [];
foreach ($lines as $line) {
    $json = json_decode($line, true);
    if ($json && isset($json['csp-report'])) {
        $reports[] = $json['csp-report'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>CSP Violation Dashboard</title>
<style>
  body { background: #111; color: #eee; font-family: monospace, monospace; padding: 1rem; }
  h1 { color: #0ff; }
  table { border-collapse: collapse; width: 100%; margin-top: 1rem; }
  th, td { padding: 0.5rem; border: 1px solid #0ff; }
  th { background: #222; }
  tr:nth-child(even) { background: #222; }
  tr:hover { background: #0a0a0a; }
  a { color: #0ff; text-decoration: none; }
</style>
</head>
<body>
<h1>CSP Violation Reports (Last <?= $maxEntries ?>)</h1>
<?php if (count($reports) === 0): ?>
  <p>No violation reports found.</p>
<?php else: ?>
<table>
  <thead>
    <tr>
      <th>Document URI</th>
      <th>Violated Directive</th>
      <th>Blocked URI</th>
      <th>Original Policy</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($reports as $report): ?>
      <tr>
        <td><a href="<?= htmlspecialchars($report['document-uri']) ?>" target="_blank"><?= htmlspecialchars($report['document-uri']) ?></a></td>
        <td><?= htmlspecialchars($report['violated-directive']) ?></td>
        <td><?= htmlspecialchars($report['blocked-uri']) ?></td>
        <td><code><?= htmlspecialchars($report['original-policy']) ?></code></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
</body>
</html>
