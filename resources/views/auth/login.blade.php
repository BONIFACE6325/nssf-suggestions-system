<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSSF Tanzania - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --nssf-yellow: #FFD700;
            --nssf-maroon: #800000;
            --nssf-dark: #333333;
        }
        
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1566024287287-42f5d71dfb5f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            margin: auto;
            transform: scale(1.05);
        }
        
        .login-header {
            background: var(--nssf-maroon);
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
        }
        
        .login-header h3 {
            margin: 0;
            font-weight: 700;
            font-size: 28px;
        }
        
        .login-header p {
            margin: 8px 0 0;
            opacity: 0.9;
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--nssf-yellow);
        }
        
        .nssf-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            border: 3px solid var(--nssf-yellow);
        }
        
        .nssf-logo i {
            font-size: 45px;
            color: var(--nssf-maroon);
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--nssf-yellow);
            box-shadow: 0 0 0 0.3rem rgba(255, 215, 0, 0.25);
        }
        
        .input-group-text {
            background: var(--nssf-maroon);
            color: white;
            border: none;
            border-radius: 8px 0 0 8px !important;
            padding: 10px 15px;
        }
        
        .btn-login {
            background: var(--nssf-maroon);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            font-size: 18px;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            background: #600000;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .login-footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #666;
        }
        
        .login-footer a {
            color: var(--nssf-maroon);
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            border: none;
        }
        
        .alert-danger {
            background-color: #ffdfdf;
            color: #721c24;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .copyright {
            text-align: center;
            margin-top: 25px;
            color: white;
            font-size: 14px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }
        
        .form-check-input:checked {
            background-color: var(--nssf-maroon);
            border-color: var(--nssf-maroon);
        }
        
        .form-check-input:focus {
            border-color: var(--nssf-yellow);
            box-shadow: 0 0 0 0.25rem rgba(255, 215, 0, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <div class="nssf-logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>NSSF TANZANIA</h3>
                <p>Secure Member Login</p>
            </div>
            
            <div class="login-body">
                <!-- Example error message (remove in production) -->
                <div class="alert alert-danger" style="display: none;">
                    <i class="fas fa-exclamation-circle"></i> Invalid credentials provided.
                </div>
                
                <!-- Example success message (remove in production) -->
                <div class="alert alert-success" style="display: none;">
                    <i class="fas fa-check-circle"></i> Password reset successfully.
                </div>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
            </div>
            
            <div class="login-footer">
                Forgot your password? <a href="#">Reset here</a>
            </div>
        </div>
        
        <div class="copyright">
            &copy; {{ date('Y') }} National Social Security Fund Tanzania. All rights reserved.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>