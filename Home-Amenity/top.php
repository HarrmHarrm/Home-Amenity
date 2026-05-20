<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trending Services - Home Amenity</title>

    <style>
        :root {
            --green: #00b300;
            --blue: #0088dd;
            --blue-dark: #006daa;
            --white: #ffffff;
            --gray-100: #f0f4f6;
            --gray-200: #e2e8ec;
            --gray-500: #64748b;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --font-sans: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, 'Helvetica Neue', Arial, sans-serif;
            --shadow-light: 0 6px 18px rgba(0, 136, 221, 0.12), 0 2px 6px rgba(0, 136, 221, 0.06);
            --shadow-hover: 0 10px 24px rgba(0, 136, 221, 0.22), 0 4px 10px rgba(0, 136, 221, 0.10);
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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            color: var(--gray-800);
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .section-header h2 {
            font-size: 2rem;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--green);
            border-radius: 3px;
        }

        /* Trending strip – scroll horizontally on small screens */
        .trending-strip {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            padding: 10px 0 20px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: var(--blue) var(--gray-100);
        }

        .trending-strip::-webkit-scrollbar {
            height: 6px;
        }
        .trending-strip::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 10px;
        }
        .trending-strip::-webkit-scrollbar-thumb {
            background: var(--blue);
            border-radius: 10px;
        }

        /* Individual service item – not a card, more like a sleek pill/block */
        .service-item {
            flex: 0 0 auto;
            width: 220px;
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow-light);
            padding: 24px 16px 20px;
            text-align: center;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            scroll-snap-align: start;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid rgba(0, 136, 221, 0.08);
        }

        .service-item:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
        }

        .icon-ring {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue-light, #e6f4fc) 0%, #d4eafc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 2rem;
            box-shadow: 0 4px 12px rgba(0, 136, 221, 0.15);
        }

        .service-item h3 {
            font-size: 1.05rem;
            font-weight: 650;
            color: var(--gray-800);
            margin-bottom: 6px;
        }

        .service-item .price {
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.9rem;
            margin-bottom: 16px;
        }

        .btn-book {
            background: var(--blue);
            color: white;
            border: none;
            padding: 8px 22px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(0,136,221,0.25);
        }

        .btn-book:hover {
            background: var(--blue-dark);
            transform: scale(1.03);
        }

        /* On wider screens, allow wrapping instead of horizontal scroll */
        @media (min-width: 900px) {
            .trending-strip {
                flex-wrap: wrap;
                justify-content: center;
                overflow-x: visible;
                padding: 0;
            }
            .service-item {
                flex: 0 0 calc(33.333% - 24px);
                max-width: 280px;
            }
        }

        @media (min-width: 1100px) {
            .service-item {
                flex: 0 0 calc(25% - 24px);
            }
        }

        @media (max-width: 400px) {
            .service-item {
                width: 180px;
                padding: 18px 12px 16px;
            }
            .icon-ring {
                width: 56px;
                height: 56px;
                font-size: 1.6rem;
            }
            .service-item h3 {
                font-size: 0.95rem;
            }
            .section-header h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="section-header">
        <h2>Top Services</h2>
    </div>

    <div class="trending-strip">
        <?php
        $trending_services = [
            ['name' => 'Electrician',   'price' => '800 PKR',   'icon' => '⚡'],
            ['name' => 'Plumber',       'price' => '600 PKR',   'icon' => '🔧'],
            ['name' => 'AC Servicing',  'price' => '500 PKR',   'icon' => '❄️'],
            ['name' => 'Carpenter',     'price' => '1000 PKR',  'icon' => '🪚'],
            ['name' => 'Painter',       'price' => '700 PKR',   'icon' => '🎨'],
            ['name' => 'Cleaner',       'price' => '350 PKR',   'icon' => '🧹']
        ];

        foreach ($trending_services as $service):
        ?>
            <div class="service-item">
                <div class="icon-ring">
                    <?= $service['icon'] ?>
                </div>
                <h3><?= htmlspecialchars($service['name']) ?></h3>
                <div class="price">Starts at <?= htmlspecialchars($service['price']) ?></div>
                <a href="services.php" class="btn-book">View Now</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>