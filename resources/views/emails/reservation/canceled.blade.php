<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezerwacja Anulowana</title>
    <style>
        body {
            background-color: #f8f8f8;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #ffffff;
        }
        .container {
            background-color: #204934;
            border-radius: 8px;
            padding: 60px 30px;
            margin: 20px auto;
            max-width: 800px;
        }
        h1 {
            margin-bottom: 20px;
        }
        p {
            margin: 10px 0 20px 0;
        }
        .footer {
            font-size: 0.9em;
            color: #ccc;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Rezerwacja Anulowana</h1>
    <p>Drogi użytkowniku,</p>
    <p>Twoja rezerwacja kortu <strong>{{ $court_name }}</strong> o numerze <strong>#{{ $reservation->id }}</strong> w dniu <strong>{{ $reservation->start_time }}</strong> została pomyślnie anulowana.</p>
    <p>Dziękujemy za skorzystanie z naszych usług.</p>
    <div class="footer">
        Pozdrawiamy,<br>
        TENNISO
    </div>
</div>
</body>
</html>
