<?php
$plain_password = 'mypassword123'; // Change this to the desired password
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
echo "Hashed password for database: " . $hashed_password;
?>