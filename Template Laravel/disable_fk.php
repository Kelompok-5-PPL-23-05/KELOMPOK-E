<?php
\ = new mysqli('127.0.0.1', 'root', '', 'erapor_pkbm');
if (\->connect_error) {
    die('Connect Error: ' . \->connect_error);
}
\->query('SET FOREIGN_KEY_CHECKS=0');
echo 'Foreign key checks disabled' . PHP_EOL;
\->close();
?>
