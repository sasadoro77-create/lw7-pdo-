<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/User.php';

$user = new User();
$message = '';
$error = '';

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'add':
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            
            $result = $user->add($name, $email);
            
            if ($result['success']) {
                $message = htmlspecialchars($result['message']);
            } else {
                $error = implode('<br>', array_map('htmlspecialchars', $result['errors']));
            }
            break;
            
        case 'view':
            if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
                $userId = (int)$_POST['user_id'];
                $userData = $user->getById($userId);
                
                if ($userData !== null) {
                    $message = "Пользователь найден: " . htmlspecialchars($userData['name']);
                } else {
                    $error = "Пользователь с ID {$userId} не найден";
                }
            }
            break;
    }
}

// Получение всех пользователей
$allUsers = $user->getAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями</title>
 
</head>
<body>
    <div class="container">
        <h1>Управление пользователями</h1>
        
        <?php if ($message): ?>
            <div class="success"><?= $message ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="form-section">
            <h2>Добавить нового пользователя</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input type="text" id="name" name="name" required maxlength="100" placeholder="Введите имя">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required maxlength="255" placeholder="Введите email">
                </div>
                <button type="submit">Добавить пользователя</button>
            </form>
            
            <h3 style="margin-top: 30px;">Найти пользователя по ID</h3>
            <form method="POST">
                <input type="hidden" name="action" value="view">
                <div class="form-group">
                    <label for="user_id">ID пользователя:</label>
                    <input type="number" id="user_id" name="user_id" min="1" required placeholder="Введите ID">
                </div>
                <button type="submit">Найти</button>
            </form>
        </div>
        
        <div class="users-section">
            <h2>Список пользователей (<?= count($allUsers) ?>)</h2>
            
            <?php if (empty($allUsers)): ?>
                <p>В базе данных нет пользователей.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="25%">Имя</th>
                            <th width="35%">Email</th>
                            <th width="35%">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allUsers as $userData): ?>
                        <tr>
                            <td><?= htmlspecialchars((string)$userData['id']) ?></td>
                            <td><?= htmlspecialchars($userData['name']) ?></td>
                            <td><?= htmlspecialchars($userData['email']) ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="view">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars((string)$userData['id']) ?>">
                                    <button type="submit">Просмотр</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>