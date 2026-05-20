<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Home Amenity</title>

    <style>
        :root {
            --green: #00b300;
            --blue: #0088dd;
            --blue-dark: #006daa;
            --white: #ffffff;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --font-sans: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, 'Helvetica Neue', Arial, sans-serif;
            /* Light blue shadow */
            --shadow-blue: 0 8px 24px rgba(0, 136, 221, 0.18), 0 2px 4px rgba(0, 136, 221, 0.08);
            --shadow-blue-hover: 0 14px 30px rgba(0, 136, 221, 0.28), 0 4px 10px rgba(0, 136, 221, 0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-sans);
            background: linear-gradient(160deg, #eef5fb 0%, #f4f8f2 30%, #f9fbfd 100%);
            min-height: 100vh;
            color: var(--gray-800);
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 36px;
            font-size: 2rem;
            font-weight: 700;
            position: relative;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--green);
            margin: 10px auto 0;
            border-radius: 3px;
        }

        /* Grid */
        .services-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 28px;
        }

        @media (min-width: 500px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) {
            .services-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .services-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Card */
        .service-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-blue);
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-blue-hover);
        }

        /* Image area */
        .card-img {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #e0f0ff 0%, #d4e8fc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .card-body {
            padding: 22px 18px 24px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-body h3 {
            font-size: 1.2rem;
            font-weight: 650;
            color: var(--gray-800);
            margin-bottom: 8px;
        }

        .price {
            font-weight: 600;
            color: var(--gray-700);
            margin: 6px 0 20px;
            font-size: 0.95rem;
        }

        .btn-book {
            background: var(--blue);
            color: white;
            border: none;
            padding: 10px 28px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
            display: inline-block;
            margin: 0 auto;
            box-shadow: 0 4px 12px rgba(0,136,221,0.3);
        }

        .btn-book:hover {
            background: var(--blue-dark);
            transform: scale(1.02);
        }

        /* Responsive fine‑tuning */
        @media (max-width: 400px) {
            .card-img {
                height: 150px;
            }
            .section-title {
                font-size: 1.7rem;
            }
            body {
                padding: 30px 12px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="section-title">Our Services</h2>

    <div class="services-grid">
        <?php
        $services = [
            ['name' => 'Electrician',        'price' => 'Starts at 800 PKR',  'image' => 'images/electrician.jpg'],
            ['name' => 'Plumber',            'price' => 'Starts at 600 PKR',  'image' => 'images/plumber.jpg'],
            ['name' => 'Carpenter',          'price' => 'Starts at 1000 PKR', 'image' => 'images/carpenter.jpg'],
            ['name' => 'Painter',            'price' => 'Starts at 700 PKR',  'image' => 'images/painter.jpeg'],
            ['name' => 'AC Servicing',       'price' => 'Starts at 500 PKR',  'image' => 'images/cleaner.jpg'],
            ['name' => 'Gardener',           'price' => 'Starts at 400 PKR',  'image' => 'images/gardening.jpg'],
            ['name' => 'Cleaner',            'price' => 'Starts at 350 PKR',  'image' => 'images/cleaning.jpg'],
            ['name' => 'Appliance Repair',   'price' => 'Starts at 900 PKR',  'image' => 'images/security.jpg'],
            ['name' => 'Pest Control',       'price' => 'Starts at 650 PKR',  'image' => 'images/pest.jpg'],
            ['name' => 'Locksmith',          'price' => 'Starts at 450 PKR',  'image' => 'images/handyman.jpg']
        ];

        foreach ($services as $service):
        ?>
            <div class="service-card">
                <div class="card-img">
                    <img src="<?= htmlspecialchars($service['image']) ?>" alt="<?= htmlspecialchars($service['name']) ?>" loading="lazy">
                </div>
                <div class="card-body">
                    <h3><?= htmlspecialchars($service['name']) ?></h3>
                    <div class="price"><?= htmlspecialchars($service['price']) ?></div>
                    <a href="book.php?service=<?= urlencode($service['name']) ?>" class="btn-book">Book Now</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>