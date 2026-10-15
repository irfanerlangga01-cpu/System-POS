<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ROHMAN PERCETAKAN DAN FOTOKOPY - Sistem Informasi Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #2563EB;
            --primary-dark: #1D4ED8;
            --primary-light: #3B82F6;
            --secondary: #64748B;
            --dark: #1E293B;
            --light: #F8FAFC;
            --white: #FFFFFF;
            --danger: #EF4444;
            --success: #10B981;
            --warning: #F59E0B;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F1F5F9;
        }
        
        .sidebar {
            min-height: 100vh;
            background: var(--white);
            width: 260px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #E2E8F0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }
        
        .sidebar-brand img {
            height: 42px;
            border-radius: 10px;
        }
        
        .sidebar-brand .brand-text {
            color: var(--white);
            font-size: 18px;
            font-weight: 700;
        }
        
        .sidebar-brand .brand-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 11px;
        }
        
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--secondary);
            padding: 12px 16px;
            border-radius: 10px;
            margin: 4px 12px;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
        }
        
        .sidebar .nav-link:hover {
            background: var(--light);
            color: var(--primary);
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .sidebar .nav-link i { width: 20px; text-align: center; }
        
        .navbar {
            background-color: var(--white);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .stat-card .icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .bg-primary-soft { background: rgba(79, 70, 229, 0.1); color: var(--primary); }
        .bg-success-soft { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .bg-warning-soft { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
        .bg-danger-soft { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
        
        .table thead th {
            background: #F8FAFC;
            border: none;
            font-weight: 600;
            color: var(--secondary);
            font-size: 12px;
            text-transform: uppercase;
            padding: 14px 16px;
        }
        
        .table tbody tr:hover {
            background: #F8FAFC;
        }
        
        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid #E2E8F0;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        }
        
        .btn-secondary {
            background: #E2E8F0;
            border: none;
            color: var(--secondary);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
        }
        
        .text-primary { color: var(--primary) !important; }
        
        .stok-rendah {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url("{{ asset('img/bg login.jpeg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
            padding: 20px;
        }
        
        .login-card {
            background: rgba(255,255,255,0.15);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            object-fit: contain;
            margin: 0 auto 24px;
        }
    </style>
</head>
<body>
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
</body>
</html>