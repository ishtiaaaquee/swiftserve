<?php
session_start();

echo "<h2>Session Debug</h2>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n";
echo "Logged in: " . (isset($_SESSION['logged_in']) ? 'Yes' : 'No') . "\n";
echo "Email: " . (isset($_SESSION['email']) ? $_SESSION['email'] : 'Not set') . "\n";
echo "Is Admin: " . (isset($_SESSION['is_admin']) ? 'Yes' : 'No') . "\n";
echo "\nAll session data:\n";
print_r($_SESSION);
echo "</pre>";

echo "<h3>Admin Check Logic</h3>";
$isAdmin = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && 
           isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

echo "<p>First check result: " . ($isAdmin ? 'TRUE' : 'FALSE') . "</p>";

if (!$isAdmin) {
    if (isset($_SESSION['email']) && $_SESSION['email'] === 'admin@gmail.com') {
        echo "<p>Email matches admin@gmail.com - would set is_admin to true</p>";
    } else {
        echo "<p>Email does NOT match admin@gmail.com</p>";
    }
}
?>
