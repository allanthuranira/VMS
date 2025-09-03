
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Check IN - KSG VEHICLES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/KSG Logo.png" type="image/x-icon">
  <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" href="css/style.css">
  <meta name="robots" content="noindex, follow">
  <style>
    
    .form-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    .form-wrapper .inline-options {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .form-wrapper .inline-options label {
      margin-left: 5px;
    }

    .wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      min-height: 100vh;
      padding: 20px;
      background-color: #f5f5f5;
    }

    .inner {
      width: 100%;
      max-width: 600px;
      background: white;
      padding: 20px;
      box-shadow: -20px 20px 20px rgba(204, 255, 0, 0.9);
      position: relative;
    }

    /* Flexbox container for the header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      text-align: center;
    }

    .header img {
      width: 80px; /* Adjust coat of arms logo size */
      height: auto;
    }
    


    .header h1 {
      flex-grow: 1;
      font-size: 28px;
      color: #654321;
      margin: 0 10px; /* Add space between logos and heading */
    }

    /* Adjust KSG logo placement on the right side */
    .logo-container {
      position: absolute;
      top: 50%;
      right: -90px;
      transform: translateY(-50%);
      
      width: 150px;
      height: auto;
    }

    @media (max-width: 768px) {
      .inner {
        box-shadow: none;
      }

      .logo-container {
        display: none; /* Hide logo for smaller screens */
      }
    }

    @media (max-width: 600px) {
      .inner {
        padding: 15px;
      }
    }

    /* Increase size of calendar and time icon */
    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
      width: 2em;
      height: 2em;
    }


    button[type="submit"] {
      background-color: #bb1313;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.7s ease;
    }

    button[type="submit"]:hover {
      background-color: rgb(16, 243, 16);
    }

    button[type="submit"]:active {
      background-color: rgb(16, 243, 16);
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="inner">

      <!-- Flexbox header with logos and heading -->
      <div class="header">
        <img src="images/COA.png" alt="Kenyan Coat of Arms">
        <h1>Check IN - KSG VEHICLES</h1>
        <img src="images/KSG Logo.png" alt="KSG Logo">
      </div>
      
      <div class="form-container">
        <form action="VehicleCheckInPHP.php" method="POST">
                
          <div class="form-wrapper">
          <b><label for="carNumberPlate" style="font-size: 16px; color: #6CB40D;">VEHICLE NUMBER PLATE:</label></b>
            <select class="form-control" name="checkout_identifier" id="carNumberPlateDropdown" required onchange="updateCarNumberPlate()" required>
            <option value="" disabled selected>Select a Car Number Plate</option>
        <!-- Dynamically insert options for vehicles that have checked out -->
        <?php
                // Database connection setup
                $servername = "127.0.0.1";
              $username = "admin";
              $password = "1!Admin$";
              $dbname = "ksg3";
              $port = 3306;

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch vehicles that have checked out but not checked in
                $sql = "SELECT car_number_plate, checkout_identifier FROM ksgvehicle_checkout
                        WHERE checkout_identifier NOT IN (SELECT checkout_identifier FROM ksgvehicle_checkin)";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  echo "<option value='' disabled selected>Select a Car Number Plate</option>";
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['checkout_identifier'] . "' data-car-number='" . $row['car_number_plate'] . "'>" . $row['car_number_plate'] . "</option>";
                    }
                } else {
                    echo "<option value='' disabled selected>No vehicles to Check IN</option>";
                }

                // Close connection
                $conn->close();
              ?>
      </select>
    </div>

    <!-- Hidden input to hold the selected car number plate -->
    <input type="hidden" name="carNumberPlate" id="carNumberPlate">

    <div class="form-wrapper">
            <b><label for="driverName" style="font-size: 16px; color: #6CB40D;">DRIVER NAME:</label></b>
            <select class="form-control" name="driverName" id="driverName" required>
              <option value="" disabled selected>Select a Driver</option>
              <!-- Add driver options here -->
              <option value="" disabled selected>Select a Driver</option>
                  <option value="Abel Mwiti">Abel Mwiti</option>
                  <option value="Alfred Nyanchienga">Alfred Nyanchienga</option>
                  <option value="Benjamin Kipchris">Benjamin Kipchris</option>
                  <option value="Benson Shapashina">Benson Shapashina</option>
                  <option value="Bernard Koech">Bernard Koech</option>
                  <option value="Daniel Kanji">Daniel Kanji</option>
                  <option value="Dorcas Jepkoech">Dorcas Jepkoech</option>
                  <option value="Eric Mweresa">Eric Mweresa</option>
                  <option value="Erick Ondari">Erick Ondari</option>
                  <option value="Evans Onami Tora">Evans Onami Tora</option>
                  <option value="George Kingori">George Kingori</option>
                  <option value="Ismael Hassan">Ismael Hassan</option>
                  <option value="Jamleck Marige">Jamleck Marige</option>
                  <option value="John Kipkorir Chebon">John Kipkorir Chebon</option>
                  <option value="Kefa Ongori">Kefa Ongori</option>
                  <option value="Martin JOHN Njau">Martin JOHN Njau</option>
                  <option value="Moses Gitonga">Moses Gitonga</option>
                  <option value="Nahshon Mwavishi">Nahshon Mwavishi</option>
                  <option value="Nicholas Mwiti">Nicholas Mwiti</option>
                  <option value="Peter Nyaga">Peter Nyaga</option>
                  <option value="Rapahel Chege">Rapahel Chege</option>
                  <option value="Richard Yoga Ngara">Richard Yoga Ngara</option>
                  <option value="Robert Mwangi Thiga">Robert Mwangi Thiga</option>
                  <option value="Rodgers Maboi">Rodgers Maboi</option>
                  <option value="Saidi Ali">Saidi Ali</option>
                  <option value="William Gachugu">William Gachugu</option>

            </select>
          </div>
  
          <div class="form-wrapper">
            <strong><label for="checkInDateTime" style="font-size: 16px; color: #6CB40D;">Check In Date and Time:</label></strong>
            <input type="datetime-local" id="checkInDateTime" name="checkInDateTime" class="form-control" required>
          </div>
          
          <!-- Campus -->
          <div class="form-wrapper">
              <?php
              $campuses = ["Lower Kabete", "Mombasa", "Embu", "Baringo", "Matuga","ELDi"];
              $campus = $_POST['campus'] ?? '';
              ?>
                  <strong><label for="campus" style="font-size: 16px; color: #6CB40D;">Campus:</label></strong>
                  <select name="campus" id="campus" class="form-control" required>
                      <option value="" <?= $campus === '' ? 'selected' : '' ?>>-- Select campus --</option>
                      <?php foreach ($campuses as $c): ?>
                          <option value="<?= htmlspecialchars($c) ?>" <?= $campus === $c ? 'selected' : '' ?>>
                              <?= htmlspecialchars($c) ?>
                          </option>
                      <?php endforeach; ?>
                  </select>
                  <br><br>

              <?php
              if ($_SERVER["REQUEST_METHOD"] === "POST") {
                  if ($campus === '') {
                      echo "<p style='color:red;'>Please select a campus.</p>";
                  } else {
                      echo "<p>You registered for: <strong>" . htmlspecialchars($campus) . "</strong></p>";
                  }
              }
              ?>
          </div>

          <button type="submit">Check In</button>
        
        </form>
      </div>
    </div>
  </div>
  <script>
  function updateCarNumberPlate() {
    // Get the dropdown and hidden input elements
      var dropdown = document.getElementById("carNumberPlateDropdown");
      var hiddenInput = document.getElementById("carNumberPlate");

      // Get the selected option and its data attribute (car number plate)
      var selectedOption = dropdown.options[dropdown.selectedIndex];
      var carNumberPlate = selectedOption.getAttribute("data-car-number");

      // Update the hidden input value with the selected car number plate
      hiddenInput.value = carNumberPlate;
  }

    function setMinMaxDateTime() {
      const arrivalDateTimeInput = document.getElementById('checkInDateTime');
      const now = new Date();
      const year = now.getFullYear();
      const month = String(now.getMonth() + 1).padStart(2, '0');
      const day = String(now.getDate()).padStart(2, '0');
      const hours = String(now.getHours()).padStart(2, '0');
      const minutes = String(now.getMinutes()).padStart(2, '0');

      const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
      const maxDateTime = `${year}-${month}-${day}T23:59`;

      arrivalDateTimeInput.min = minDateTime;
      arrivalDateTimeInput.max = maxDateTime;
    }

    // Set min and max datetime on page load
    window.onload = setMinMaxDateTime;
  </script>
</body>

</html>
