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
            /* Animated background gif asset */
            background: url("{{ asset('assets/video/original-background.gif') }}") no-repeat center center fixed;
            background-size: cover;
        }
        .login-card { min-height: 100vh; display: flex; align-items: center; }
        .theme-form { max-width: 850px; }
    </style>
</head>
<body>
    <div class="page-body-wrapper">
        <div class="container-fluid">
            <div class="row m-0">
                <div class="col-lg-12 col-sm-12">
                    <div class="login-card p-3">
                        <div class="theme-form col-md-9 p-4 shadow" style="background:white; border:1px solid #00000047; border-radius:10px; margin:auto;">
                            <div class="d-flex row align-items-center">
                                
                                <div class="col-lg-6 col-12 mb-3 border-end">
                                    <div class="d-flex flex-column gap-1 align-items-center justify-content-center text-center">
                                        <img src="{{ asset('assets/images/BBMPlogo.png') }}" width="25%" alt="Logo">
                                        <h3 class="text-dark fw-bold mt-2">B care</h3>
                                        <p class="text-muted">Administrator Portal</p>
                                        <img src="{{ asset('assets/images/logo/logo-icon.jpg') }}" width="15%" alt="Icon">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12">
                                    <h4 class="text-center mb-4" style="color:#2a1570;">Admin Login</h4>

                                    <form class="theme-form login-form" method="POST" action="{{ route('admin.login.submit') }}">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label class="form-label">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                                <input class="form-control @error('email') is-invalid @enderror" 
                                                       type="email" name="email" value="{{ old('email') }}" 
                                                       required autofocus placeholder="admin@example.com">
                                                
                                                @error('email')
                                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                <input id="password" class="form-control @error('password') is-invalid @enderror" 
                                                       type="password" name="password" required placeholder="*********">
                                                
                                                <span class="input-group-text" onclick="togglePassword()" style="background: #f8f9fa;">
                                                    <i id="toggleIcon" class="fa-solid fa-eye-slash" style="cursor:pointer;"></i>
                                                </span>

                                                @error('password')
                                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <button class="btn btn-primary btn-block w-100 py-2 fw-bold" type="submit">
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