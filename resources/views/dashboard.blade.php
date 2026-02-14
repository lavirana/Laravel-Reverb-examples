<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Dashboard</title>
    @vite('resources/js/app.js')
    <style>
        :root {
            --bg-dark: #0f172a;
            --card-bg: #1e293b;
            --accent: #8b5cf6;
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .dashboard-wrapper {
            width: 100%;
            max-width: 400px;
            background: var(--card-bg);
            padding: 30px;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 1.2rem;
            color: var(--text-dim);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        /* Task Counter Styling */
        .stat-card {
            background: rgba(139, 92, 246, 0.1);
            padding: 20px;
            border-radius: 20px;
            border: 1px dashed var(--accent);
            margin-bottom: 30px;
        }

        h2 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 400;
            color: var(--text-dim);
        }

        #taskCount {
            display: block;
            font-size: 4rem;
            font-weight: 800;
            color: var(--accent);
            text-shadow: 0 0 20px rgba(139, 92, 246, 0.4);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Scale animation when number updates */
        .pulse {
            transform: scale(1.2);
            color: #fff !important;
        }

        /* Form Styling */
        h3 {
            font-size: 1rem;
            margin-bottom: 15px;
            color: var(--text-main);
        }

        #taskForm {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        input[type="text"] {
            background: #0f172a;
            border: 1px solid #334155;
            padding: 14px;
            border-radius: 12px;
            color: white;
            outline: none;
            transition: border 0.3s;
        }

        input[type="text"]:focus {
            border-color: var(--accent);
        }

        button {
            background: var(--accent);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, background 0.3s;
        }

        button:hover {
            background: #7c3aed;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <h1>Analytics</h1>

    <div class="stat-card">
        <h2>Total Tasks</h2>
        <span id="taskCount">0</span>
    </div>

    <h3>Add Quick Task</h3>
    <form id="taskForm">
        <input type="text" id="title" placeholder="What needs to be done?" required>
        <button type="submit">Create Task</button>
    </form>
</div>

<script>
document.getElementById('taskForm').addEventListener('submit', function(e){
    e.preventDefault();
    const title = document.getElementById('title');

    fetch('/create-task', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ title: title.value })
    });
    title.value = '';
});

document.addEventListener("DOMContentLoaded", function () {
    if (window.Echo) {
        window.Echo.channel('dashboard')
            .listen('.dashboard.updated', (e) => {
                const counter = document.getElementById('taskCount');
                
                counter.innerText = e.totalTasks;
                counter.classList.add('pulse');
                
                setTimeout(() => {
                    counter.classList.remove('pulse');
                }, 300);
            });
    }
});
</script>

</body>
</html>