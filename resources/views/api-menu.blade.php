<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Menu</title>
    <!-- Using Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Direct Needs Program API Menu</h1>
        <p class="lead">Click the links below to test the different API endpoints.</p>
        <ul class="list-group">

            <!-- Test Endpoint -->
            <li class="list-group-item">
                <a href="{{ url('api/test') }}" target="_blank">
                    Test API Endpoint
                </a>
                <small class="text-muted">Returns a simple JSON response.</small>
            </li>

            <!-- Applications -->
            <li class="list-group-item">
                <a href="{{ url('api/applications') }}" target="_blank">
                    Applications Endpoint
                </a>
                <small class="text-muted">Handles CRUD operations for applications.</small>
            </li>

            <!-- Audit Logs -->
            <li class="list-group-item">
                <a href="{{ url('api/audit-logs') }}" target="_blank">
                    Audit Logs Endpoint
                </a>
                <small class="text-muted">Displays audit logs.</small>
            </li>

            <!-- Communications -->
            <li class="list-group-item">
                <a href="{{ url('api/communications') }}" target="_blank">
                    Communications Endpoint
                </a>
                <small class="text-muted">Handles communications such as approval letters.</small>
            </li>

            <!-- Diary Reminders -->
            <li class="list-group-item">
                <a href="{{ url('api/diary-reminders') }}" target="_blank">
                    Diary Reminders Endpoint
                </a>
                <small class="text-muted">Manages diary reminders and follow-ups.</small>
            </li>

            <!-- Expense Statements -->
            <li class="list-group-item">
                <a href="{{ url('api/expense-statements') }}" target="_blank">
                    Expense Statements Endpoint
                </a>
                <small class="text-muted">Manages expense statements and reporting.</small>
            </li>

            <!-- Notes -->
            <li class="list-group-item">
                <a href="{{ url('api/notes') }}" target="_blank">
                    Notes Endpoint
                </a>
                <small class="text-muted">Manages application notes and comments.</small>
            </li>

            <!-- Payments -->
            <li class="list-group-item">
                <a href="{{ url('api/payments') }}" target="_blank">
                    Payments Endpoint
                </a>
                <small class="text-muted">Processes payments and logs transactions.</small>
            </li>

            <!-- User Role Management -->
            <li class="list-group-item">
                <a href="{{ url('api/users') }}" target="_blank">
                    User Role Management
                </a>
                <small class="text-muted">View all users and their roles.</small>
            </li>
            <li class="list-group-item">
                <a href="{{ url('api/users/{id}/role') }}" target="_blank">
                    Update User Role
                </a>
                <small class="text-muted">Update user role by ID (use PUT method).</small>
            </li>

            <!-- Authentication Endpoints -->
            <li class="list-group-item">
                <a href="{{ url('api/login') }}" target="_blank">
                    Login Endpoint
                </a>
                <small class="text-muted">Authenticates users and generates tokens (POST).</small>
            </li>
            <li class="list-group-item">
                <a href="{{ url('api/logout') }}" target="_blank">
                    Logout Endpoint
                </a>
                <small class="text-muted">Logs out the user and revokes tokens (POST).</small>
            </li>
        </ul>
    </div>

    <!-- Bootstrap JS (Optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
