<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #f2f2f2;
    }

    .login-container {
        width: 300px;
        margin: 0 auto;
        margin: top 100px;
        padding: 45px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    h2 {
        text-align: center;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>

        <form class="auth-login-form mt-2" action="" method="POST" id="login-form">
            @csrf
            <label for="email">Email:</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                placeholder="email@example.com" aria-describedby="email" tabindex="1" autofocus
                value="{{ old('email') }}" />
            <div class="mb-1">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <input type="submit" value="Login">
            </div>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const loginForm = document.getElementById("login-form");

        loginForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formElement = document.getElementById("login-form");
            const formData = new FormData(formElement);

            // Serialize form data into a query string
            const serializedData = new URLSearchParams(formData).toString();

            // Make an API request to your server
            fetch("{{ route('login') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded", // Change to match your API's content type
                    },
                    body: serializedData,
                })
                .then(response => response.json())
                .then(response => {
                    if (response.code == 200) {
                        alert("Login successful!");
                        window.location.href = "{{ route('products.list') }}";
                    } else {
                        console.log(data);
                        alert("Login failed. Please check your credentials.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again later."); // Handle other errors
                });
        });
    });
    </script>
</body>

</html>