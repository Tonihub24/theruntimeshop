<?php
// Include database connection
require_once 'runtimeshop_dbconn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Metal Background */
        body {
            --metal-tex: url(https://images.unsplash.com/photo-1501166222995-ff31c7e93cef?crop=entropy&cs=tinysrgb&fm=jpg&ixid=MnwzMjM4NDZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE2NTcyMDc2NzU&ixlib=rb-1.2.1&q=80);
            background: black;
            color: white;
            font-family: system-ui, sans-serif;
            margin: 0;
            padding: 0;
        }

        a {
            color: skyblue;
            font-weight: bold;
        }

        .main {
            margin: 40px auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .metal {
            position: relative;
            margin: 15vh auto 5vh;
            color: transparent;
            font-family: impact, sans-serif;
            font-size: 7vw;
            letter-spacing: 0.05em;
            background-image: var(--metal-tex);
            background-size: cover;
            background-clip: text;
            -webkit-background-clip: text;
        }

        .texture,
        .texture::after {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
        }

        .texture {
            background-image: linear-gradient(to bottom, blue, white 50%, red 65%, white);
            background-attachment: fixed;
            mix-blend-mode: color-dodge;
        }

        .texture::after {
            content: '';
            background-image: var(--metal-tex);
            background-size: cover;
            filter: saturate(0) brightness(0.8) contrast(4);
            mix-blend-mode: multiply;
        }

        /* About Section Styling */
        .about-section {
            max-width: 700px;
            margin: 0 auto 60px;
            padding: 20px;
            background-color: #1c1c1c;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            font-size: 1rem;
            line-height: 1.6;
            color: #f0f0f0;
        }

        .about-section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: skyblue;
        }

        /* Form Styling (if you want to use it later) */
        .form-container {
            display: none;
            max-width: 300px;
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }

        .form-container input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .toggle-btn {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- HEADER WITH METAL TEXT EFFECT -->
    <div class="main">
        <h1 class="metal">
            TheRuntimeShop.com
            <span class="texture"></span>   
        </h1>
    </div>

    <!-- ABOUT US SECTION -->
    <div class="about-section">
    <h2>About Us</h2>
    <p><strong>Who We Are:</strong> TheRuntimeShop is a security-first web development initiative founded by Kione, a backend developer and cloud security advocate based in Harlem, NY. Our mission is to bridge the gap between secure technology and underserved or self-taught developers, especially those just beginning their coding journey.</p>

    <p><strong>What We Do:</strong> We build and deploy secure backend environments using trusted protocols like SSL/TLS, DNSSEC, and SFTP. Our focus is on delivering secure, cloud-ready runtimes to both experienced professionals and curious coders navigating web infrastructure for the first time. Whether launching a project or learning the stack, we equip developers with tools to create safe, scalable solutions.</p>

    <p><strong>Why It Matters:</strong> Understanding your development stack isn't just best practice—it's vital to making confident decisions under pressure, maintaining system integrity, and scaling responsibly. At TheRuntimeShop, we emphasize clear architectural guidance, secure deployment, and hands-on learning to help developers—from hobbyists to professionals—build with both purpose and protection in mind.</p>

    <p>"The Runtime isn't just a technical detail—it's the foundation of application behavior, security enforcement, and system performance. A secure runtime helps prevent vulnerabilities before they reach your users." We hope you'll join our community and be part of shaping a safer, more empowered future for tech.</p>
</div>

</body>
</html>
