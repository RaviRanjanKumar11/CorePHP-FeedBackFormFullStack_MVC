<?php $base = rtrim($this->config['app']['base_url'], '/'); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? 'Submit Feedback') ?></title>
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
      margin: 30px auto;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .nav {
      margin-bottom: 20px;
      text-align: center;
    }
    .nav a {
      margin: 0 10px;
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
    }
    .nav a:hover {
      text-decoration: underline;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    .field {
      margin-bottom: 15px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    input, select, textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    textarea {
      resize: vertical;
    }
    .btn {
      display: inline-block;
      background: #007BFF;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn:hover {
      background: #0056b3;
    }
    .error {
      color: red;
      font-size: 0.9rem;
      margin-top: 4px;
    }
    #message_counter {
      font-size: .85rem;
      color: #555;
      margin-top: .25rem;
      text-align: right;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="nav">
    <a href="<?= $base ?>/feedback/form">Submit Feedback</a>
    <a href="<?= $base ?>/feedback/approved">View Approved Feedback</a>
    <a href="<?= $base ?>/admin/login">Admin</a>
  </div>
  <h1>Submit Feedback</h1>
  <form id="feedback-form" method="post" action="<?= $base ?>/feedback/submit" novalidate>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
    <div class="field">
      <label for="full_name">Full Name *</label>
      <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($old['full_name'] ?? '') ?>" required minlength="3" pattern="[A-Za-z ]+">
      <div id="error_full_name" class="error"><?= htmlspecialchars($errors['full_name'] ?? '') ?></div>
    </div>
    <div class="field">
      <label for="email">Email *</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
      <div id="error_email" class="error"><?= htmlspecialchars($errors['email'] ?? '') ?></div>
    </div>
    <div class="field">
      <label for="rating">Rating (1-5) *</label>
      <select id="rating" name="rating" required>
        <option value="">Select</option>
        <?php for ($i=1; $i<=5; $i++): ?>
          <option value="<?= $i ?>" <?= (isset($old['rating']) && (int)$old['rating']===$i) ? 'selected' : '' ?>><?= $i ?></option>
        <?php endfor; ?>
      </select>
      <div id="error_rating" class="error"><?= htmlspecialchars($errors['rating'] ?? '') ?></div>
    </div>
    <div class="field">
      <label for="message">Message *</label>
      <textarea id="message" name="message" rows="4" maxlength="250" required><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
      <div id="message_counter"><?= isset($old['message']) ? strlen($old['message']) : 0 ?>/250</div>
      <div id="error_message" class="error"><?= htmlspecialchars($errors['message'] ?? '') ?></div>
    </div>
    <button class="btn" type="submit">Submit</button>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('feedback-form');
  if (!form) return;

  const fields = {
    full_name: {
      el: document.getElementById('full_name'),
      errorEl: document.getElementById('error_full_name'),
      validate: (v) => v.trim().length >= 3 && /^[A-Za-z ]+$/.test(v.trim()),
      message: 'Full name must be at least 3 characters and letters/spaces only.'
    },
    email: {
      el: document.getElementById('email'),
      errorEl: document.getElementById('error_email'),
      validate: (v) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()),
      message: 'Please enter a valid email address.'
    },
    rating: {
      el: document.getElementById('rating'),
      errorEl: document.getElementById('error_rating'),
      validate: (v) => ['1','2','3','4','5'].includes(v),
      message: 'Please select a rating between 1 and 5.'
    },
    message: {
      el: document.getElementById('message'),
      errorEl: document.getElementById('error_message'),
      validate: (v) => v.trim().length > 0 && v.length <= 250 && /^[A-Za-z0-9 .,!?;:'"()\\-\\n\\r]+$/.test(v),
      message: 'Message up to 250 chars; letters, numbers, spaces, punctuation.'
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

  // live counter
  const counter = document.getElementById('message_counter');
  if (counter) {
    fields.message.el.addEventListener('input', () => {
      counter.textContent = fields.message.el.value.length + "/250";
    });
  }
});
</script>
</body>
</html>
