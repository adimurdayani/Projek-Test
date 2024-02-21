<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css?v=') . random_string(7) }}">

    <title>Ups... Website is under maintenance</title>

    <style>
      .container-maintenance {
        position: relative;
        height: 100vh;
        width: 100vw;
      }

      .container-maintenance .container-content {
        position: absolute;
        top: 40%;
        left: 35%;
      }
    </style>
</head>
<body>

  <div class="container-maintenance">
    <div class="container-content text-center">
      <h4>Ups... Website is under maintenance</h4>
      <p>Please back when we ready</p>
    </div>
  </div>

</body>
</html>
