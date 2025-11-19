<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");



// DB connection
$host = '127.0.0.1';          // Use TCP
$dbname = 'runtimeshop_db';
$username = 'runtimeshop_admin'; 
$password = 'YourStrongPassword123!';  // Replace with your actual password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}

$userProfile = $_SESSION['profileType'] ?? 'sprout';

$stmt = $pdo->prepare("
    SELECT message, created_at 
    FROM admin_messages
    WHERE (audience = :audience OR audience = 'all') AND is_active = 1
    ORDER BY created_at DESC
    LIMIT 3
");
$stmt->execute(['audience' => $userProfile]);
$messages = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css?  
    <family=Sacramento:400" rel="stylesheet">
  
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="/logos/runnlogos666.png">

</head>


<body style="background: white; color: green;">
  <div class="dashboard-wrapper">



<div class="main">
    <img src="/logos/runnlogos666.png" alt="Runtime Logo"  style="max-width: 100%; height: auto; display: block;" />

<!-- Chat Button -->
<div id="chat-button-container">
    <a href="/forum/public" target="_blank" class="neonText">Chat Runtime</a>
</div>

<!-- Redirect fix for Deploy button -->
<script>
    document.querySelectorAll('.nav-button a').forEach(button => {
        if (button.innerText.trim() === "Deploys") {
            button.href = "Runtimeshoppro.php";
        }
    });
</script>

<!-- Main Header -->

<!-- Technology Logos -->
<div class="left-nav">
    <div class="tech-logos">
        <img src="/logos/php.png" alt="PHP" title="PHP" style="max-width: 100%; height: auto; display: block;">
        <img src="/logos/kali.png" alt="Kali" title="Kali Linux"style="max-width: 100%; height: auto; display: block;" />
        <img src="/logos/github.png" alt="GitHub" title="GitHub" class="invert-logo"style="max-width: 100%; height: auto; display: block;" />
    </div>
</div>
<div class="second-left-tech-logos">
    <div class="tech-logos second-tech-logos">
        <img src="/logos/html5.png" alt="HTML5" title="HTML5" class="invert-logo"style="max-width: 100%; height: auto; display: block;" />
        <img src="/logos/filezilla.png" alt="FileZilla" title="FileZilla"style="max-width: 100%; height: auto; display: block;" />
        <img src="/logos/maria.png" alt="MariaDB" title="MariaDB"style="max-width: 100%; height: auto; display: block;" />
    </div>
</div>




<!-- Right Sidebar -->
<div class="right-nav">
    <div class="divider"></div>
    <p class="welcome-text">Welcome <?php echo htmlspecialchars($_SESSION['username']); ?>, to your</p>

    <div id="nav-header">
        <a id="nav-title">DASHBOARD</a>
        <label for="nav-toggle">
            <span id="nav-toggle-burger"></span>
        </label>
    </div>

    <hr>

    <?php
    $profileType = $_SESSION['profileType'] ?? 'sprout';

$profileData = [
    'sprout' => [
        'name' => ' Sprout Stacker',
        'desc' => 'Welcome your new to programming have a look at your dashboard.',
        'class' => 'badge-sprout'
    ],
    'stacklearner' => [
        'name' => '📚 Stack Learner',
        'desc' => 'Always evolving — bridging backend, frontend, and security.',
        'class' => 'badge-stacklearner'
    ],
    'fullstacker' => [
        'name' => '🧱 Full Stacker',
        'desc' => 'Welcome your building secure, full-stack apps with confidence and advice from TheRuntimeShop is here.',
        'class' => 'badge-fullstacker'
    ]
];


    $current = $profileData[$profileType];
    ?>

<div class="dev-profile-card <?php echo $current['class']; ?>" onclick="showMapFromSidebar('<?php echo $profileType; ?>')" style="cursor: pointer;">
  <div class="badge-title"><?php echo $current['name']; ?></div>
  <div class="badge-hover-desc"><?php echo $current['desc']; ?></div>
</div>


    <div id="nav-content">
       <div class="nav-button" id="runtimereadiness">
  <a href="RuntimeReadiness.html" class="flex items-center space-x-2">
    <i class="fas fa-server"></i>
    <span>Runtime Readiness</span>
  </a>
  <div class="hover-accessibility" style="max-width: 280px; font-size: 0.9rem; color: #0ff; line-height: 1.3;">
    A developer’s preflight checklist before pushing live:
    <ul class="tool-list">
      <li>Version Control & Git Sync</li>
      <li>Error Logging Enabled</li>
      <li>Backup & Recovery Plans</li>
      <li>Runtime Threat Monitoring</li>
      <li>CDN / Cache Optimization</li>
      <li>Production DB Access Rules</li>
    </ul>
  </div>
</div>


        <div class="nav-button tooltip-trigger defence-coding-wrapper">
  <a href="/defencecoding.html" class="nav-label" style="color: inherit; text-decoration: none;">
    <i class="fas fa-shield-alt"></i><span>Defence Coding 🖥️</span>
  </a>
  <div class="hover-accessibility" style="max-width: 280px; font-size: 0.9rem; color: #0ff; line-height: 1.3;">
      Real-time monitoring and blocking runtime attacks that bypass your development safeguards.
  </div>
</div>

</div>

 <hr>
    <div class="nav-button tooltip-trigger system-hardening-wrapper">
  <a href="SystemHardeningpage1.html" class="nav-label">
    <i class="fas fa-shield-alt"></i><span>System Hardening</span>
    <span class="tooltip-text">More with Sucuri Docx</span>
  </a>
  <div class="hover-accessibility">
    <a href="https://acsbace.com/reports/684765c86054c225a2f81f1c?brandId=684765ee1f8e2ff11a98fd04&marketing=true" target="_blank" rel="noopener noreferrer">
      View Our Accessibility Compliance Report
    </a>
    <ul class="tool-list">
      <li><a href="https://www.w3.org/WAI/standards-guidelines/wcag/" target="_blank" rel="noopener noreferrer">AccessScan (WCAG Testing)</a></li>
      <li><a href="https://www.immuniweb.com/ssl/" target="_blank" rel="noopener noreferrer">ImmuniWeb (Vulnerability Scanner)</a></li>
      <li><a href="https://www.ssllabs.com/ssltest/" target="_blank" rel="noopener noreferrer">SSL Labs (TLS/SSL Testing)</a></li>
      <li><a href="https://wave.webaim.org/" target="_blank" rel="noopener noreferrer">WAVE Accessibility Tool</a></li>
      <li><a href="https://pagespeed.web.dev/" target="_blank" rel="noopener noreferrer">Lighthouse Audit (Chrome DevTools)</a></li>
    </ul>
  </div>
</div>


        <div class="nav-button tooltip-trigger">
            <i class="fas fa-server"></i><span>Server Management Tools 🛠️</span>
            <div class="hover-accessibility">
                <ul class="tool-list">
                    <li><a href="https://filezilla-project.org/" target="_blank">FileZilla (SFTP/FTPS)</a></li>
                    <li><a href="https://www.digitalocean.com/docs/droplets/how-to/connect-with-ssh/" target="_blank">SSH Connections</a></li>
                    <li><a href="https://www.apache.org/" target="_blank">Apache Config Management</a></li>
                    <li><a href="https://www.phpmyadmin.net/" target="_blank">phpMyAdmin Access</a></li>
                </ul>
            </div>
        </div>

        <hr>



        <div class="nav-button info-nav">
  <i class="fas fa-fire"></i>
  <a href="aboutus.php" style="color: inherit; text-decoration: none;">
    <span>About Us</span>
  </a>
  <span class="tooltip-text">Learn about TheRuntimeShop and our mission</span>
</div>

        <hr>

        <div class="nav-button tooltip-trigger runtimeshop-wrapper">
            <i class="fas fa-gem"></i>
            <a href="runtimeshoppro.php" class="nav-label">RuntimeShop Members Pro</a>
            <span class="tooltip-text">Exclusive Content!</span>
            <div class="hover-accessibility">
                <ul class="tool-list">
                    <li>Cloud Resource Consolidation</li>
                    <li>Cloud Migration & Efficiency</li>
                    <li>Priority Support Access</li>
                    <li>Exclusive Toolkits</li>
                </ul>
            </div>
        </div>

        <hr>


        <div class="nav-button centered-button">
            <form action="https://www.paypal.com/donate" method="post" target="_top">
                <input type="hidden" name="business" value="TDNVX8M5ETASN">
                <input type="hidden" name="no_recurring" value="0">
                <input type="hidden" name="item_name" value="Thank you for helping a community of programmers with dreams">
                <input type="hidden" name="currency_code" value="USD">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" name="submit" alt="Donate with PayPal">
                <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" alt="">
            </form>
        </div>

        <div class="nav-button centered-button" id="logout-btn">
            <i class="fas fa-sign-out-alt"></i><span>Logout</span>
        </div>
    </div>


</div>
<button 
  id="left-map-btn" 
  type="button"
  aria-label="Show map of locations"
  title="Show map of locations"
  aria-controls="left-map"
  aria-expanded="false">
  📍 Show Map
</button>

<div id="left-map" class="map-vertical hidden" hidden>
  <button 
    id="close-map-btn" 
    class="close-map" 
    type="button"
    aria-label="Close map"
    title="Close map">
    ❌ Close
  </button>

  <div class="node" onclick="toggleLesson(this)">🌱 Sprout Stacker</div>
  <div class="lesson-list">
    <a href="filezilla-secure.php">📂 Secure FileZilla Setup</a>
    <a href="fail2ban-basics.php">🚫 Fail2Ban Basics</a>
  </div>

  <div class="line"></div>
  <div class="node" onclick="toggleLesson(this)">🛡️ Defence Coding</div>
  <div class="lesson-list">
    <a href="#">✅ Input Validation</a>
    <a href="#">🔐 Hashing & Auth</a>
    <a href="#">🧼 XSS/Sanitization</a>
    <a href="#">🔍 Secure Logging</a>
  </div>

  <div class="line"></div>
  <div class="node"><a href="production-defense.php">🔥 In-Production Defense</a></div>
  <div class="line"></div>
  <div class="node"><a href="waf-dashboard.php">🧱 WAF Dashboard</a></div>
  <div class="line"></div>
  <div class="node"><a href="post-runtime.php">🧭 Post Runtime Logs</a></div>
</div>






    <footer>
</div>
   


<script>
function toggleLesson(el) {
  document.querySelectorAll('.node').forEach(n => n.classList.remove('open'));
  el.classList.toggle('open');
}

</script>
<script src="js/dashboard.js"></script>
<!-- Floating Popup for Sprout Stack hover -->
<div id="hover-popup" style="display:none; position:fixed; top:50%; left:50%; 
    transform: translate(-50%, -50%);
    background: rgba(0,0,0,0.85); color:#0ff; padding: 1.5rem 2rem; border-radius: 8px;
    box-shadow: 0 0 15px #0ff; z-index: 9999; max-width: 400px; text-align: center; font-size: 1.1rem;
    pointer-events:none;">
 🎉 Congratulations, New Sprout Learner! 🎉
You’ve taken a fantastic first step by putting yourself and your goals first by joining The Runtime Shop.

As a Sprout Stack learner, you will focus on mastering the essentials of Defence Coding — learning HTML, CSS, and PHP syntax, building strong web layouts, and understanding critical concepts like domain and DNS setup, SSL/TLS certificates, and regulatory compliance.

You’ll also become comfortable with modern development tools such as VS Code, Git hooks, and environment management to set a solid foundation for your programming journey.

Our goal is to equip you with the skills to build secure, compliant, and effective websites that can grow with you as a venturist, entrepreneur, or developer — delivering exactly what you and your customers need.

Enjoy the process, keep exploring, and never stop learning!
</div>

</footer>
</body>
</html>
