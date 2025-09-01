<?php $base = rtrim($this->config['app']['base_url'], '/'); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? 'Error') ?></title>
  <link rel="stylesheet" href="<?= $base ?>/assets/css/style.css">
</head>
<body>
<div class="container">
  <h1>Oops!</h1>
  <p class="error"><?= htmlspecialchars($message ?? 'An error occurred.') ?></p>
  <p><a class="btn" href="<?= $base ?>/feedback/form">Back to form</a></p>
</div>
</body>
</html>
