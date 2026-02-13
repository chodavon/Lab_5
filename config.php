<?php
// config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'security_demo');
define('DB_USER', 'root'); 
define('DB_PASS', 'yourpassword'); // The sensitive part
define('LOCKOUT_TIME_MINUTES', 1);
define('MAX_ATTEMPTS', 3);
// ... other application settings ...
?>