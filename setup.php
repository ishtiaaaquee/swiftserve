<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwiftServe Database Setup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .setup-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .setup-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
        }
        .status-box {
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
        .warning { color: #ffc107; }
        .info { color: #17a2b8; }
        .btn-setup {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px 40px;
            font-size: 18px;
            border-radius: 10px;
        }
        .btn-setup:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-card">
            <h1 class="text-center mb-4">🗄️ SwiftServe Database Setup</h1>
            <p class="text-center text-muted mb-4">This will create and populate your database with sample data</p>

            <div class="alert alert-info">
                <strong>ℹ️ Before proceeding:</strong>
                <ul class="mb-0 mt-2">
                    <li>Ensure MySQL is running</li>
                    <li>Database name: <code>swiftserve</code></li>
                    <li>Default credentials: <code>root</code> / <code>(no password)</code></li>
                    <li>Edit <code>config/database.php</code> if your credentials differ</li>
                </ul>
            </div>

            <div class="text-center my-4">
                <button id="setupBtn" class="btn btn-primary btn-setup" onclick="runSetup()">
                    🚀 Run Database Setup
                </button>
            </div>

            <div id="statusBox" class="status-box" style="display: none;">
                <div id="statusMessages"></div>
            </div>

            <div id="successBox" class="alert alert-success" style="display: none;">
                <h5>✅ Setup Complete!</h5>
                <p class="mb-2">Your database has been created successfully. You can now:</p>
                <ul>
                    <li><a href="index.php" class="alert-link">Visit the homepage</a></li>
                    <li><a href="http://localhost/phpmyadmin" target="_blank" class="alert-link">View in phpMyAdmin</a></li>
                </ul>
                <hr>
                <small>
                    <strong>Sample Data Created:</strong><br>
                    • 8 Restaurants<br>
                    • 25+ Menu Items<br>
                    • 8 Payment Partners<br>
                    • 5 Deals & Offers<br>
                    • 6 FAQs
                </small>
            </div>
        </div>
    </div>

    <script>
        function addMessage(message, type = 'info') {
            const statusMessages = document.getElementById('statusMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = type;
            messageDiv.textContent = message;
            statusMessages.appendChild(messageDiv);
            statusMessages.scrollTop = statusMessages.scrollHeight;
        }

        async function runSetup() {
            const setupBtn = document.getElementById('setupBtn');
            const statusBox = document.getElementById('statusBox');
            const successBox = document.getElementById('successBox');
            const statusMessages = document.getElementById('statusMessages');

            // Reset
            statusMessages.innerHTML = '';
            statusBox.style.display = 'block';
            successBox.style.display = 'none';
            setupBtn.disabled = true;
            setupBtn.innerHTML = '⏳ Setting up...';

            try {
                addMessage('🔄 Starting database setup...', 'info');
                
                const response = await fetch('setup-database.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    addMessage('✅ ' + result.message, 'success');
                    
                    if (result.details) {
                        result.details.forEach(detail => {
                            addMessage('  → ' + detail, 'success');
                        });
                    }

                    setTimeout(() => {
                        successBox.style.display = 'block';
                        setupBtn.innerHTML = '✅ Setup Complete';
                    }, 500);
                } else {
                    addMessage('❌ Error: ' + result.message, 'error');
                    setupBtn.disabled = false;
                    setupBtn.innerHTML = '🔄 Retry Setup';
                }
            } catch (error) {
                addMessage('❌ Error: ' + error.message, 'error');
                setupBtn.disabled = false;
                setupBtn.innerHTML = '🔄 Retry Setup';
            }
        }
    </script>
</body>
</html>
