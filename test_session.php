<?php
session_start();

if (!isset($_SESSION['test'])) {
    $_SESSION['test'] = 0;
}
$_SESSION['test']++;

echo "Session berjalan! Nilai test: " . $_SESSION['test'];
echo "<br><a href='test_session.php'>Refresh halaman ini</a>";
?>