<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potwierdzenie rezerwacji w TENISSO</title>
    <style>
        body {
            background-color: #f8f8f8;
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #204934;
            border-radius: 8px;
            padding: 60px 30px;
            margin: 20px auto;
            max-width: 800px;
            color: #ffffff;
        }
        h1 {
            margin-bottom: 20px;
            color: #ffffff;
        }
        p {
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #eee; /* Delikatny kontrastowy podział */
        }
        th {
            background-color: #276549; /* Nieco ciemniejszy niż tło kontenera */
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Rezerwacja #{{$reservation->id}} potwierdzona.</h1>
    <p>Drogi użytkowniku, <br>
        twoja rezerwacja #{{$reservation->id}} została potwierdzona. Poniżej znajdziesz jej szczegóły.</p>
    <p>Aby anulować rezerwację przejdź do panelu i odszukaj zakładki "Moje rezerwacje". Następnie postępuj zgodnie z informacjami pojawiającymi się na ekranie.</p>
    <p>Czekamy na Ciebie z niecierpliwością.</p>

    <table>
        <thead>
        <tr>
            <th>Nazwa kortu</th>
            <th>Nawierzchnia</th>
            <th>Godzina rozpoczęcia</th>
            <th>Godzina zakończenia</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$court_name}}</td>
            <td>{{$court_surface}}</td>
            <td>{{$reservation->start_time}}</td>
            <td>{{$reservation->end_time}}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>


