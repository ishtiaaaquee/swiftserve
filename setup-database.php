<?php
/**
 * Database Setup Script
 * Automatically creates database and imports schema + seed data
 */

header('Content-Type: application/json');

// Prevent caching
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

try {
    // Database configuration
    $host = 'localhost';
    $port = '3306';
    $dbname = 'swiftserve';
    $username = 'root';
    $password = '';
    
    $response = [
        'success' => false,
        'message' => '',
        'details' => []
    ];
    
    // Step 1: Connect to MySQL server (without database)
    try {
        $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $response['details'][] = 'Connected to MySQL server';
    } catch (PDOException $e) {
        throw new Exception('Cannot connect to MySQL: ' . $e->getMessage());
    }
    
    // Step 2: Create database if not exists
    try {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $response['details'][] = 'Database created/verified';
    } catch (PDOException $e) {
        throw new Exception('Cannot create database: ' . $e->getMessage());
    }
    
    // Step 3: Use the database
    $pdo->exec("USE $dbname");
    
    // Step 4: Execute schema SQL
    $schemaFile = __DIR__ . '/sql/schema.sql';
    if (!file_exists($schemaFile)) {
        throw new Exception('Schema file not found: ' . $schemaFile);
    }
    
    $schemaSql = file_get_contents($schemaFile);
    
    // Remove comments and split by delimiter
    $schemaSql = preg_replace('/--.*$/m', '', $schemaSql);
    $schemaSql = preg_replace('/\/\*.*?\*\//s', '', $schemaSql);
    
    // Handle DELIMITER changes
    $parts = preg_split('/DELIMITER\s+(.+)/i', $schemaSql, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    $currentDelimiter = ';';
    $statements = [];
    
    for ($i = 0; $i < count($parts); $i++) {
        if ($i % 2 == 0) {
            // SQL part
            $sql = trim($parts[$i]);
            if (!empty($sql)) {
                $tempStatements = explode($currentDelimiter, $sql);
                foreach ($tempStatements as $stmt) {
                    $stmt = trim($stmt);
                    if (!empty($stmt)) {
                        $statements[] = $stmt;
                    }
                }
            }
        } else {
            // New delimiter
            $currentDelimiter = trim($parts[$i]);
        }
    }
    
    // Execute each statement
    $tableCount = 0;
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (empty($statement) || $statement === 'USE swiftserve') {
            continue;
        }
        
        try {
            $pdo->exec($statement);
            if (stripos($statement, 'CREATE TABLE') !== false) {
                $tableCount++;
            }
        } catch (PDOException $e) {
            // Ignore errors for existing tables/triggers
            if (strpos($e->getMessage(), 'already exists') === false) {
                throw $e;
            }
        }
    }
    
    $response['details'][] = "Schema imported ($tableCount tables created)";
    
    // Step 5: Check if data already exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM restaurants");
    $existingRestaurants = $stmt->fetchColumn();
    
    if ($existingRestaurants > 0) {
        $response['details'][] = "Sample data already exists ($existingRestaurants restaurants)";
    } else {
        // Step 6: Import seed data
        $seedFile = __DIR__ . '/sql/seed.sql';
        if (!file_exists($seedFile)) {
            throw new Exception('Seed file not found: ' . $seedFile);
        }
        
        $seedSql = file_get_contents($seedFile);
        
        // Remove comments
        $seedSql = preg_replace('/--.*$/m', '', $seedSql);
        $seedSql = preg_replace('/\/\*.*?\*\//s', '', $seedSql);
        
        // Split into statements
        $seedStatements = explode(';', $seedSql);
        
        $insertCount = 0;
        foreach ($seedStatements as $statement) {
            $statement = trim($statement);
            if (empty($statement) || $statement === 'USE swiftserve') {
                continue;
            }
            
            try {
                $pdo->exec($statement);
                if (stripos($statement, 'INSERT INTO') !== false) {
                    $insertCount++;
                }
            } catch (PDOException $e) {
                // Log but continue
                error_log('Seed error: ' . $e->getMessage());
            }
        }
        
        $response['details'][] = "Sample data imported ($insertCount inserts)";
    }
    
    // Success!
    $response['success'] = true;
    $response['message'] = 'Database setup completed successfully!';
    
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);
