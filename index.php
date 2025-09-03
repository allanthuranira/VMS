<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Security Registration Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/KSG Logo.png" type="image/x-icon">
  <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" href="css/style.css">
  <meta name="robots" content="noindex, follow">
  <style>
    .hidden {
      display: none;
    }

    .form-wrapper .inline-options {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .form-wrapper .inline-options label {
      margin-left: 5px;
    }

    /* Style radio buttons */
    .inline-options input[type="radio"] {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      border: 2px solid #ccc;
      outline: none;
      cursor: pointer;
    }

    .inline-options input[type="radio"]:checked {
      background-color: #2196F3;
    }

    .inline-options input[type="radio"]:checked::before {
      content: '';
      display: block;
      width: 12px;
      height: 12px;
      margin: 6px;
      border-radius: 50%;
      background: white;
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

    .logo-container img {
      width: 100%;
      height: auto;
    }

    @media (max-width: 768px) {
      .logo-container {
        position: static;
        transform: none;
        width: 100%;
        max-width: 300px;
        margin: 20px auto;
        display: block;
      }

      .inner {
        box-shadow: none;
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
    .login-link {
      position: absolute;
      top: 50px;
      right: 30px;
      color: blue;
      text-decoration: none;
      font-size: 16px;
    }

    .login-link:hover {
      color: #654321;
    }

    .login-link:active {
      color: lightblue;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="inner">
      <h1 style="font-size: 28px; color: #654321; margin-bottom: 24px; margin-left: 18px;">KSG ENTRANCE REGISTRATION
      </h1>
      <a href="loginHTML.php" class="login-link">Already Registered? Login...</a>
      <form action="Registration_and_login.php" method="POST">
        <div class="form-wrapper">
          <b><label for="fullName" style="font-size: 16px; color: #6CB40D;">FULL NAME:</label></b>
          <input type="text" class="form-control" name="fullName" id="fullName" required
            placeholder="Enter Your Full Name" pattern="[A-Za-z\s]+" title="Please enter only letters and spaces.">
        </div>
        <div class="form-wrapper">
          <strong><label for="idNumber" style="font-size: 16px; color: #6CB40D;">ID Number/Personal
              Number:</label></strong>
              <input type="text" class="form-control" id="idNumber" name="idNumber" minlength="4" maxlength="20" required
              placeholder="Personal Number or ID NUMBER" pattern="[A-Za-z0-9]+" title="Please enter only numbers or letters."
              inputmode="text">
        </div>

        <div class="form-wrapper">
          <strong><label for="phoneNumber" style="font-size: 16px; color: #6CB40D;">Phone Number:</label></strong>
          <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required
              placeholder="Enter Your Phone Number" pattern="^\+?[0-9]{10,15}$"
              title="Please enter a valid phone number with 10 to 15 digits, optionally starting with a + sign for the country code."
              inputmode="tel">
        </div>

        <div class="form-wrapper">
            <strong>
              <label for="arrivalDateTime" style="font-size: 16px; color: #6CB40D;">
                Arrival Date and Time:
              </label>
            </strong>
            <input type="datetime-local" id="arrivalDateTime" name="arrivalDateTime" class="form-control" required>
          </div>

          <!-- restrict to only the current time -->
          <script>
            // Get current datetime in the format yyyy-MM-ddTHH:mm
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

            const arrivalInput = document.getElementById("arrivalDateTime");
            arrivalInput.value = currentDateTime;      // Pre-fill with current date/time
            arrivalInput.min = currentDateTime;        // Disallow earlier
            arrivalInput.max = currentDateTime;        // Disallow later
          </script>

        <!-- Radio buttons for selecting Yes or No -->
        <div class="form-wrapper">
          <strong><label style="font-size: 16px; color: #6CB40D;">Are you driving?</label></strong>
          <div class="inline-options">
            <div>
              <input type="radio" id="yes" name="MeansQuestion" value="yes" onclick="showQuestions('yes')">
              <i><label for="yes">YES</label></i>
            </div>
            <div>
              <input type="radio" id="no" name="MeansQuestion" value="no" onclick="showQuestions('no')">

              <i><label for="no">NO</label></i>
            </div>
          </div>
        </div>

        <!-- Questions for Yes -->
        <div id="yesQuestions" class="hidden">
          <div class="form-wrapper">
            <label for="motorNumber" style="font-size: 16px; color: #8FEE12;">Vehicle Number Plate:</label>
            <input type="text" class="form-control" id="motorNumber" name="motorNumber"
              placeholder="Enter Vehicle/Motorcycle Number Plate">
          </div>
        </div>

        <!-- Visitor's question with three options (KSG Staff, Participant, or Visitor) -->
        <div class="form-wrapper">
          <strong><label style="font-size: 16px; color: #6CB40D;">Are you a KSG Staff, taking a course, or a
              visitor?</label></strong>
          <div class="inline-options">
            <div>
              <input type="radio" id="ksgStaff" name="ksgStaffOrParticipantOrVisitor" value="ksgStaff"
                onclick="showVisitorQuestion('ksgStaff')">
              <i><label for="ksgStaff">KSG Staff</label></i>
            </div>
            <div>
              <input type="radio" id="participant" name="ksgStaffOrParticipantOrVisitor" value="participant"
                onclick="showVisitorQuestion('participant')">
              <i><label for="participant">Participant</label></i>
            </div>
            <div>
              <input type="radio" id="visitor" name="ksgStaffOrParticipantOrVisitor" value="visitor"
                onclick="showVisitorQuestion('visitor')">
              <i><label for="visitor">Visitor</label></i>
            </div>
          </div>
        </div>

        <!-- Questions for Participant -->
        <div id="participantQuestion" class="hidden">
          <div class="form-wrapper">
            <label for="courseName" style="font-size: 16px; color: #8FEE12;">Course Name:</label>
            <input type="text" class="form-control" id="courseName" name="courseName"
              placeholder="Enter your Course Name">
          </div>
        </div>

        <!-- Questions for Visitor -->
        <div id="visitorQuestions" class="hidden">
          <div class="form-wrapper">
            <label for="officeVisiting" style="font-size: 16px; color: #8FEE12;">Office Name:</label>
            <input type="text" class="form-control" id="officeVisiting" name="officeVisiting"
              placeholder="Enter name of the office">
          </div>
          <div class="form-wrapper">
            <label for="officerName" style="font-size: 16px; color: #8FEE12;">Officer Name:</label>
            <input type="text" class="form-control" id="officerName" name="officerName"
              placeholder="Enter Officer Name">
          </div>
          <div class="form-wrapper">
            <label for="visitorPurpose" style="font-size: 16px; color: #8FEE12;">Purpose of Visit:</label>
            <input type="text" class="form-control" id="visitorPurpose" name="visitorPurpose"
              placeholder="Enter Purpose of Visit">
          </div>
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

        <!-- <div class="form-wrapper">
          <b><label for="registeredBy" style="font-size: 16px; color: #6CB40D;">Registered By:</label></b>
          <input type="text" class="form-control" name="fullName" id="fullName" required
            placeholder="Enter Your Full Name" pattern="[A-Za-z\s]+" title="Please enter only letters and spaces.">
        </div> -->

        <button type="submit">Register</button>
      </form>
      
    </div>
  </div>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'UA-23581568-13');
  </script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vedd3670a3b1c4e178fdfb0cc912d969e1713874337387"
    integrity="sha512-EzCudv2gYygrCcVhu65FkAxclf3mYM6BCwiGUm6BEuLzSb5ulVhgokzCZED7yMIkzYVg65mxfIBNdNra5ZFNyQ=="
    data-cf-beacon='{"rayId":"884b89bf2d5e185c","b":1,"version":"2024.4.1","token":"cd0b4b3a733644fc843ef0b185f98241"}'
    crossorigin="anonymous"></script>
  <script>
    function showQuestions(option) {
      if (option === 'yes') {
        document.getElementById('yesQuestions').classList.remove('hidden');
        motorNumber.required = true; // Make motorNumber field required
      } else {
        document.getElementById('yesQuestions').classList.add('hidden');
         motorNumber.required = false; // Make motorNumber field not required
         motorNumber.value = ''; // Clear the motorNumber field
      }
    }

    function showVisitorQuestion(option) {
      // Hide all specific question sections initially
      document.getElementById('participantQuestion').classList.add('hidden');
      document.getElementById('visitorQuestions').classList.add('hidden');

      // Show relevant section based on the selected option
      if (option === 'participant') {
        document.getElementById('participantQuestion').classList.remove('hidden');
      } else if (option === 'visitor') {
        document.getElementById('visitorQuestions').classList.remove('hidden');
      }
    }
  </script>
</body>

</html>