<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use App\User;

$user = new User();
$users = $user->getAllUsers();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователи - База данных</title>
    <style>
        /* Стили остаются без изменений */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .add-user-link {
            display: inline-block;
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .add-user-link:hover {
            background: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .no-users {
            text-align: center;
            color: #666;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Список пользователей</h1>
        
        <a href="add_user.php" class="add-user-link">Добавить нового пользователя</a>
        
        <?php if (!empty($users)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $userRow): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($userRow['id']); ?></td>
                            <td><?php echo htmlspecialchars($userRow['name']); ?></td>
                            <td><?php echo htmlspecialchars($userRow['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-users">
                <p>Нет пользователей в базе данных.</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
