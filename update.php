<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $id]);

    header("Location: read.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Friend</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Urbanist:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .hand-drawn {
            font-family: 'Patrick Hand', cursive;
        }

        .content {
            font-family: 'Urbanist', sans-serif;
        }

        .scribble-box {
            position: relative;
            border: 2px solid #93c5fd;
            border-radius: 12px;
            background: white;
            z-index: 1;
        }

        .scribble-box::before {
            content: '';
            position: absolute;
            inset: -4px;
            border: 2px solid #bfdbfe;
            border-radius: 14px;
            transform: rotate(-0.5deg);
            z-index: -1;
        }

        .doodle-input {
            border: 2px solid #93c5fd;
            border-radius: 8px;
            transition: all 0.2s ease;
            background: white;
            position: relative;
            z-index: 2;
        }

        .doodle-input:focus {
            outline: none;
            border-color: #60a5fa;
            transform: rotate(-0.5deg);
        }

        .submit-button {
            position: relative;
            z-index: 2;
            background: #60a5fa;
            border: 2px solid #3b82f6;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .submit-button::before {
            content: '';
            position: absolute;
            inset: -2px;
            border: 2px solid #93c5fd;
            border-radius: 12px;
            transform: rotate(1deg);
            z-index: -1;
            transition: transform 0.2s ease;
        }

        .submit-button:hover::before {
            transform: rotate(-1deg);
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(-1deg); }
            50% { transform: rotate(1deg); }
        }

        .wiggle:hover {
            animation: wiggle 0.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-blue-50/50 min-h-screen p-8">
    <div class="max-w-md mx-auto">
        <h1 class="hand-drawn text-4xl text-blue-600 mb-8">✎ Update Friend</h1>

        <div class="scribble-box bg-white p-6">
            <form method="POST" class="space-y-6">
                <input type="hidden" name="id" value="<?=htmlspecialchars($user['id'])?>">

                <div>
                    <label for="name" class="hand-drawn text-lg text-blue-600 block mb-2">Name:</label>
                    <input type="text" name="name" id="name"
                           value="<?=htmlspecialchars($user['name'])?>" required
                           class="doodle-input w-full p-3 content">
                </div>

                <div>
                    <label for="email" class="hand-drawn text-lg text-blue-600 block mb-2">Email:</label>
                    <input type="email" name="email" id="email"
                        value="<?=htmlspecialchars($user['email'])?>" required
                        class="doodle-input w-full p-3 content">
                </div>

                <div class="flex justify-between pt-4">
                    <a href="read.php"
                    class="hand-drawn text-blue-500 hover:text-blue-700">
                        ← Back to List
                    </a>
                    <button type="submit"
                            class="submit-button hand-drawn px-6 py-2 text-white
                                hover:bg-blue-600 transition-colors wiggle">
                        Update Friend ✎
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
