<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Bcare</title>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            margin: 0; padding: 0;
            /* Using a fallback color in case the gif doesn't load */
            background: #f4f7fb url("{{ asset('assets/video/original-background.gif') }}") no-repeat center center fixed;
            background-size: cover;
        }
        /* Proper centering logic */
        .login-card-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        .login-main {
            width: 100%;
            max-width: 900px;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.1);
        }
        .login-logo-section {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .login-form-section {
            padding: 50px 40px;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
        @media (max-width: 991px) {
            .login-logo-section {
                border-bottom: 1px solid #eee;
                padding: 30px;
            }
            .login-form-section {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="login-card-wrapper">
            <div class="login-main shadow-lg">
                <div class="row m-0 h-100">
                    
                    <div class="col-lg-6 col-12 login-logo-section">
                        <div class="text-center">
                            <img src="{{ asset('assets/images/bjp.png') }}" class="img-fluid" style="max-width: 450px;" alt="Logo">
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 login-form-section">
                        <div>
                            <h4 class="text-center mb-1" style="color:#2a1570; font-weight: 700;">Admin Login</h4>
                            <p class="text-center text-muted mb-4 small">Enter your credentials to access the portal</p>

                            <form class="theme-form" method="POST" action="{{ route('admin.login.submit') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label font-weight-600">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-envelope text-muted"></i></span>
                                        <input class="form-control @error('email') is-invalid @enderror" 
                                               type="email" name="email" value="{{ old('email') }}" 
                                               required autofocus placeholder="admin@example.com">
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label font-weight-600">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-lock text-muted"></i></span>
                                        <input id="password" class="form-control @error('password') is-invalid @enderror" 
                                               type="password" name="password" required placeholder="*********">
                                        <span class="input-group-text py-0" style="cursor: pointer;" onclick="togglePassword()">
                                            <i id="toggleIcon" class="fa-solid fa-eye-slash font-14"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" type="submit" style="background:#2a1570; border:none;">
                                        Sign in to Portal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            let pass = document.getElementById("password");
            let icon = document.getElementById("toggleIcon");
            if (pass.type === "password") {
                pass.type = "text";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            } else {
                pass.type = "password";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            }
        }
    </script>
</body>
</html>