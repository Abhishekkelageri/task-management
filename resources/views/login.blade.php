<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login/Register Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f4f4f4;
        }

        .form-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-toggle {
            display: flex;
            justify-content: space-between;
        }

        .toggle-btn {
            flex: 1;
            margin: 0;
        }

        .toggle-btn.active {
            background-color: #296cb6 !important; /* Blue background for active button */
            color: white !important;
        }

        .toggle-btn.inactive {
            background-color: white;
            color: #007bff;
        }

        a {
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            color: black;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="text-center">Welcome</h2>
                    <div class="form-toggle mb-3">
                        <button id="userLoginBtn" class="btn btn-primary toggle-btn active">Login as User</button>
                        <button id="adminLoginBtn" class="btn btn-secondary toggle-btn inactive">Login as Admin</button>
                    </div>

                    <!-- Login Form -->
                    <form id="loginForm">
                        <input type="hidden" id="roleType" name="role" value="0">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block toggle-btn active loginBtn">Login</button>
                        <p class="mt-2 text-center">Don't have an account? <a href="#" class="text-primary" id="showRegister">Register</a></p>
                    </form>

                    <!-- Registration Form -->
                    <form id="registerForm" action="{{ route('register') }}" method="POST" class="form d-none">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">
                                <input type="checkbox" id="role" name="role" value="1" class="mr-2"> Register as Admin
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block toggle-btn active">Register</button>
                        <p class="mt-2 text-center">Already have an account? <a href="#" class="text-primary" id="showLogin">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const userLoginBtn = document.getElementById("userLoginBtn");
        const adminLoginBtn = document.getElementById("adminLoginBtn");
        const loginForm = document.getElementById("loginForm");
        const registerForm = document.getElementById("registerForm");
        const showRegisterLink = document.getElementById("showRegister");
        const showLoginLink = document.getElementById("showLogin");

        userLoginBtn.addEventListener("click", () => {
            userLoginBtn.classList.add("active");
            userLoginBtn.classList.remove("inactive");
            adminLoginBtn.classList.remove("active");
            adminLoginBtn.classList.add("inactive");
            document.getElementById("roleType").value = 0;
        });

        adminLoginBtn.addEventListener("click", () => {
            adminLoginBtn.classList.add("active");
            adminLoginBtn.classList.remove("inactive");
            userLoginBtn.classList.remove("active");
            userLoginBtn.classList.add("inactive");
            document.getElementById("roleType").value = 1;
        });

        showRegisterLink.addEventListener("click", (event) => {
            event.preventDefault();
            loginForm.classList.add("d-none");
            registerForm.classList.remove("d-none");
        });

        showLoginLink.addEventListener("click", (event) => {
            event.preventDefault();
            registerForm.classList.add("d-none");
            loginForm.classList.remove("d-none");
        });

      
    </script>

    <script>
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

         $('body').on('submit', '#loginForm', function(e){
            e.preventDefault();
            const formData = {
                role: $('#roleType').val(),
                email: $('[name="email"]').val(),
                password: $('[name="password"]').val()
            };
            $.ajax({
                url: '/api/login',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                headers: {
                'X-CSRF-TOKEN': csrfToken
                }, 
                success: function(response) {
                    localStorage.setItem('authToken', response.token);
                    if(response.role == 1){
                        location.href = "/admin/dashboard";
                    }else{
                        location.href = "/user/dashboard";
                    }
                },
                error: function(error) {
                    alert('Login failed');
                }
            });
        });
    </script>
</body>
</html>