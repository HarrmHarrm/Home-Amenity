<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Home Amenity</title>

    <!-- ==================== CSS STYLES ==================== -->
    <style>
        :root {
            --green: #00b300;
            --green-dark: #009900;
            --green-light: #e6f9e6;
            --blue: #0088dd;
            --blue-dark: #006daa;
            --blue-light: #e6f4fc;
            --white: #ffffff;
            --gray-50: #f8fafb;
            --gray-100: #f0f4f6;
            --gray-200: #e2e8ec;
            --gray-300: #cbd5dc;
            --gray-400: #94a3b0;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07), 0 2px 4px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.10), 0 4px 10px rgba(0, 0, 0, 0.06);
            --shadow-xl: 0 20px 40px rgba(0, 0, 0, 0.12), 0 8px 16px rgba(0, 0, 0, 0.06);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --font-sans: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, 'Helvetica Neue', Arial, sans-serif;
        }

        /* [ ... all CSS remains exactly the same as your previous file ... ] */
        /* (Keeping it identical, just not repeating here for brevity) */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 16px;
            -webkit-text-size-adjust: 100%;
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-sans);
            background: linear-gradient(160deg, #eef5fb 0%, #f4f8f2 30%, #f9fbfd 60%, #f0f7fc 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
            color: var(--gray-800);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .bg-decoration {
            position: fixed;
            pointer-events: none;
            z-index: 0;
            border-radius: 50%;
            opacity: 0.07;
            filter: blur(60px);
        }

        .bg-decoration.shape-1 {
            width: 420px;
            height: 420px;
            background: var(--blue);
            top: -120px;
            right: -100px;
            animation: floatShape1 18s ease-in-out infinite;
        }

        .bg-decoration.shape-2 {
            width: 350px;
            height: 350px;
            background: var(--green);
            bottom: -100px;
            left: -90px;
            animation: floatShape2 20s ease-in-out infinite;
        }

        .bg-decoration.shape-3 {
            width: 200px;
            height: 200px;
            background: var(--blue);
            top: 50%;
            left: 60%;
            opacity: 0.04;
            filter: blur(80px);
            animation: floatShape3 15s ease-in-out infinite;
        }

        @keyframes floatShape1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(-30px, 40px) scale(1.08); }
            50% { transform: translate(20px, -25px) scale(0.94); }
            75% { transform: translate(-15px, -35px) scale(1.05); }
        }

        @keyframes floatShape2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(25px, -30px) scale(1.06); }
            66% { transform: translate(-20px, 20px) scale(0.93); }
        }

        @keyframes floatShape3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-40px, -20px) scale(1.1); }
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
        }

        .card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            animation: cardEntry 0.6s cubic-bezier(0.22, 0.61, 0.36, 1) both;
        }

        @keyframes cardEntry {
            from { opacity: 0; transform: translateY(30px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .card-header {
            background: linear-gradient(135deg, var(--blue) 0%, #0077c5 60%, #0066b0 100%);
            padding: 32px 28px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -28px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 56px;
            background: var(--white);
            border-radius: 50%;
            opacity: 0.08;
        }

        .card-header .icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            margin-bottom: 14px;
            backdrop-filter: blur(4px);
            border: 2px solid rgba(255, 255, 255, 0.25);
        }

        .card-header .icon-circle svg {
            width: 28px;
            height: 28px;
            fill: white;
        }

        .card-header h1 {
            color: var(--white);
            font-size: 1.55rem;
            font-weight: 700;
            letter-spacing: -0.3px;
            margin: 0;
            line-height: 1.2;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.9rem;
            margin-top: 6px;
            font-weight: 400;
            letter-spacing: 0.1px;
        }

        .card-body {
            padding: 32px 28px 36px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 22px;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.45;
            animation: alertPop 0.35s cubic-bezier(0.22, 0.61, 0.36, 1) both;
        }

        @keyframes alertPop {
            from { opacity: 0; transform: scale(0.94); }
            to { opacity: 1; transform: scale(1); }
        }

        .alert-success {
            background: #e6f9e6;
            border: 1px solid #b3e6b3;
            color: #1a7a1a;
        }

        .alert-success .alert-icon {
            color: var(--green);
            flex-shrink: 0;
            font-size: 1.1rem;
            line-height: 1;
        }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .alert-error .alert-icon {
            color: #dc2626;
            flex-shrink: 0;
            font-size: 1.1rem;
            line-height: 1;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group:last-of-type {
            margin-bottom: 8px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--gray-700);
            margin-bottom: 6px;
            letter-spacing: 0.1px;
            transition: color var(--transition);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            pointer-events: none;
            z-index: 2;
            transition: color var(--transition);
            display: flex;
            align-items: center;
        }

        .input-icon svg {
            width: 18px;
            height: 18px;
        }

        .form-input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            font-size: 0.95rem;
            font-family: var(--font-sans);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            background: var(--gray-50);
            color: var(--gray-800);
            transition: all var(--transition);
            outline: none;
            letter-spacing: 0.1px;
            line-height: 1.4;
        }

        .form-input::placeholder {
            color: var(--gray-400);
            font-weight: 400;
        }

        .form-input:hover {
            border-color: var(--gray-300);
            background: var(--white);
        }

        .form-input:focus {
            border-color: var(--blue);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(0, 136, 221, 0.10);
            outline: none;
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--blue);
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-400);
            padding: 6px 8px;
            z-index: 2;
            border-radius: 6px;
            transition: all var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: var(--gray-600);
            background: var(--gray-100);
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px 20px;
            font-size: 1rem;
            font-weight: 650;
            font-family: var(--font-sans);
            letter-spacing: 0.2px;
            color: var(--white);
            background: linear-gradient(135deg, var(--green) 0%, #00cc00 50%, var(--green-dark) 100%);
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all var(--transition);
            box-shadow: 0 4px 14px rgba(0, 179, 0, 0.30);
            position: relative;
            overflow: hidden;
            margin-top: 10px;
            text-transform: none;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #00c200 0%, #00d900 50%, #00a800 100%);
            box-shadow: 0 6px 20px rgba(0, 179, 0, 0.40);
            transform: translateY(-1px);
        }

        .btn-submit:hover::before { left: 100%; }

        .btn-submit:active {
            transform: translateY(1px) scale(0.985);
            box-shadow: 0 2px 8px rgba(0, 179, 0, 0.30);
            transition: all 0.1s ease;
        }

        .card-footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        .card-footer-text a {
            color: var(--blue);
            text-decoration: none;
            font-weight: 600;
            transition: color var(--transition);
        }

        .card-footer-text a:hover {
            color: var(--blue-dark);
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 18px 0 8px;
            gap: 12px;
            color: var(--gray-400);
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray-200);
        }

        /* ========== RESPONSIVE ========== */
        @media screen and (max-width: 374px) {
            body { padding: 10px; }
            .card-header { padding: 22px 16px 20px; }
            .card-header h1 { font-size: 1.3rem; }
            .card-header .icon-circle { width: 44px; height: 44px; margin-bottom: 10px; }
            .card-header .icon-circle svg { width: 22px; height: 22px; }
            .card-body { padding: 20px 14px 24px; }
            .form-input { padding: 11px 12px 11px 36px; font-size: 0.85rem; }
            .form-label { font-size: 0.78rem; }
            .btn-submit { padding: 12px 16px; font-size: 0.9rem; }
            .input-icon { left: 10px; }
            .input-icon svg { width: 15px; height: 15px; }
            .alert { font-size: 0.8rem; padding: 10px 12px; }
        }

        @media screen and (min-width: 375px) and (max-width: 479px) {
            body { padding: 14px; }
            .card-header { padding: 26px 20px 24px; }
            .card-header h1 { font-size: 1.4rem; }
            .card-body { padding: 24px 18px 28px; }
            .form-input { padding: 12px 12px 12px 38px; font-size: 0.9rem; }
            .btn-submit { padding: 13px 18px; font-size: 0.95rem; }
        }

        @media screen and (min-width: 480px) and (max-width: 639px) {
            body { padding: 18px; }
            .card-header { padding: 30px 24px 26px; }
            .card-body { padding: 28px 24px 32px; }
        }

        @media screen and (min-width: 640px) and (max-width: 1023px) {
            body { padding: 30px; }
            .page-wrapper { max-width: 500px; }
            .card-header { padding: 36px 32px 30px; }
            .card-header h1 { font-size: 1.6rem; }
            .card-body { padding: 34px 32px 38px; }
            .form-input { padding: 14px 16px 14px 44px; font-size: 0.95rem; }
            .btn-submit { padding: 15px 22px; font-size: 1rem; }
        }

        @media screen and (min-width: 1024px) {
            body { padding: 40px; }
            .page-wrapper { max-width: 500px; }
            .card { border-radius: var(--radius-xl); box-shadow: var(--shadow-xl); transition: box-shadow 0.4s ease, transform 0.4s ease; }
            .card:hover { box-shadow: 0 28px 56px rgba(0, 0, 0, 0.14), 0 12px 24px rgba(0, 0, 0, 0.07); transform: translateY(-2px); }
            .card-header { padding: 38px 34px 32px; }
            .card-header h1 { font-size: 1.7rem; }
            .card-body { padding: 36px 34px 40px; }
            .form-input { padding: 15px 16px 15px 46px; font-size: 0.95rem; border-radius: var(--radius-md); }
            .btn-submit { padding: 15px 24px; font-size: 1.02rem; border-radius: var(--radius-md); }
            .form-group { margin-bottom: 22px; }
        }

        @media screen and (min-width: 1400px) {
            .page-wrapper { max-width: 520px; }
            .card-header { padding: 42px 38px 34px; }
            .card-body { padding: 40px 38px 44px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>

    <div class="bg-decoration shape-1"></div>
    <div class="bg-decoration shape-2"></div>
    <div class="bg-decoration shape-3"></div>

    <div class="page-wrapper">
        <div class="card">
            <div class="card-header">
                <div class="icon-circle">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v1.2c0 1.3 1.1 2.4 2.4 2.4h14.4c1.3 0 2.4-1.1 2.4-2.4v-1.2c0-3.2-6.4-4.8-9.6-4.8z" fill="white" />
                    </svg>
                </div>
                <h1>Welcome Back</h1>
                <p>Sign in to your Home Amenity account</p>
            </div>

            <div class="card-body">
                <?php
                // ==================== PHP BACKEND (FIXED) ====================
                $host = "localhost";
                $user = "root";
                $pass = 'Harrm$1004';
                $db   = "homeamenity";
                $port = 3307;

                $message     = '';
                $messageType = '';

                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $name        = trim($_POST['name'] ?? '');
                    $email_phone = trim($_POST['email_phone'] ?? '');
                    $password    = $_POST['password'] ?? '';

                    $errors = [];

                    if (empty($name)) {
                        $errors[] = "Please enter your full name.";
                    } elseif (strlen($name) < 2) {
                        $errors[] = "Name must be at least 2 characters long.";
                    } elseif (strlen($name) > 100) {
                        $errors[] = "Name must not exceed 100 characters.";
                    }

                    if (empty($email_phone)) {
                        $errors[] = "Please enter your email address or phone number.";
                    } else {
                        $isEmail = filter_var($email_phone, FILTER_VALIDATE_EMAIL);
                        $isPhone = preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $email_phone);
                        if (!$isEmail && !$isPhone) {
                            $errors[] = "Please enter a valid email address or phone number.";
                        }
                    }

                    if (empty($password)) {
                        $errors[] = "Please enter your password.";
                    } elseif (strlen($password) < 6) {
                        $errors[] = "Password must be at least 6 characters long.";
                    } elseif (strlen($password) > 255) {
                        $errors[] = "Password must not exceed 255 characters.";
                    }

                    if (empty($errors)) {
                        try {
                            $conn = new mysqli($host, $user, $pass, $db, $port);
                            if ($conn->connect_error) {
                                throw new Exception("Database connection failed: " . $conn->connect_error);
                            }
                            $conn->set_charset("utf8mb4");

                            // Create table if not exists (with base columns)
                            $createTableSQL = "CREATE TABLE IF NOT EXISTS `login` (
                                `id` INT AUTO_INCREMENT PRIMARY KEY,
                                `name` VARCHAR(100) NOT NULL,
                                `password` VARCHAR(255) NOT NULL,
                                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                            if (!$conn->query($createTableSQL)) {
                                throw new Exception("Failed to create/verify table: " . $conn->error);
                            }

                            // ⚡ FIX: Add email_phone column if missing
                            $colCheck = $conn->query("SHOW COLUMNS FROM `login` LIKE 'email_phone'");
                            if ($colCheck && $colCheck->num_rows === 0) {
                                // Column doesn't exist, add it with a NOT NULL default (safe for existing rows)
                                $alterSQL = "ALTER TABLE `login` ADD COLUMN `email_phone` VARCHAR(150) NOT NULL DEFAULT '' UNIQUE";
                                if (!$conn->query($alterSQL)) {
                                    throw new Exception("Failed to add email_phone column: " . $conn->error);
                                }
                            }

                            // Check if email/phone already exists
                            $checkStmt = $conn->prepare("SELECT id FROM `login` WHERE `email_phone` = ? LIMIT 1");
                            if (!$checkStmt) {
                                throw new Exception("Prepare failed (check): " . $conn->error);
                            }
                            $checkStmt->bind_param("s", $email_phone);
                            $checkStmt->execute();
                            $checkStmt->store_result();

                            if ($checkStmt->num_rows > 0) {
                                $errors[] = "This email or phone number is already registered.";
                            }
                            $checkStmt->close();

                            if (empty($errors)) {
                                $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                                $insertStmt = $conn->prepare("INSERT INTO `login` (`name`, `email_phone`, `password`) VALUES (?, ?, ?)");
                                if (!$insertStmt) {
                                    throw new Exception("Prepare failed (insert): " . $conn->error);
                                }
                                $insertStmt->bind_param("sss", $name, $email_phone, $hashedPassword);
                                if ($insertStmt->execute()) {
                                    $message     = "✅ Account created successfully! Welcome, " . htmlspecialchars($name) . ".";
                                    $messageType = 'success';
                                    $_POST = [];
                                } else {
                                    throw new Exception("Failed to save data: " . $insertStmt->error);
                                }
                                $insertStmt->close();
                            }
                            $conn->close();
                        } catch (Exception $e) {
                            $errors[]   = "Server error: " . $e->getMessage();
                            $messageType = 'error';
                        }
                    }

                    if (!empty($errors)) {
                        $message     = implode("<br>", array_map('htmlspecialchars', $errors));
                        $messageType = 'error';
                    }
                }
                ?>

                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $messageType === 'success' ? 'alert-success' : 'alert-error'; ?>">
                        <span class="alert-icon"><?php echo $messageType === 'success' ? '✓' : '⚠'; ?></span>
                        <span><?php echo $message; ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate autocomplete="on" id="loginForm">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <input type="text" id="name" name="name" class="form-input" placeholder="Enter your full name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required maxlength="100" autocomplete="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email_phone" class="form-label">Email or Phone Number</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                    <path d="M22 4L12 13 2 4" />
                                </svg>
                            </span>
                            <input type="text" id="email_phone" name="email_phone" class="form-input" placeholder="you@example.com or +1 234 567 890" value="<?php echo isset($_POST['email_phone']) ? htmlspecialchars($_POST['email_phone']) : ''; ?>" required maxlength="150" autocomplete="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required maxlength="255" autocomplete="new-password">
                            <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility" title="Show / Hide password" tabindex="-1">
                                <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">Sign In &amp; Save</button>
                </form>

                <div class="divider">Secure &amp; Encrypted</div>
                <p class="card-footer-text">
                    Your data is protected with <strong>bank-level encryption</strong>.<br>
                    By signing in, you agree to our <a href="#">Terms</a> &amp; <a href="#">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </div>

    <script>
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        const eyeOpenSVG = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" /><circle cx="12" cy="12" r="3" />`;
        const eyeOffSVG = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" /><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" /><line x1="1" y1="1" x2="23" y2="23" /><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24" />`;

        passwordToggle.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            if (isPassword) {
                passwordInput.setAttribute('type', 'text');
                eyeIcon.innerHTML = eyeOffSVG;
                passwordToggle.setAttribute('aria-label', 'Hide password');
                passwordToggle.setAttribute('title', 'Hide password');
            } else {
                passwordInput.setAttribute('type', 'password');
                eyeIcon.innerHTML = eyeOpenSVG;
                passwordToggle.setAttribute('aria-label', 'Show password');
                passwordToggle.setAttribute('title', 'Show password');
            }
        });

        const alertBox = document.querySelector('.alert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.transition = 'opacity 0.5s ease, transform 0.4s ease, max-height 0.5s ease, margin 0.5s ease, padding 0.5s ease';
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'scale(0.92)';
                alertBox.style.maxHeight = '0';
                alertBox.style.margin = '0';
                alertBox.style.padding = '0';
                alertBox.style.overflow = 'hidden';
                alertBox.style.borderWidth = '0';
                setTimeout(() => { if (alertBox.parentNode) alertBox.remove(); }, 500);
            }, 6000);
        }

        const submitBtn = document.getElementById('submitBtn');
        const formInputs = document.querySelectorAll('.form-input');
        formInputs.forEach(input => {
            input.addEventListener('focus', () => submitBtn.style.boxShadow = '0 6px 22px rgba(0, 179, 0, 0.45)');
            input.addEventListener('blur', () => submitBtn.style.boxShadow = '0 4px 14px rgba(0, 179, 0, 0.30)');
        });
    </script>
</body>
</html>