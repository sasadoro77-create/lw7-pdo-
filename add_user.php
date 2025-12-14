<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\User;

$message = '';
$messageClass = '';
$name = '';
$email = '';
$nameError = '';
$emailError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    $user = new User();
    $result = $user->addUser($name, $email);
    
    if ($result['success']) {
        $message = $result['message'];
        $messageClass = 'success';
        $name = '';
        $email = '';
    } else {
        $message = $result['message'];
        $messageClass = 'error';
        
        if (strpos($message, 'Имя') !== false) {
            $nameError = $message;
        } elseif (strpos($message, 'Email') !== false) {
            $emailError = $message;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить пользователя</title>
    <style>
        /* Стили остаются без изменений */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .back-link {
            display: inline-block;
            background: #6c757d;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .back-link:hover {
            background: #5a6268;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .submit-btn {
            background: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .submit-btn:hover {
            background: #45a049;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .error-input {
            border-color: #dc3545 !important;
        }
        .error-text {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">← Назад к списку</a>
        <h1>Добавить нового пользователя</h1>
        
        <?php if ($message): ?>
            <div class="message <?php echo $messageClass; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" 
                       class="<?php echo $nameError ? 'error-input' : ''; ?>">
                <?php if ($nameError): ?>
                    <div class="error-text"><?php echo htmlspecialchars($nameError); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"
                       class="<?php echo $emailError ? 'error-input' : ''; ?>">
                <?php if ($emailError): ?>
                    <div class="error-text"><?php echo htmlspecialchars($emailError); ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="submit-btn">Добавить пользователя</button>
        </form>
    </div>
</body>
</html>