<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Read Users</title>
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

        @keyframes wiggle {
            0%, 100% { transform: rotate(-1deg); }
            50% { transform: rotate(1deg); }
        }

        .wiggle:hover {
            animation: wiggle 0.5s ease-in-out;
        }

        .doodle-button {
            border: 2px solid #60a5fa;
            border-radius: 10px;
            position: relative;
            transition: all 0.2s ease;
            background: white;
            z-index: 1;
        }

        .doodle-button::before {
            content: '';
            position: absolute;
            inset: -2px;
            border: 2px solid #93c5fd;
            border-radius: 12px;
            transform: rotate(1deg);
            transition: transform 0.2s ease;
            z-index: -1;
        }

        .doodle-button:hover::before {
            transform: rotate(-1deg);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 50;
        }

        .modal-content {
            position: relative;
            background: white;
            z-index: 51;
        }

        @keyframes slideDown {
            from { transform: translateY(-100px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }

        /* Add styles for notification */
        .notification {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 1rem;
            border-radius: 0.5rem;
            background: white;
            animation: slideDown 0.3s ease-out forwards;
            z-index: 100;
        }
    </style>
</head>
<body class="bg-blue-50/50 min-h-screen p-8">
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] === 'true'): ?>
    <div class="notification scribble-box hand-drawn text-green-600 slide-down">
        Friend successfully removed! ✓
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'true'): ?>
    <div class="notification scribble-box hand-drawn text-red-600 slide-down">
        Oops! Something went wrong ✗
    </div>
    <?php endif; ?>

    <div id="deleteModal" class="modal">
        <div class="modal-content max-w-md mx-auto mt-20 scribble-box p-6">
            <h2 class="hand-drawn text-2xl text-blue-600 mb-4">Are you sure?</h2>
            <p class="content text-slate-600 mb-6">Do you really want to remove this friend?</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteModal()"
                        class="hand-drawn text-blue-500 hover:text-blue-700 wiggle">
                    Cancel
                </button>
                <a id="deleteConfirmButton" href="#"
                class="hand-drawn text-red-500 hover:text-red-700 wiggle">
                    Yes, Remove
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="hand-drawn text-4xl text-blue-600 wiggle">
                ✎ User List
            </h1>

            <a href="create.php"
            class="doodle-button hand-drawn px-6 py-3 bg-white text-blue-600 
                    hover:bg-blue-50 transition-colors">
                + Add New Friend
            </a>
        </div>

        <div class="scribble-box bg-white p-6">
            <table class="w-full">
                <thead>
                    <tr class="hand-drawn text-lg text-blue-600">
                        <th class="pb-4 text-left">Name</th>
                        <th class="pb-4 text-left">Email</th>
                        <th class="pb-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="content">
                    <?php foreach ($users as $user): ?>
                        <tr class="border-b-2 border-blue-100/50">
                            <td class="py-3 text-blue-700"><?= htmlspecialchars($user['name']) ?></td>
                            <td class="py-3 text-blue-700"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="py-3 space-x-4">
                                <a href="update.php?id=<?= $user['id'] ?>"
                                class="hand-drawn text-blue-500 hover:text-blue-700 wiggle inline-block">
                                    ✎ Edit
                                </a>
                                <a href="#"
                                onclick="confirmDelete(<?= $user['id'] ?>)"
                                class="hand-drawn text-red-400 hover:text-red-600 wiggle inline-block">
                                    ✕ Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Auto-hide notifications after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 3000);
            });
        });

        const modal = document.getElementById('deleteModal');
        const deleteConfirmButton = document.getElementById('deleteConfirmButton');

        function confirmDelete(userId) {
            modal.style.display = 'block';
            deleteConfirmButton.href = `delete.php?id=${userId}`;
        }

        function closeDeleteModal() {
            modal.style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target === modal) {
                closeDeleteModal();
            }
        }
    </script>
</body>
</html>