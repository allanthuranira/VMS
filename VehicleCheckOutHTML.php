<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Check Out - KSG VEHICLES</title>
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
    .hidden {
      display: none;
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

    .logo-container {
      position: absolute;
      top: 50%;
      right: -80px;
      transform: translateY(-50%);
      width: 60vh;
      max-height: 200vh;
    }

    

    @media (max-width: 768px) {
      
      .checkin-link {
    font-size: 14px; /* Decrease font size on smaller screens */
    margin-top: 10px; /* Adjust margin for better positioning */
    text-align: center; /* Center text */
    left: auto; /* Reset left alignment */
    right: auto; /* Reset right alignment */
    display: block; /* Ensure it's on its own line */
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
    background-color: #bb1313; /* Initial button color */
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.7s ease;
  }

  /* Button style on hover */
  button[type="submit"]:hover {
    background-color: rgb(16, 243, 16); /* Light green on hover */
  }

  /* Button style on press (active state) */
  button[type="submit"]:active {
    background-color: rgb(16, 243, 16); /* Same light green when pressed */
  }
  .checkin-link {
  position: absolute;
  left: 20px; /* Align to the far left of the screen */
  color: blue;
  text-decoration: none;
  font-size: 16px;
  top: auto; /* Remove any previous top position */
  bottom: 60px; /* Reset any bottom alignment */
  margin-top: -10px; /* Adjust position to align visually */
}

.checkin-link:hover {
  color: #654321;
}

.checkin-link:active {
  color: lightblue;
}

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      text-align: center;
    }
    .header h1 {
      flex-grow: 1;
      font-size: 28px;
      color: #654321;
      margin: 0 10px; /* Add space between logos and heading */
    }

    .header img {
      width: 80px; /* Adjust coat of arms logo size */
      height: auto;
    }
    

  </style>
</head>

<body>
<div class="wrapper">
  <div class="inner">
      <div class="header">
        <img src="images/COA.png" alt="Kenyan Coat of Arms">
        <h1 style="font-size: 28px; color: #654321; margin-bottom: 24px; margin-left: 18px;">Check Out - KSG VEHICLES
        </h1>
        <img src="images/KSG Logo.png" alt="KSG Logo">
      </div>

      <div class="form-container">
          <form action="VehicleCheckOut.php" method="POST">
            <div class="form-wrapper">
            <b><label for="carNumberPlate" style="font-size: 16px; color: #6CB40D;">VEHICLE NUMBER PLATE:</label></b>
              <select class="form-control" name="carNumberPlate" id="carNumberPlate" required>
                  <option value="" disabled selected>Select a Car Number Plate</option>
                  
                  <option value="GKA 123X">GKA 123X</option>
                  <option value="GKA 431V">GKA 431V</option>
                  <option value="GKA 511A">GKA 511A</option>
                  <option value="GKA 813Q">GKA 813Q</option>
                  <option value="GKA 815Q">GKA 815Q</option>
                  <option value="GKA 917K">GKA 917K</option>
                  <option value="GKA 590M">GKA 590M</option>
                  <option value="GKB 388T">GKB 388T</option>
                  <option value="GKY 757">GKY 757</option>
                  <option value="KAL 980U">KAL 980U</option>
                  <option value="KAN 670U">KAN 670U</option>
                  <option value="KAN 688U">KAN 688U</option>
                  <option value="KAN 830G">KAN 830G</option>
                  <option value="KAV 356Z">KAV 356Z</option>
                  <option value="KAW 135Z">KAW 135Z</option>
                  <option value="KAW 670U">KAW 670U</option>
                  <option value="KAY 040V">KAY 040V</option>
                  <option value="KAY 298V">KAY 298V</option>
                  
                  <option value="KBB 417S">KBB 417S</option>
                  <option value="KBB 770S">KBB 770S</option>
                  <option value="KBC 574X">KBC 574X</option>
                  <option value="KBC 751X">KBC 751X</option>
                  <option value="KBJ 420U">KBJ 420U</option>
                  <option value="KBJ 478S">KBJ 478S</option>
                  <option value="KBJ 751K">KBJ 751K</option>
                  <option value="KBJ 947K">KBJ 947K</option>
                  <option value="KBL 495Q">KBL 495Q</option>
                  <option value="KBN 307U">KBN 307U</option>
                  <option value="KBQ 254D">KBQ 254D</option>
                  <option value="KBR 791U">KBR 791U</option>
                  <option value="KBZ 182D">KBZ 182D</option>
                  <option value="KBZ 546D">KBZ 546D</option>
                  <option value="KBZ 802F">KBZ 802F</option>
                  <option value="KCA 420V">KCA 420V</option>
                  
                  <option value="KCA 590M">KCA 590M</option>
                  <option value="KCA 984D">KCA 984D</option>
                  <option value="KCD 374G">KCD 374G</option>
                  <option value="KCD 388G">KCD 388G</option>
                  <option value="KCD 390G">KCD 390G</option>
                  <option value="KCD 391G">KCD 391G</option>
                  <option value="KCD 863G">KCD 863G</option>
                  <option value="KCF 964U">KCF 964U</option>
                  <option value="KCH 341Q">KCH 341Q</option>
                  <option value="KCH 364G">KCH 364G</option>
                  <option value="KCH 905Q">KCH 905Q</option>
                  <option value="KCH 971Q">KCH 971Q</option>
                  <option value="KCH 984Q">KCH 984Q</option>
                  <option value="KCK 399G">KCK 399G</option>
                  <option value="KCK 632U">KCK 632U</option>
                  <option value="KCP 611K">KCP 611K</option>
                  <option value="KCT 846Y">KCT 846Y</option>
                  
              </select>
            </div>
            
            <div class="form-wrapper">
                <b><label for="driverName" style="font-size: 16px; color: #6CB40D;">DRIVER NAME:</label></b>
                <select class="form-control" name="driverName" id="driverName" required>
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
                <b><label for="authorizedBy" style="font-size: 16px; color: #6CB40D;">AUTHORIZED BY:</label></b>
                <input type="text" class="form-control" name="authorizedBy" id="authorizedBy" required
                  placeholder="Enter Authorizing Officer's Name" pattern="[A-Za-z\s]+" title="Please enter only letters and spaces.">
              </div>
              
            
            <div class="form-wrapper">
              <strong><label for="checkOutDateTime" style="font-size: 16px; color: #6CB40D;">Check Out Date and
                  Time:</label></strong>
              <input type="datetime-local" id="checkOutDateTime" name="checkOutDateTime" class="form-control" required>
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

            <button type="submit">Check Out</button>
            <a href="VehicleCheckInHTML.php" class="checkin-link">Already Checked Vehicle  Out?<br> Check IN...</a>
        </form>
      </div>
  </div>

    
</div>
<script>
  
    function setMinMaxDateTime() {
            const arrivalDateTimeInput = document.getElementById('checkOutDateTime');
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