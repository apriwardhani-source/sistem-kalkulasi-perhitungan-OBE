<?php
// generate_password.php
$password = '123456'; // Ganti jika ingin password lain
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Password: $password<br>";
echo "Hash: $hash";
?>