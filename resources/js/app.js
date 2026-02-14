import './bootstrap';

Echo.channel('tasks')
    .listen('.task.created', (e) => {
       // alert('New Task: ' + e.task.title);
    });
