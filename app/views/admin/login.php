<?php $base = rtrim($this->config['app']['base_url'], '/'); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? 'Admin Login') ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 400px;
      margin: 50px auto;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .nav {
      margin-bottom: 15px;
      text-align: center;
    }
    .nav a {
      margin: 0 10px;
      text-decoration: none;
      color: #007BFF;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
      font-size: 0.9rem;
    }
    .field {
      margin-bottom: 15px;
    }
    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
    .btn {
      width: 100%;
      padding: 10px;
      background: #007BFF;
      border: none;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      border-radius: 4px;
    }
    .btn:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="nav">
    <a href="<?= $base ?>/feedback/form">Submit Feedback</a>
    <a href="<?= $base ?>/feedback/approved">View Approved Feedback</a>
  </div>
  <h1>Admin Login</h1>
  <?php if (!empty($error)): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
  <form id="login-form" method="post" action="<?= $base ?>/admin/login" novalidate>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
    <div class="field">
      <label for="username">Username *</label>
      <input type="text" id="username" name="username" required>
      <div id="error_username" class="error"></div>
    </div>
    <div class="field">
      <label for="password">Password *</label>
      <input type="password" id="password" name="password" required>
      <div id="error_password" class="error"></div>
    </div>
    <button class="btn" type="submit">Login</button>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('login-form');
  if (!form) return;

  const fields = {
    username: {
      el: document.getElementById('username'),
      errorEl: document.getElementById('error_username'),
      validate: (v) => v.trim().length >= 3,
      message: 'Username must be at least 3 characters.'
    },
    password: {
      el: document.getElementById('password'),
      errorEl: document.getElementById('error_password'),
      validate: (v) => v.trim().length >= 5,
      message: 'Password must be at least 5 characters.'
    }
  };

  const showError = (f, ok) => {
    f.errorEl.textContent = ok ? '' : f.message;
  };

  Object.values(fields).forEach(f => {
    f.el.addEventListener('input', () => showError(f, f.validate(f.el.value)));
    f.el.addEventListener('blur', () => showError(f, f.validate(f.el.value)));
  });

  form.addEventListener('submit', (e) => {
    let valid = true;
    Object.values(fields).forEach(f => {
      const ok = f.validate(f.el.value);
      showError(f, ok);
      if (!ok) valid = false;
    });
    if (!valid) e.preventDefault();
  });
});
</script>
</body>
</html>
