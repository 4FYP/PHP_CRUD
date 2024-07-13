<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_info";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['create'])) 
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "INSERT INTO user_info (User_name, User_email) VALUES ('$name', '$email')";
    $conn->query($sql);
}

if (isset($_POST['update'])) 
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "UPDATE user_info SET User_name='$name', User_email='$email' WHERE id=$id";
    $conn->query($sql);
}
if (isset($_POST['delete'])) 
{
    $id = $_POST['id'];
    $sql = "DELETE FROM user_info WHERE id=$id";
    $conn->query($sql);
}

// Read
$users = [];
$sql = "SELECT * FROM user_info";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User CRUD</title>
</head>
<body>
    <h2>Create User</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="create">Create</button>
    </form>

    <h2>Users</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['User_name']; ?></td>
            <td><?php echo $user['User_email']; ?></td>
            <td>
                <!-- Update Form -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <input type="text" name="name" value="<?php echo $user['User_name']; ?>" required>
                    <input type="email" name="email" value="<?php echo $user['User_email']; ?>" required>
                    <button type="submit" name="update">Update</button>
                </form>
                <!-- Delete Form -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
