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
            color: #ffffff!important;
        }
        .container {
            background-color: #204934;
            border-radius: 8px;
            padding: 60px 30px;
            margin: 20px auto;
            max-width: 800px;
        }
        h1 {
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 20px;
            color: #ffffff;
        }
        p {
            font-size: 18px;
            margin: 10px 0;
            color: #ffffff!important;
        }
        .im p {
            color: #fff!important;
        }
        .footer {
            font-size: 0.9em;
            color: #ccc;
            margin-top: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #eee; /* Delikatny kontrastowy podział */
            text-align: left; /* Wyrównanie tekstu do lewej */
        }
        th {
            background-color: #276549; /* Nieco ciemniejszy niż tło kontenera */
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Rezerwacja #{{ $reservation->id }} została anulowana</h1>
    <p>Drogi użytkowniku, <br>
        Twoja rezerwacja kortu <strong>{{ $court_name }}</strong> o numerze <strong>#{{ $reservation->id }}</strong> w dniu <strong>{{ $reservation->start_time }}</strong> została pomyślnie anulowana.
    </p>
    <p>Dziękujemy za skorzystanie z naszych usług i zapraszamy ponownie.</p>
    <div class="footer">
        Pozdrawiamy,<br>
        TENISSO
    </div>
</div>
</body>
</html>
