<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Pulse | Real-Time Notifications</title>
    @vite('resources/js/app.js')
    <style>
        :root {
            --primary: #6366f1;
            --bg: #f8fafc;
            --text: #1e293b;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            margin: 0;
            padding-top: 50px;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        h2 { margin-top: 0; font-size: 1.5rem; font-weight: 700; color: #0f172a; }
        h3 { font-size: 1rem; margin-top: 2rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }

        /* Form Styling */
        #taskForm { display: flex; gap: 10px; margin-top: 1rem; }
        
        input[type="text"] {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus { border-color: var(--primary); ring: 2px solid #c7d2fe; }

        button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.1s, opacity 0.2s;
        }

        button:active { transform: scale(0.95); }
        button:hover { opacity: 0.9; }

        /* Notification List */
        #notifications {
            margin-top: 1rem;
            max-height: 300px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .notification-card {
            background: #f1f5f9;
            padding: 12px 16px;
            border-radius: 10px;
            border-left: 4px solid var(--primary);
            animation: slideIn 0.3s ease-out;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .icon { font-size: 1.2rem; }
    </style>
</head>
<body>

<div class="container">
    <h2>Create New Task</h2>

    <form id="taskForm">
        <input type="text" id="title" placeholder="Enter task title..." required>
        <button type="submit">Add Task</button>
    </form>

    <h3>Live Activity Feed</h3>
    <div id="notifications">
        </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    if (window.Echo) {
        window.Echo.channel('tasks')
            .listen('.task.created', (e) => {
                const notifDiv = document.getElementById('notifications');
                const html = `
                    <div class="notification-card">
                        <span class="icon">🔔</span>
                        <span><strong>New Task:</strong> ${e.task.title}</span>
                    </div>
                `;
                notifDiv.insertAdjacentHTML('afterbegin', html);
            });
    }
});

// Existing Fetch code
document.getElementById('taskForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const titleInput = document.getElementById('title');
    
    fetch('/create-task', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ title: titleInput.value })
    });
    titleInput.value = ''; // Clear input
});
</script>

</body>
</html>