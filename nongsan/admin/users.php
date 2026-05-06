<h3>👥 Người dùng</h3>
<a href="?page=admin" class="btn btn-secondary mb-3">← Dashboard</a>
<?php
$users = $conn->query("SELECT * FROM users");
?>



<table class="table table-bordered table-hover text-center">
<tr>
    <th>ID</th>
    <th>Tên</th>
    <th>Email</th>
    <th>Role</th>
    <th>Hành động</th>
</tr>

<?php while($u = $users->fetch_assoc()): ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td><?= htmlspecialchars($u['name']) ?></td>
    <td><?= htmlspecialchars($u['email']) ?></td>

    <td>
        <?php if($u['role'] == 'admin'): ?>
            <span class="badge bg-danger">Admin</span>
        <?php else: ?>
            <span class="badge bg-success">User</span>
        <?php endif; ?>
    </td>

    <td>
        <a href="?page=edit_user&id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">✏️</a>

        <form method="POST" action="?page=delete_user" style="display:inline;">
            <input type="hidden" name="id" value="<?= $u['id'] ?>">
            <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa user?')">
                🗑️
            </button>
        </form>
    </td>
</tr>
<?php endwhile; ?>

</table>