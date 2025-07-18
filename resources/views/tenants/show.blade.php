<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tenant Details</title>
</head>
<body>
    <h1>Tenant Details</h1>
    <p><strong>ID:</strong> {{ $tenant->id }}</p>
    <p><strong>Email:</strong> {{ $tenant->email }}</p>
    <a href="{{ route('tenants.edit', $tenant) }}">Edit</a> |
    <a href="{{ route('tenants.index') }}">Back to List</a>
</body>
</html> 