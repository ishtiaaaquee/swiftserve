<?php
/**
 * Test Order Creation API
 */

session_start();

// Simulate logged in user
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = 2; // Your user ID

// Test data
$testData = [
    'customerName' => 'Ishtiaque Ahmed',
    'customerPhone' => '01721346909',
    'address' => [
        'street' => 'Dhaka',
        'area' => 'Gulshan',
        'postalCode' => '1214'
    ],
    'deliveryInstructions' => 'Ring the doorbell',
    'paymentMethod' => 'cod',
    'items' => [
        [
            'id' => 1,
            'name' => 'Club Sandwich',
            'price' => 320,
            'quantity' => 1,
            'image' => 'assets/images/food1.jpg'
        ]
    ],
    'subtotal' => 320,
    'deliveryFee' => 60,
    'total' => 380
];

// Make a real HTTP request to the API
$url = 'http://localhost/swiftserve/api/orders/create.php';
$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n" .
                     "Cookie: PHPSESSID=" . session_id() . "\r\n",
        'method'  => 'POST',
        'content' => json_encode($testData)
    ]
];

$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);

echo "API Response:\n";
echo $response;
echo "\n\n";

$result = json_decode($response, true);
if ($result) {
    echo "Parsed Response:\n";
    print_r($result);
}
