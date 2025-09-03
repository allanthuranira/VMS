<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="images/KSG Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            position: relative;
            padding: 20px;
            max-width: 770px;
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: -20px 20px 20px rgba(204, 255, 0, 0.9);
        }

        .hidden {
            display: none;
        }

        .form-wrapper .inline-options {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .form-wrapper .inline-options label {
            margin-left: 8px;
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

        p {
            margin: 5px 0;
            color: #555;
        }

        img {
            position: absolute;
            left: 75%;
            transform: translateX(-50%);
            top: 10px;
            width: 100px;
            height: auto;
        }

        .button {
            margin: 20px 10px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button-login {
            background-color: #4CAF50;
            color: white;
        }

        .register-link {
            position: absolute;
            bottom: 50px;
            right: 40px;
            color: #4c4ee7;
            font-size: 16px;
            /* Increased font size */
            text-decoration: none;
            transition: color 0.3s;
        }

        .register-link:hover {
            color: rgb(128, 80, 80);
        }

        .register-link:active {
            color: rgb(152, 183, 252);
        }

        .zmdi {
            font-size: 22px;
            /* Increased icon size */
            vertical-align: middle;
            margin-left: 0.5px;
            /* Added margin to separate icon from text */
        }

        /* Increase size of calendar and time icon */
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            width: 2em;
            height: 2em;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            width: 24px;
            height: 24px;
        }

        input[type="number"]::-webkit-inner-spin-button {
            background-size: 24px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="text-align: left;">
            <h1 style="font-size: 28px; color: #654321; margin-bottom: 24px; margin-left: 18px;">LOGIN</h1>
            <form action="login.php" method="POST" id="loginForm">
                <strong><label for="idNumber" style="font-size: 16px; color: #6CB40D; margin-bottom: 5px;">ID Number/Personal
                        Number:</label></strong>
                <input type="text" pattern="[A-Za-z0-9]+" placeholder="Personal Number or ID NUMBER" id="idNumber" name="idNumber" class="form-control" required>
                <div class="form-wrapper" style="margin-top: 10px;">
                    <strong><label style="font-size: 16px; color: #6CB40D;">Are you driving or riding a motorcycle?</label></strong>
                    <div class="inline-options">
                        <div>
                            <input type="radio" id="yes" name="MeansQuestion" value="yes" onclick="showMeansQuestions('yes')">
                            <i><label for="yes">YES</label></i>
                        </div>
                        <div>
                            <input type="radio" id="no" name="MeansQuestion" value="no" onclick="showMeansQuestions('no')">
                            <i><label for="no">NO</label></i>
                        </div>
                    </div>
                </div>

                <!-- Questions for Yes -->
                <div id="yesQuestions" class="hidden">
                    <div class="form-wrapper" style="margin-left: 25px;">
                        <label for="motorNumber" style="font-size: 16px; color: #8FEE12;">Vehicle/Motorcycle Number Plate:</label>
                        <input type="text" class="form-control" id="motorNumber" name="motorNumber" placeholder="Enter Vehicle/Motorcycle Number Plate" title="Please enter the Number Plate.">
                    </div>
                    <div class="form-wrapper" style="margin-top: 10px;">
                        <strong><label style="font-size: 16px; color: #6CB40D;">Any Extra Passengers?</label></strong>
                        <div class="inline-options">
                            <div>
                                <input type="radio" id="yesP" name="passengersQuestion" value="yes" onclick="showPassengerQuestions('yesP')">
                                <i><label for="yesP">YES</label></i>
                            </div>
                            <div>
                                <input type="radio" id="noP" name="passengersQuestion" value="no" onclick="showPassengerQuestions('noP')">
                                <i><label for="noP">NO</label></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questions for Yes Passengers -->
                <div id="PassengersQuestion" class="hidden">
                    <div class="form-wrapper" style="margin-left: 30px;">
                        <label for="Passengers" style="font-size: 16px; color: #8FEE12;">Number of passengers:</label>
                        <input type="number" class="form-control" id="passengerNumber" name="passengerNumber" placeholder="How Many Passengers">
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
                
                <div class="form-wrapper">
                    <strong><label for="arrivalDateTime" style="font-size: 16px; color: #6CB40D;">Arrival Date and
                            Time:</label></strong>
                    <input type="datetime-local" id="arrivalDateTime" name="arrivalDateTime" class="form-control" required>
                </div>
                <br>
                <button type="submit" class="button button-login">Login</button>
            </form>
            <a href="index.php" class="register-link">Register <i class="zmdi zmdi-arrow-right"></i></a>
        </div>
        <img src="images/KSG Logo.png" alt="KSG Logo">
    </div>
    <script>
        function showMeansQuestions(option) {
            const motorNumber = document.getElementById('motorNumber');
            const passengerQuestionYes = document.getElementById('yesP');
            const passengerQuestionNo = document.getElementById('noP');
            if (option === 'yes') {
                document.getElementById('yesQuestions').classList.remove('hidden');
                motorNumber.required = true; // Make motorNumber field required
                passengerQuestionYes.required = true; // Make passengers question required
                passengerQuestionNo.required = true; // Make passengers question required
            } else {
                document.getElementById('yesQuestions').classList.add('hidden');
                document.getElementById('PassengersQuestion').classList.add('hidden'); // Hide passengers question if "No" is selected
                motorNumber.required = false; // Make motorNumber field not required
                motorNumber.value = ''; // Clear the motorNumber field
                passengerQuestionYes.required = false; // Make passengers question not required
                passengerQuestionNo.required = false; // Make passengers question not required
                const extraPassengerNumber = document.getElementById('passengerNumber');

                extraPassengerNumber.required= false;
                extraPassengerNumber.value= '';
                const selectedPassengerQuestion = document.querySelector('input[name="passengersQuestion"]:checked');
                if (selectedPassengerQuestion) {
                    selectedPassengerQuestion.checked = false; // Uncheck any passengers question radio button
                }
            }
        }

        function showPassengerQuestions(option) {
            const extraPassengerNumber = document.getElementById('passengerNumber');
            
            if (option === 'yesP') {
                document.getElementById('PassengersQuestion').classList.remove('hidden');
                extraPassengerNumber.required= true;
            } else {
                document.getElementById('PassengersQuestion').classList.add('hidden');
                extraPassengerNumber.required= false;
                extraPassengerNumber.value = '';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function (e) {
            const meansQuestion = document.querySelector('input[name="MeansQuestion"]:checked');
            const motorNumber = document.getElementById('motorNumber');

            if (meansQuestion && meansQuestion.value === 'no') {
                motorNumber.required = false;
                motorNumber.value = ''; // Clear the motorNumber field
                const passengerQuestionYes = document.getElementById('yesP');
                const passengerQuestionNo = document.getElementById('noP');
                passengerQuestionYes.required = false; // Make passengers question not required
                passengerQuestionNo.required = false; // Make passengers question not required

                const extraPassengerNumber = document.getElementById('passengerNumber');

                extraPassengerNumber.required= false;
                extraPassengerNumber.value= '';
            }
        });

        function setMinMaxDateTime() {
            const arrivalDateTimeInput = document.getElementById('arrivalDateTime');
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
