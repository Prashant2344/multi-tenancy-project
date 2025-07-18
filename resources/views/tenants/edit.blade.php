<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Tenant</title>
</head>
<body>
    <h1>Edit Tenant</h1>
    <form method="POST" action="{{ route('tenants.update', $tenant) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="id">Workspace (ID):</label>
            <input type="text" name="id" id="id" value="{{ $tenant->id }}" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ $tenant->email }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
    <a href="{{ route('tenants.index') }}">Back to List</a>
</body>
</html> 