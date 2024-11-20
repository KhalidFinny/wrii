<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);

    header("Location: read.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Friend</title>
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
            background: white;
            border: 2px solid #93c5fd;
            border-radius: 12px;
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
        }

        .doodle-input:focus {
            outline: none;
            border-color: #60a5fa;
            transform: rotate(-0.5deg);
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(-1deg); }
            50% { transform: rotate(1deg); }
        }

        .wiggle:hover {
            animation: wiggle 0.5s ease-in-out;
        }

        .doodle-button {
            position: relative;
            background: white;
            border: 2px solid #60a5fa;
            border-radius: 10px;
            z-index: 1;
            transition: all 0.2s ease;
        }

        .doodle-button::before {
            content: '';
            position: absolute;
            inset: -2px;
            border: 2px solid #93c5fd;
            border-radius: 12px;
            transform: rotate(1deg);
            z-index: -1;
            transition: transform 0.2s ease;
        }

        .doodle-button:hover::before {
            transform: rotate(-1deg);
        }

        .submit-button {
            background: #60a5fa;
            border: 2px solid #3b82f6;
            border-radius: 10px;
            position: relative;
            z-index: 1;
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
    </style>
</head>
<body class="bg-blue-50/50 min-h-screen p-8">
    <div class="max-w-md mx-auto">
        <h1 class="hand-drawn text-4xl text-blue-600 mb-8 wiggle">✎ Add New Friend</h1>
        
        <div class="scribble-box p-6">
            <form method="POST" class="space-y-6">
                <div>
                    <label for="name" class="hand-drawn text-lg text-blue-600 block mb-2">Name:</label>
                    <input type="text" name="name" id="name" required
                           class="doodle-input w-full p-3 content text-blue-700">
                </div>
                
                <div>
                    <label for="email" class="hand-drawn text-lg text-blue-600 block mb-2">Email:</label>
                    <input type="email" name="email" id="email" required
                           class="doodle-input w-full p-3 content text-blue-700">
                </div>

                <div class="flex justify-between items-center pt-4">
                    <a href="read.php" 
                       class="hand-drawn text-blue-500 hover:text-blue-700 wiggle">
                        ← Back to List
                    </a>
                    <button type="submit" 
                            class="submit-button hand-drawn px-6 py-2 text-white
                                   hover:bg-blue-600 transition-colors wiggle">
                        Add Friend ✎
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
