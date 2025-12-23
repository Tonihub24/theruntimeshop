<?php
session_start();

// 🔐 Require login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);

// 🔁 TEMP: Module states (later you can move this to DB)
$modules = [
    [
        'title' => 'Server Foundations',
        'desc'  => 'How servers, ports, and requests work',
        'status'=> 'COMPLETE'
    ],
    [
        'title' => 'API Routing & HTTP',
        'desc'  => 'GET, POST, PUT, DELETE',
        'status'=> 'COMPLETE'
    ],
    [
        'title' => 'Database Systems',
        'desc'  => 'SQL & NoSQL CRUD',
        'status'=> 'ACTIVE',
        'progress' => 42,
        'url' => '/lessons/database-systems.html'
    ],
    [
        'title' => 'Full CRUD APIs',
        'desc'  => 'Connecting server to database',
        'status'=> 'LOCKED'
    ],
    [
        'title' => 'Authentication',
        'desc'  => 'JWT, hashing, route protection',
        'status'=> 'LOCKED'
    ],
    [
        'title' => 'Deployment & Version Control',
        'desc'  => 'Linux, domains, HTTPS, Git & GitHub',
        'status'=> 'LOCKED'
    ],
    [
        'title' => 'Cyber Defense',
        'desc'  => 'Firewalls, Fail2Ban, backups',
        'status'=> 'LOCKED'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>RuntimeShop Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="/logos/runnlogos666.png">

<style>
body {
  margin:0;
  background:#0d1117;
  color:#e6edf3;
  font-family:Arial, sans-serif;
}

.dashboard {
  max-width:1100px;
  margin:0 auto;
  padding:30px 20px;
}

header {
  text-align:center;
  margin-bottom:40px;
}

header img {
  max-width:140px;
}

.now-learning {
  color:#00ffff;
  margin-top:10px;
}

.logout {
  float:right;
  background:#ff0040;
  color:#fff;
  border:none;
  padding:8px 14px;
  border-radius:6px;
  cursor:pointer;
}

.module {
  background:#111;
  border:2px solid #333;
  padding:20px;
  margin-bottom:18px;
  border-radius:12px;
}

.module.complete {
  border-color:#00ff99;
  box-shadow:0 0 10px #00ff99;
}

.module.active {
  border-color:#00ffff;
  box-shadow:0 0 15px #00ffff;
}

.module.locked {
  opacity:0.45;
}

.status {
  float:right;
  padding:5px 12px;
  border-radius:20px;
  font-size:12px;
  font-weight:bold;
}

.status.COMPLETE { background:#00ff99; color:#000; }
.status.ACTIVE { background:#00ffff; color:#000; }
.status.LOCKED { background:#444; color:#aaa; }

.start {
  display:inline-block;
  margin-top:10px;
  background:#00ffff;
  color:#000;
  padding:10px 16px;
  border-radius:6px;
  font-weight:bold;
  text-decoration:none;
}

.manifesto {
  margin-top:60px;
  padding:30px;
  border-top:2px solid #00ffff;
  color:#8b949e;
  text-align:center;
}
</style>
</head>

<body>

<div class="dashboard">

<header>
  <form method="post" action="logout.php">
    <button class="logout">Logout</button>
  </form>

  <img src="/logos/runnlogos666.png" alt="RuntimeShop Logo">
  <h1>Logged in as: <?= $username ?></h1>
  <p class="now-learning">Now Learning: <strong>Database Systems</strong></p>
</header>

<h2>Your Learning Path</h2>

<?php foreach ($modules as $m): ?>
  <div class="module <?= strtolower($m['status']); ?>">
    <span class="status <?= $m['status']; ?>">
      <?= $m['status']; ?>
    </span>

    <h3><?= $m['title']; ?></h3>
    <p><?= $m['desc']; ?></p>

    <?php if ($m['status'] === 'ACTIVE'): ?>
      <p><strong>Course Progress:</strong> <?= $m['progress']; ?>%</p>
      <a class="start" href="<?= $m['url']; ?>">Start Next Lesson</a>

    <?php elseif ($m['status'] === 'COMPLETE'): ?>
      <p style="color:#00ff99;">✔ Completed</p>

    <?php else: ?>
      <p>🔒 Locked</p>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

<div class="manifesto">
  <h3>⚡ System-Level Education</h3>
  <p>Coding bootcamps don’t teach this.</p>
  <p>Wix & GoDaddy users never learn this.</p>
  <p>Security engineers get paid for this.</p>
  <p><strong>You are not learning pages — you are learning control.</strong></p>
  <p style="color:#00ffff; margin-top:10px;">CRUD State of Mind</p>
</div>

</div>

</body>
</html>
