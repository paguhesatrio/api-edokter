<?php
// Koneksi ke database
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "sik"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk mengambil satu nilai dari database
function getOne($sql) {
    global $conn;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usere = $_POST['usere'];
    $passworde = $_POST['passworde'];

    // Query untuk cek login pada tabel admin
    $admin_query = "SELECT COUNT(admin.passworde) as count FROM admin WHERE admin.usere=AES_ENCRYPT('$usere','nur') AND admin.passworde=AES_ENCRYPT('$passworde','windi')";
    
    // Query untuk cek login pada tabel user
    $user_query = "SELECT COUNT(user.password) as count FROM user WHERE user.id_user=AES_ENCRYPT('$usere','nur') AND user.password=AES_ENCRYPT('$passworde','windi')";

    // Cek login pada tabel admin atau user
    if (getOne($admin_query) > 0 || getOne($user_query) > 0) {
        echo "Login berhasil";

    } else {
        echo "Login gagal";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Login</title>
</head>
<body>

<h2>Form Login</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Username: <input type="text" name="usere"><br><br>
    Password: <input type="password" name="passworde"><br><br>
    <input type="submit" name="submit" value="Login">
</form>

</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
