<?php
// capture the chosen service from services.php
$service = $_GET['service'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <title>Book a Worker – Location & Time (free version)</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: #f5f7fb;
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      margin: 0;
    }
    .booking-card {
      max-width: 560px;
      width: 100%;
      border: none;
      border-radius: 1.25rem;
      box-shadow: 0 25px 40px rgba(0, 0, 0, 0.06);
      background: #ffffff;
      padding: 2rem 1.75rem;
      transition: all 0.2s ease;
    }
    @media (max-width: 576px) {
      .booking-card {
        padding: 1.5rem 1.25rem;
        border-radius: 1rem;
      }
    }
    .form-label {
      font-weight: 500;
      color: #1e293b;
      margin-bottom: 0.5rem;
      font-size: 0.95rem;
    }
    .form-control, .form-select {
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      border: 1px solid #e2e8f0;
      font-size: 1rem;
      transition: all 0.2s;
      background: #f8fafc;
    }
    .form-control:focus, .form-select:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
      background: #ffffff;
    }
    .auto-detect-hint {
      font-size: 0.8rem;
      color: #64748b;
      margin-top: 0.25rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .detect-spinner {
      width: 14px;
      height: 14px;
      border: 2px solid #cbd5e1;
      border-top: 2px solid #2563eb;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      display: none;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    #extraTimeBlock {
      transition: all 0.2s ease;
    }
    .btn-primary {
      background: #2563eb;
      border: none;
      border-radius: 0.75rem;
      padding: 0.8rem 1.5rem;
      font-weight: 500;
      font-size: 1rem;
      letter-spacing: 0.01em;
      transition: background 0.2s;
    }
    .btn-primary:hover {
      background: #1d4ed8;
    }
    .status-error {
      color: #b91c1c;
    }
  </style>
</head>
<body>
  <div class="booking-card">
    <h2 class="fw-bold mb-3" style="color: #0f172a; font-size: 1.6rem;"> Your Location & Time</h2>
    <p class="text-muted mb-4" style="font-size: 0.95rem;">We’ll auto‑detect your address using your device. No account needed.</p>

    <form id="bookingForm" novalidate>
      <!-- Location Input -->
      <div class="mb-3">
        <label for="locationInput" class="form-label">Your location</label>
        <input type="text" class="form-control" id="locationInput" placeholder="Detecting your location…" autocomplete="off">
        <!-- Hidden field to store the automatically detected city -->
        <input type="hidden" id="hiddenCity" value="">

        <div class="auto-detect-hint">
          <span class="detect-spinner" id="detectSpinner"></span>
          <span id="detectStatus">Detecting…</span>
        </div>
      </div>

      <!-- Duration Selector -->
      <div class="mb-3">
        <label for="durationSelect" class="form-label">How long do you need the worker?</label>
        <select class="form-select" id="durationSelect">
          <option value="" disabled selected>Choose duration</option>
          <option value="15">15 minutes</option>
          <option value="30">30 minutes</option>
          <option value="45">45 minutes</option>
          <option value="60">1 hour</option>
          <option value="90">1.5 hours</option>
          <option value="120">2 hours</option>
          <option value="150">2.5 hours</option>
          <option value="180">3 hours</option>
          <option value="210">3.5 hours</option>
          <option value="240">4 hours</option>
        </select>
      </div>

      <!-- Extra Time Option -->
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="extraTimeCheck">
        <label class="form-check-label" for="extraTimeCheck">Add extra time</label>
      </div>
      <div class="mb-4" id="extraTimeBlock" style="display: none;">
        <label for="extraMinutes" class="form-label">Extra minutes (max 60)</label>
        <input type="number" class="form-control" id="extraMinutes" min="0" max="60" placeholder="e.g., 15" disabled>
      </div>

      <!-- Submit (now redirects to workers.php) -->
      <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>Continue</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- No Google Maps API needed! Using free OpenStreetMap Nominatim -->
  <script>
    (function() {
      // DOM elements
      const locationInput = document.getElementById('locationInput');
      const detectSpinner = document.getElementById('detectSpinner');
      const detectStatus = document.getElementById('detectStatus');
      const extraTimeCheck = document.getElementById('extraTimeCheck');
      const extraTimeBlock = document.getElementById('extraTimeBlock');
      const extraMinutesInput = document.getElementById('extraMinutes');
      const submitBtn = document.getElementById('submitBtn');
      const hiddenCity = document.getElementById('hiddenCity');

      // Submit button state
      function updateSubmitState() {
        const locationFilled = locationInput.value.trim() !== '';
        const durationSelected = document.getElementById('durationSelect').value !== '';
        submitBtn.disabled = !(locationFilled && durationSelected);
      }
      locationInput.addEventListener('input', updateSubmitState);
      document.getElementById('durationSelect').addEventListener('change', updateSubmitState);

      // Extra time toggle
      extraTimeCheck.addEventListener('change', function() {
        if (this.checked) {
          extraTimeBlock.style.display = 'block';
          extraMinutesInput.disabled = false;
        } else {
          extraTimeBlock.style.display = 'none';
          extraMinutesInput.disabled = true;
          extraMinutesInput.value = '';
        }
      });

      // ---------- FREE REVERSE GEOCODING using Nominatim (OpenStreetMap) ----------
      async function reverseGeocodeNominatim(lat, lng) {
        const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&addressdetails=1`;
        try {
          const response = await fetch(url, {
            headers: {
              'User-Agent': 'StudentBookingApp/1.0'
            }
          });
          if (!response.ok) throw new Error(`HTTP ${response.status}`);
          const data = await response.json();
          if (data && data.display_name) {
            // Extract the city/town/village from the detailed address
            let city = '';
            if (data.address) {
              city = data.address.city || data.address.town || data.address.village || '';
            }
            // Return an object with both the full address and the city
            return {
              fullAddress: data.display_name,
              city: city
            };
          } else {
            throw new Error('No address found');
          }
        } catch (err) {
          console.error('Nominatim reverse geocode failed:', err);
          return null;
        }
      }

      // ---------- DETECT LOCATION (browser Geolocation) ----------
      async function detectLocation() {
        if (!navigator.geolocation) {
          detectSpinner.style.display = 'none';
          detectStatus.textContent = ' Geolocation not supported by your browser';
          detectStatus.className = 'status-error';
          locationInput.placeholder = 'Type your address';
          return;
        }

        detectSpinner.style.display = 'inline-block';
        detectStatus.textContent = 'Detecting your location…';
        detectStatus.className = '';

        navigator.geolocation.getCurrentPosition(
          async (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            const result = await reverseGeocodeNominatim(lat, lng);
            detectSpinner.style.display = 'none';

            if (result) {
              locationInput.value = result.fullAddress;
              // Automatically fill the hidden city field
              hiddenCity.value = result.city || result.fullAddress; // fallback to full address if city empty
              detectStatus.textContent = ' Exact address detected';
              detectStatus.className = '';
              updateSubmitState();
            } else {
              detectStatus.textContent = ' Could not find address. Please type manually.';
              detectStatus.className = 'status-error';
              locationInput.placeholder = 'Enter your full address';
            }
          },
          (error) => {
            detectSpinner.style.display = 'none';
            let errorMsg = 'Location access denied.';
            switch(error.code) {
              case error.PERMISSION_DENIED:
                errorMsg = ' You denied location permission. Please type your address.';
                break;
              case error.POSITION_UNAVAILABLE:
                errorMsg = ' Location unavailable. Please type your address.';
                break;
              case error.TIMEOUT:
                errorMsg = ' Location request timed out. Please type your address.';
                break;
            }
            detectStatus.textContent = errorMsg;
            detectStatus.className = 'status-error';
            locationInput.placeholder = 'Enter your address';
          },
          { enableHighAccuracy: true, timeout: 15000, maximumAge: 60000 }
        );
      }

      // ---------- START IMMEDIATELY ----------
      window.addEventListener('load', () => {
        detectLocation();
      });

      // ---------- Form submit – redirect to workers.php ----------
      document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const service = "<?php echo addslashes($service); ?>";
        const city = hiddenCity.value.trim();
        const durationSelect = document.getElementById('durationSelect');
        const duration = durationSelect.value;

        // Basic validation
        if (!service || !city || !duration) {
          alert("Please wait for location detection to complete and select a duration.");
          return;
        }

        const baseDuration = parseInt(duration, 10);
        const extra = extraTimeCheck.checked ? (parseInt(extraMinutesInput.value, 10) || 0) : 0;
        const totalMinutes = baseDuration + extra;

        // Build query string and redirect
        const params = new URLSearchParams();
        params.set('service', service);
        params.set('city', city);
        params.set('time', totalMinutes);
        window.location.href = 'workpro.php?' + params.toString();
      });
    })();
  </script>
</body>
</html>