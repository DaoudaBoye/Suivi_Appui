<?php
$password = "1111";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "Mot de passe : " . $password . "<br>";
echo "Mot de passe haché : " . $hashed_password;
