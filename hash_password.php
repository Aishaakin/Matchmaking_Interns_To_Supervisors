<?php
$plain_password = 'mypassword123'; 
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
echo "Hashed password for database: " . $hashed_password;
?>