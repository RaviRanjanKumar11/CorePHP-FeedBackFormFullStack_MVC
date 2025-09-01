<?php $base = rtrim($this->config['app']['base_url'], '/'); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? 'Approved Feedback') ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 90%;
      max-width: 1000px;
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
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
      vertical-align: top;
    }
    th {
      background: #007BFF;
      color: #fff;
    }
    tr:nth-child(even) {
      background: #f9f9f9;
    }
    p {
      text-align: center;
      font-style: italic;
      color: #666;
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
  <h1>Approved Feedback</h1>
  <?php if (empty($items)): ?>
    <p>No approved feedback yet.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>When</th>
          <th>Name</th>
          <th>Rating</th>
          <th>Message</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['rating']) ?>/5</td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
