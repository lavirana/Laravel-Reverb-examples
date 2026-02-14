<form method="POST" action="/create-task">
    @csrf

    <input type="text" name="title" placeholder="Task title">

    <button type="submit">Create Task</button>
</form>
