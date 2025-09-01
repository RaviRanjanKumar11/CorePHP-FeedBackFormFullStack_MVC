<?php $base = rtrim($this->config['app']['base_url'], '/'); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? 'Success') ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 90%;
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      text-align: center;
    }
    h1 {
      color: #28a745;
      margin-bottom: 20px;
    }
    .success {
      font-size: 1.1rem;
      color: #333;
      margin-bottom: 20px;
    }
    .btn {
      display: inline-block;
      background: #007BFF;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      cursor: pointer;
    }
    .btn:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
<div class="container">
  <h1>Thank you!</h1>
  <p class="success">Your feedback has been submitted and is pending approval.</p>
  <p><a class="btn" href="<?= $base ?>/feedback/approved">View Approved Feedback</a></p>
</div>
</body>
</html>
