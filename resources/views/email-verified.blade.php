<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verified</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        // Redirect after 3 seconds
        setTimeout(function() {
            window.location.href = 'http://localhost:3000/';
        }, 3000);
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f8fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 2rem 3rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
        }
        .success {
            color: #DA0402;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .redirect {
            color: #888;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: center; margin-bottom: 2rem;">
            <img src="https://frijaaay.github.io/domain-test/assets/images/emails/pcclogo.png" alt="PCC Logo" style="max-width: 160px; height: auto;">
        </div>
        <div class="success">Email successfully verified!</div>
        <div class="redirect">Redirecting to your dashboard...</div>
        <button onclick="window.location.href='http://localhost:3000/'" style="margin-top: 1.5rem; padding: 0.5rem 1.5rem; font-size: 1rem; background: #DA0402; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
            Click here to redirect
        </button>
    </div>
</body>
</html>
