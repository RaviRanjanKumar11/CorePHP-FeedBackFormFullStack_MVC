<?php $base = rtrim($this->config['app']['base_url'], '/'); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? 'Admin Dashboard') ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 95%;
      max-width: 1200px;
      margin: 30px auto;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .nav {
      margin-bottom: 20px;
      text-align: right;
    }
    .nav a {
      margin: 0 10px;
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
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
      padding: 8px;
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
    .badge {
      padding: 4px 8px;
      border-radius: 4px;
      color: #fff;
      font-size: 12px;
    }
    .badge.approved { background: #28a745; }
    .badge.rejected { background: #dc3545; }
    .badge.pending { background: #ffc107; color: #000; }
    .btn {
      display: inline-block;
      padding: 6px 12px;
      margin: 2px;
      text-decoration: none;
      border-radius: 4px;
      font-size: 14px;
      color: #fff;
    }
    .btn-approve { background: #28a745; }
    .btn-approve:hover { background: #218838; }
    .btn-reject { background: #dc3545; }
    .btn-reject:hover { background: #c82333; }
  </style>
</head>
<body>
<div class="container">
  <div class="nav">
    <a href="<?= $base ?>/admin/dashboard">Dashboard</a>
    <a href="<?= $base ?>/feedback/approved">Public Page</a>
    <a href="<?= $base ?>/admin/logout">Logout (<?= htmlspecialchars($_SESSION['admin_username'] ?? '') ?>)</a>
  </div>
  <h1>All Feedback</h1>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>When</th>
        <th>Name</th>
        <th>Email</th>
        <th>Rating</th>
        <th>Message</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $row): ?>
        <tr>
          <td><?= (int)$row['id'] ?></td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
          <td><?= htmlspecialchars($row['full_name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['rating']) ?>/5</td>
          <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
          <td><span class="badge <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars(ucfirst($row['status'])) ?></span></td>
          <td>
            <a class="btn btn-approve" href="<?= $base ?>/admin/approve?id=<?= (int)$row['id'] ?>&csrf_token=<?= htmlspecialchars($csrf_token) ?>">Approve</a>
            <a class="btn btn-reject" href="<?= $base ?>/admin/reject?id=<?= (int)$row['id'] ?>&csrf_token=<?= htmlspecialchars($csrf_token) ?>">Reject</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
