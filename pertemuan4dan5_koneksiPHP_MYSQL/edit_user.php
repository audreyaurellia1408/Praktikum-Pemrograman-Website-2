<?php
include 'koneksi.php';
$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("User tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form action="update_user.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo $data['username']; ?>" required><br><br>
        
        <label>Role:</label><br>
        <select name="role" required>
            <option value="admin" <?php if($data['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if($data['role'] == 'user') echo 'selected'; ?>>User</option>
        </select><br><br>
        
        <label>Password (kosongkan jika tidak diubah):</label><br>
        <input type="password" name="password"><br><br>
        
        <button type="submit">Update</button>
        <a href="5dashboard_admin.php">Batal</a>
    </form>
</body>
</html>
