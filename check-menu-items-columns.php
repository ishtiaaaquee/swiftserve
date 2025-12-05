<?php
require 'config/database.php';
require 'classes/Database.php';
$db = Database::getInstance();
$cols = $db->fetchAll('DESCRIBE menu_items');
foreach($cols as $col) {
    echo $col['Field'] . "\n";
}
