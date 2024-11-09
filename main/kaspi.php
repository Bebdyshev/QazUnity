<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оплата через Kaspi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            margin: 10px 0;
            display: block;
            text-align: left;
        }
        input[type="number"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .qr-code {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Оплата через Kaspi</h2>
        
        <!-- Форма для ввода данных -->
        <form method="POST" action="process_payment.php">
        </form>

        <!-- QR-код (пример, сгенерированный заранее) -->
        <div class="qr-code">
            <h3>Отсканируйте QR-код для оплаты:</h3>
            <img src="https://f.nodacdn.net/408120" alt="Kaspi QR код" width="300">
        </div>
    </div>

</body>
</html>
