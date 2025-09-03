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
                  <option value="KCD 390G">KCD 390G</option>
                  <option value="KBB 770S">KBB 770S</option>
                  <option value="GKA 123X">GKA 123X</option>
                  <option value="KCD 374G">KCD 374G</option>
                  <option value="GKA 917K">GKA 917K</option>
                  <option value="KAY 040V">KAY 040V</option>
                  <option value="KBZ 182D">KBZ 182D</option>
                  <option value="KBQ 254D">KBQ 254D</option>
                  <option value="KAL 980U">KAL 980U</option>
                  <option value="KAN 670U">KAN 670U</option>
                  <option value="KBR 791U">KBR 791U</option>
                  <option value="KAY 298V">KAY 298V</option>
                  <option value="KBB 417S">KBB 417S</option>
                  <option value="KCH 905Q">KCH 905Q</option>
                  <option value="GKA 431V">GKA 431V</option>
                  <option value="KBJ 420U">KBJ 420U</option>
                  <option value="KBC 751X">KBC 751X</option>
                  <option value="KBZ 546D">KBZ 546D</option>
                  <option value="KCT 846Y">KCT 846Y</option>
                  <option value="KAW 135Z">KAW 135Z</option>
              </select>
            </div>
            
            <div class="form-wrapper">
                <b><label for="driverName" style="font-size: 16px; color: #6CB40D;">DRIVER NAME:</label></b>
                <select class="form-control" name="driverName" id="driverName" required>
                  <option value="" disabled selected>Select a Driver</option>
                  <option value="Richard Yoga Ngara">Richard Yoga Ngara</option>
                  <option value="Evans Onami Tora">Evans Onami Tora</option>
                  <option value="Robert Mwangi Thiga">Robert Mwangi Thiga</option>
                  <option value="Nicholas Mwiti">Nicholas Mwiti</option>
                  <option value="Abel Mwiti">Abel Mwiti</option>
                  <option value="Kefa Ongori">Kefa Ongori</option>
                  <option value="Peter Nyaga">Peter Nyaga</option>
                  <option value="Erick Ondari">Erick Ondari</option>
                  <option value="William Gachugu">William Gachugu</option>
                  <option value="Bernard Koech">Bernard Koech</option>
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