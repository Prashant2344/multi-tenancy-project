<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tenants</title>
</head>
<body>
    <h1>Tenants</h1>
    <a href="{{ route('tenants.create') }}">Create New Tenant</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tenants as $tenant)
                <tr>
                    <td>{{ $tenant->id }}</td>
                    <td>{{ $tenant->email }}</td>
                    <td>
                        <a href="{{ route('tenants.show', $tenant) }}">View</a> |
                        <a href="{{ route('tenants.edit', $tenant) }}">Edit</a> |
                        <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 