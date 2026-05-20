<?php
// worker.php – Responsive Worker Registration (Picture mandatory)

// ---------- Database Configuration ----------
$host = "localhost";
$user = "root";
$pass = "Harrm$1004";
$db   = "homeamenity";
$port = 3307;

// ---------- Connect to MySQLi ----------
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ---------- Create table if not exists ----------
$table_sql = "CREATE TABLE IF NOT EXISTS workers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    city VARCHAR(100) NOT NULL,
    experience_years INT NOT NULL,
    category VARCHAR(50) NOT NULL,
    hourly_rate DECIMAL(10,2) NOT NULL,
    availability_hours INT NOT NULL,
    uploaded_file VARCHAR(255),
    picture VARCHAR(255) NOT NULL,
    confirmation TINYINT(1) DEFAULT 0,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($table_sql)) {
    die("Table creation failed: " . $conn->error);
}

// ---------- Ensure 'picture' column exists (safe for all MySQL versions) ----------
$check_col = $conn->query("SHOW COLUMNS FROM workers LIKE 'picture'");
if ($check_col && $check_col->num_rows === 0) {
    $add_pic_sql = "ALTER TABLE workers ADD COLUMN picture VARCHAR(255) NOT NULL DEFAULT ''";
    if (!$conn->query($add_pic_sql)) {
        die("Failed to add picture column: " . $conn->error);
    }
}

// ---------- Category list ----------
$categories = [
    'Electrician',
    'Plumber',
    'Carpenter',
    'Painter',
    'Cleaner',
    'Gardener',
    'HandyMan',
    'Appliance Repairer',
    'Pest Controler',
];

// ---------- Variables for feedback ----------
$errors = [];
$success_message = '';

// ---------- Form processing ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Retrieve text fields
    $name            = trim($_POST['name'] ?? '');
    $phone           = trim($_POST['phone'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $city            = trim($_POST['city'] ?? '');
    $experience      = trim($_POST['experience'] ?? '');
    $category        = $_POST['category'] ?? '';
    $hourly_rate     = trim($_POST['hourly_rate'] ?? '');
    $availability    = trim($_POST['availability'] ?? '');
    $confirmation    = isset($_POST['confirmation']) ? 1 : 0;

    // 2. Validation
    if ($name === '') {
        $errors[] = "Name is required.";
    }
    if ($phone === '' && $email === '') {
        $errors[] = "Please provide at least a phone number or an email address.";
    }
    if ($city === '') {
        $errors[] = "City is required.";
    }
    if (!ctype_digit($experience) || (int)$experience < 0) {
        $errors[] = "Years of experience must be a non-negative integer.";
    }
    if (!in_array($category, $categories)) {
        $errors[] = "Please select a valid category.";
    }
    if (!is_numeric($hourly_rate) || (float)$hourly_rate <= 0) {
        $errors[] = "Hourly rate must be a positive number.";
    }
    if (!ctype_digit($availability) || (int)$availability <= 0) {
        $errors[] = "Availability hours must be a positive integer.";
    }
    if ($confirmation !== 1) {
        $errors[] = "You must confirm that the information is correct.";
    }

    // --- Picture is mandatory ---
    if (!isset($_FILES['picture']) || $_FILES['picture']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Worker's picture is required.";
    }

    // 3. File uploads – Document (certificate/CNIC/licence)
    $uploaded_file_path = null;
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['document'];
        $allowed_types = ['application/pdf', 'image/jpeg', 'image/png'];
        $max_size = 2 * 1024 * 1024; // 2 MB

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowed_types)) {
            $errors[] = "Document: Only PDF, JPG, and PNG files are allowed.";
        }
        if ($file['size'] > $max_size) {
            $errors[] = "Document: File size must be less than 2 MB.";
        }

        if (empty($errors)) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_name = uniqid('doc_') . '.' . $ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $uploaded_file_path = $new_name;
            } else {
                $errors[] = "Failed to upload the document.";
            }
        }
    }

    // 4. File uploads – Picture (mandatory, further validation)
    $picture_path = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $pic = $_FILES['picture'];
        $allowed_pic_types = ['image/jpeg', 'image/png'];
        $max_pic_size = 1 * 1024 * 1024; // 1 MB

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $pic['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowed_pic_types)) {
            $errors[] = "Picture: Only JPG and PNG images are allowed.";
        }
        if ($pic['size'] > $max_pic_size) {
            $errors[] = "Picture: File size must be less than 1 MB.";
        }

        if (empty($errors)) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            $ext = pathinfo($pic['name'], PATHINFO_EXTENSION);
            $new_name = uniqid('pic_') . '.' . $ext;
            $destination = $upload_dir . $new_name;

            if (move_uploaded_file($pic['tmp_name'], $destination)) {
                $picture_path = $new_name;
            } else {
                $errors[] = "Failed to upload the picture.";
            }
        }
    }

    // 5. Insert into database (presence_on_system removed)
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO workers 
            (name, phone, email, city, experience_years, category, hourly_rate, availability_hours, uploaded_file, picture, confirmation) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param(
                "ssssisdisss",  // 11 fields: s s s s i s d i s s i
                $name,
                $phone,
                $email,
                $city,
                $experience,
                $category,
                $hourly_rate,
                $availability,
                $uploaded_file_path,
                $picture_path,
                $confirmation
            );

            if ($stmt->execute()) {
                $success_message = "Thank you! Your information has been submitted successfully.";
                $_POST = [];
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Prepare failed: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Registration - Home Amenity</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            padding: 20px 15px;
            display: flex;
            justify-content: center;
        }
        .container {
            background: white;
            width: 100%;
            max-width: 650px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            padding: 25px 20px;
            margin: 0 auto;
        }
        h1 { font-size: 1.8rem; color: #2c3e50; margin-bottom: 5px; }
        .subtitle { color: #7f8c8d; margin-bottom: 25px; font-size: 0.95rem; }

        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .error { background: #fdecea; color: #c0392b; border-left: 5px solid #e74c3c; }
        .success { background: #e8f5e9; color: #2e7d32; border-left: 5px solid #4caf50; }
        .error ul { margin: 5px 0 0 20px; }

        form { display: flex; flex-direction: column; gap: 15px; }
        .form-group { display: flex; flex-direction: column; }
        label { font-weight: 600; margin-bottom: 5px; color: #2c3e50; font-size: 0.9rem; }
        .required:after { content: " *"; color: #e74c3c; }
        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dcdde1;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
            background: #fafafa;
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #3498db; background: white; }
        textarea { resize: vertical; }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 5px;
        }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; margin: 0; flex-shrink: 0; }
        .checkbox-group label { margin: 0; font-weight: normal; font-size: 0.9rem; }

        .btn {
            background: #2980b9;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }
        .btn:hover { background: #1c5980; }

        /* Responsive */
        @media (max-width: 600px) {
            body { padding: 10px 8px; }
            .container { padding: 20px 15px; border-radius: 8px; }
            h1 { font-size: 1.5rem; }
            .btn { padding: 14px; font-size: 1rem; }
        }
        @media (min-width: 601px) and (max-width: 992px) {
            .container { max-width: 600px; }
        }
        @media (min-width: 993px) {
            .container { max-width: 700px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Become a Worker</h1>
        <p class="subtitle">Join the Home Amenity platform and offer your services.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <strong>Please fix the following errors:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php else: ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="required">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>

                <!-- City -->
                <div class="form-group">
                    <label for="city" class="required">City</label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>" required>
                </div>

                <!-- Experience -->
                <div class="form-group">
                    <label for="experience" class="required">Years of Experience</label>
                    <input type="number" id="experience" name="experience" min="0" value="<?php echo htmlspecialchars($_POST['experience'] ?? ''); ?>" required>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category" class="required">Work Category</label>
                    <select id="category" name="category" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat; ?>" <?php echo (isset($_POST['category']) && $_POST['category'] === $cat) ? 'selected' : ''; ?>>
                                <?php echo $cat; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Hourly Rate -->
                <div class="form-group">
                    <label for="hourly_rate" class="required">Hourly Rate (e.g., 25.00)</label>
                    <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" min="0.01" value="<?php echo htmlspecialchars($_POST['hourly_rate'] ?? ''); ?>" required>
                </div>

                <!-- Availability -->
                <div class="form-group">
                    <label for="availability" class="required">Availability (hours per week)</label>
                    <input type="number" id="availability" name="availability" min="1" value="<?php echo htmlspecialchars($_POST['availability'] ?? ''); ?>" required>
                </div>

                <!-- Picture Upload (mandatory) -->
                <div class="form-group">
                    <label for="picture" class="required">Worker's Picture</label>
                    <input type="file" id="picture" name="picture" accept=".jpg,.jpeg,.png" required>
                    <small style="color:#7f8c8d; margin-top:3px;">JPG or PNG (max 1MB) – Required</small>
                </div>

                <!-- Document Upload -->
                <div class="form-group">
                    <label for="document">Upload Certificate / CNIC / Licence</label>
                    <input type="file" id="document" name="document" accept=".pdf,.jpg,.jpeg,.png">
                    <small style="color:#7f8c8d; margin-top:3px;">PDF, JPG or PNG (max 2MB)</small>
                </div>

                <!-- Confirmation -->
                <div class="checkbox-group">
                    <input type="checkbox" id="confirmation" name="confirmation" required>
                    <label for="confirmation">I confirm that all the information provided above is correct.</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn">Submit Registration</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>