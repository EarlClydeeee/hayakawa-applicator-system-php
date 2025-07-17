<?php
// Simple PHP backend to handle AJAX requests
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'getData':
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Data retrieved successfully',
                    'data' => [
                        'title' => 'Red Theme Dashboard',
                        'items' => ['Item 1', 'Item 2', 'Item 3', 'Item 4']
                    ]
                ]);
                break;
                
            case 'submitForm':
                $name = $data['name'] ?? '';
                $email = $data['email'] ?? '';
                
                if (!empty($name) && !empty($email)) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => "Thank you $name! We'll contact you at $email"
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Please fill in all fields'
                    ]);
                }
                break;
                
            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No action specified']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Theme Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a0000 0%, #330000 100%);
            color: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 40px 0;
            background: linear-gradient(135deg, #cc0000 0%, #990000 100%);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(204, 0, 0, 0.3);
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .card {
            background: linear-gradient(135deg, #660000 0%, #4d0000 100%);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(204, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 0, 0, 0.2);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(204, 0, 0, 0.4);
        }

        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #ff6666;
        }

        .card p {
            color: #ffcccc;
            line-height: 1.6;
        }

        .form-section {
            background: linear-gradient(135deg, #800000 0%, #660000 100%);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(204, 0, 0, 0.3);
            border: 1px solid rgba(255, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #ffcccc;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid rgba(255, 0, 0, 0.3);
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.2);
            color: #ffffff;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff3333;
            box-shadow: 0 0 0 3px rgba(255, 51, 51, 0.2);
        }

        .btn {
            background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 0, 0, 0.5);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #ffffff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .message {
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: 500;
        }

        .message.success {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid rgba(0, 255, 0, 0.3);
            color: #66ff66;
        }

        .message.error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #ff6666;
        }

        .data-list {
            list-style: none;
            margin-top: 15px;
        }

        .data-list li {
            padding: 10px;
            margin-bottom: 8px;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 6px;
            border-left: 4px solid #ff3333;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Red Theme Dashboard</h1>
            <p>Dynamic PHP Frontend with AJAX Integration</p>
        </div>

        <div class="dashboard">
            <div class="card">
                <h3>AJAX Data Loading</h3>
                <p>Click the button below to load data dynamically without page refresh.</p>
                <button class="btn" onclick="loadData()">Load Data</button>
                <div id="dataContainer"></div>
            </div>

            <div class="card">
                <h3>Real-time Updates</h3>
                <p>Experience seamless data updates with AJAX-powered interactions.</p>
                <div id="status">Ready to load data...</div>
            </div>

            <div class="card">
                <h3>Form Submission</h3>
                <p>Submit forms without page refresh using AJAX technology.</p>
                <button class="btn" onclick="scrollToForm()">Go to Form</button>
            </div>
        </div>

        <div class="form-section">
            <h3 style="margin-bottom: 20px; color: #ff6666;">AJAX Contact Form</h3>
            <form id="contactForm" onsubmit="submitForm(event)">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" class="btn" id="submitBtn">Send Message</button>
                <div id="formMessage"></div>
            </form>
        </div>
    </div>

    <script>
        function showMessage(containerId, message, type) {
            const container = document.getElementById(containerId);
            container.innerHTML = `<div class="message ${type}">${message}</div>`;
            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }

        function loadData() {
            const status = document.getElementById('status');
            const dataContainer = document.getElementById('dataContainer');
            
            status.innerHTML = '<div class="loading"></div>Loading data...';
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'getData' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    status.innerHTML = 'Data loaded successfully!';
                    
                    let html = '<ul class="data-list">';
                    data.data.items.forEach(item => {
                        html += `<li>${item}</li>`;
                    });
                    html += '</ul>';
                    
                    dataContainer.innerHTML = html;
                } else {
                    status.innerHTML = 'Error loading data';
                    showMessage('dataContainer', data.message || 'Failed to load data', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                status.innerHTML = 'Connection error';
                showMessage('dataContainer', 'Failed to connect to server', 'error');
            });
        }

        function submitForm(event) {
            event.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const formMessage = document.getElementById('formMessage');
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="loading"></div>Sending...';
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'submitForm',
                    name: name,
                    email: email
                })
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Send Message';
                
                if (data.status === 'success') {
                    showMessage('formMessage', data.message, 'success');
                    document.getElementById('contactForm').reset();
                } else {
                    showMessage('formMessage', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Send Message';
                showMessage('formMessage', 'Failed to send message. Please try again.', 'error');
            });
        }

        function scrollToForm() {
            document.querySelector('.form-section').scrollIntoView({ 
                behavior: 'smooth' 
            });
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Red Theme Dashboard loaded successfully');
        });
    </script>
</body>
</html>
