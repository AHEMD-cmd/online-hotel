<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        .email-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
        }

        .email-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .email-body {
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
        }

        .email-footer {
            padding: 10px;
            text-align: center;
            color: #aaa;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Global Message from Admin</h2>
        </div>
        <div class="email-body">
            <p>{{ $data['name'] }}</p>
        </div>
        <div class="email-body">
            <p>{{ $data['email'] }}</p>
        </div>
        <div class="email-body">
            <p>{{ $data['message'] }}</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
