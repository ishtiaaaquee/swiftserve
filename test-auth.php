<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Authentication - SwiftServe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .test-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
        }
        .result-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 14px;
            max-height: 400px;
            overflow-y: auto;
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <div class="test-card">
            <h1 class="text-center mb-4">🧪 Authentication Test</h1>
            
            <div class="mb-4">
                <h5>Test Registration</h5>
                <button class="btn btn-primary" onclick="testRegistration()">
                    <i class="fas fa-user-plus me-2"></i>Test Register User
                </button>
            </div>

            <div class="mb-4">
                <h5>Test Login</h5>
                <button class="btn btn-success" onclick="testLogin()">
                    <i class="fas fa-sign-in-alt me-2"></i>Test Login
                </button>
            </div>

            <div class="mb-4">
                <h5>Check Database</h5>
                <button class="btn btn-info" onclick="checkDatabase()">
                    <i class="fas fa-database me-2"></i>Check Users in Database
                </button>
            </div>

            <div id="resultBox" class="result-box" style="display: none;">
                <div id="results"></div>
            </div>

            <hr>
            <div class="text-center">
                <a href="index.php" class="btn btn-outline-primary">
                    <i class="fas fa-home me-2"></i>Back to Homepage
                </a>
            </div>
        </div>
    </div>

    <script>
        function addResult(message, type = 'info') {
            const resultBox = document.getElementById('resultBox');
            const results = document.getElementById('results');
            resultBox.style.display = 'block';
            
            const msgDiv = document.createElement('div');
            msgDiv.className = type;
            msgDiv.textContent = message;
            results.appendChild(msgDiv);
        }

        function clearResults() {
            document.getElementById('results').innerHTML = '';
        }

        async function testRegistration() {
            clearResults();
            addResult('Testing user registration...', 'info');

            const testUser = {
                full_name: 'Test User ' + Date.now(),
                email: 'test' + Date.now() + '@example.com',
                phone: '01712345678',
                password: 'password123',
                confirm_password: 'password123'
            };

            try {
                const response = await fetch('api/auth/register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(testUser)
                });

                const result = await response.json();
                
                if (result.success) {
                    addResult('✅ Registration successful!', 'success');
                    addResult('User ID: ' + result.user.id, 'success');
                    addResult('Email: ' + result.user.email, 'success');
                    addResult('Name: ' + result.user.full_name, 'success');
                } else {
                    addResult('❌ Registration failed: ' + result.message, 'error');
                }
            } catch (error) {
                addResult('❌ Network error: ' + error.message, 'error');
            }
        }

        async function testLogin() {
            clearResults();
            addResult('Testing login...', 'info');

            try {
                const response = await fetch('api/auth/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: 'admin@gmail.com',
                        password: '12345678'
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    addResult('✅ Login successful!', 'success');
                    addResult('User: ' + result.user.full_name, 'success');
                    addResult('Email: ' + result.user.email, 'success');
                } else {
                    addResult('❌ Login failed: ' + result.message, 'error');
                }
            } catch (error) {
                addResult('❌ Network error: ' + error.message, 'error');
            }
        }

        async function checkDatabase() {
            clearResults();
            addResult('Checking database for users...', 'info');

            try {
                const response = await fetch('check-users.php');
                const result = await response.json();
                
                if (result.success) {
                    addResult('✅ Found ' + result.count + ' users in database', 'success');
                    
                    if (result.users && result.users.length > 0) {
                        addResult('--- Recent Users ---', 'info');
                        result.users.forEach(user => {
                            addResult(`ID: ${user.id} | ${user.full_name} | ${user.email}`, 'info');
                        });
                    }
                } else {
                    addResult('❌ Database check failed: ' + result.message, 'error');
                }
            } catch (error) {
                addResult('❌ Network error: ' + error.message, 'error');
            }
        }
    </script>
</body>
</html>
