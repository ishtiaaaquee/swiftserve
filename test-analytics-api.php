<?php
session_start();

// Set admin session for testing
$_SESSION['logged_in'] = true;
$_SESSION['email'] = 'admin@gmail.com';
$_SESSION['is_admin'] = true;

echo "<h2>Testing Admin Analytics API</h2>";

// Make a direct call to the analytics API
$url = 'http://localhost/swiftserve/api/admin/analytics.php';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p>HTTP Code: $httpCode</p>";
echo "<h3>Response:</h3>";
echo "<pre>";
echo htmlspecialchars($response);
echo "</pre>";

echo "<h3>Decoded JSON:</h3>";
echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";
?>
