<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard - {{ tenant('id') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .tenant-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }
        .users-section {
            margin-bottom: 30px;
        }
        .user-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .user-email {
            color: #007bff;
            font-weight: bold;
        }
        .user-name {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            cursor: pointer;
            font-size: 14px;
            font-family: inherit;
        }
        .logout-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to {{ tenant('id') }} Dashboard</h1>
            <p>You are logged in as: <strong>{{ auth()->user()->name }}</strong></p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">{{ $users->count() }}</div>
                <div>Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ tenant('id') }}</div>
                <div>Tenant ID</div>
            </div>
        </div>

        <div class="tenant-info">
            <h3>Tenant Information</h3>
            <p><strong>Tenant ID:</strong> {{ tenant('id') }}</p>
            <p><strong>Domain:</strong> {{ request()->getHost() }}</p>
            <p><strong>Database:</strong> {{ config('database.connections.tenant.database') ?? 'tenant_' . tenant('id') }}</p>
        </div>

        <div class="users-section">
            <h3>Users in this Tenant</h3>
            @if($users->count() > 0)
                @foreach($users as $user)
                    <div class="user-card">
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-email">{{ $user->email }}</div>
                        <small>Created: {{ $user->created_at->format('M d, Y H:i') }}</small>
                    </div>
                @endforeach
            @else
                <p>No users found in this tenant.</p>
            @endif
        </div>

        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
