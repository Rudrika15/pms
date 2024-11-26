<!DOCTYPE html>
<html>

<head>
    <title>Task Assigned</title>
</head>

<body>
    <h1>New Task Assigned to You</h1>
    <p>Dear {{ $task->user->name }},</p>
    <p>You have been assigned a new task: <strong>{{ $task->title }}</strong>.</p>
    <p><strong>Details:</strong> {{ $task->detail }}</p>
    <p><strong>Priority:</strong> {{ $task->priority }}</p>
    <p><strong>Deadline:</strong> {{ $task->deadline }}</p>
    <p><a class="btn btn-primary" href="pms.flipcodesolutions.com/tasks/{{ $task->id }}">View Task</a></p>
</body>

</html>
