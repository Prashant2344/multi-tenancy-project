<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Tenant</title>
</head>
<body>
    <h1>Create Tenant</h1>
    <form method="POST" action="{{ route('tenants.store') }}">
        @csrf
        <div>
            <label for="id">Workspace (ID):</label>
            <input type="text" name="id" id="id" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <button type="submit">Create</button>
    </form>
    <a href="{{ route('tenants.index') }}">Back to List</a>
</body>
</html> 