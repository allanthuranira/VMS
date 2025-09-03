<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Arrival Time</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" href="css/style.css">
  <meta name="robots" content="noindex, follow">
</head>

<body>
  <div class="wrapper">
    <div class="inner" style="box-shadow: -20px 20px 20px rgba(204, 255, 0, 0.9);">
      <form action="arrival_time_process.php" method="post">
        <h1 style="font-size: 25px; color: #654321;">ENTER ARRIVAL TIME</h1>
        <input type="hidden" name="idNumber" value="<?php echo htmlspecialchars($_GET['idNumber']); ?>">
        <div class="form-wrapper">
          <label for="arrivalTime">Arrival Time:</label>
          <input type="time" class="form-control" id="arrivalTime" name="arrivalTime" required>
        </div>
        <button type="submit">Submit</button>
      </form>
      <img src="images/KSG Logo.png" alt="KSG Logo"
        style="position: fixed; right: 280px; top: 40%; transform: translateY(-50%); width: 60vh; max-height: 200vh;">
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
</body>

</html>
