<h3>👥 Người dùng</h3>

<?php
$users = $conn->query("SELECT * FROM users");
?>

<table class="table">
<tr>
<th>ID</th>
<th>Tên</th>
<th>Email</th>
<th>Role</th>
</tr>

<?php while($u = $users->fetch_assoc()): ?>
<tr>
<td><?= $u['id'] ?></td>
<td><?= $u['name'] ?></td>
<td><?= $u['email'] ?></td>
<td><?= $u['role'] ?></td>
</tr>
<?php endwhile; ?>
</table>