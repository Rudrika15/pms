<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PMS Flipcode</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Quicksand", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            background: #222431;
            padding: 40px 20px;
        }

        main {
            position: relative;
            display: grid;
            grid-template-columns: 45% 55%;
            align-items: center;
            width: min(700px, 95%);
            border-radius: 20px;
            overflow: hidden;

            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            /* Soft shadow */
        }

        .animated-border {
            top: -5px;
            left: -5px;
            border-radius: 25px;
            padding: 5px;
            pointer-events: none;
            background: linear-gradient(90deg, #ff6600, #4c4b4b, #ff6600, #4c4b4b);
            background-size: 300% 300%;
            animation: gradient-border 5s linear infinite;
        }

        @keyframes gradient-border {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Left Side */
        .left-side {
            height: 100%;
            background-image: url('{{ asset('assets/images/dashboard/image1.jpg') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;

        }

        /* Right Side */
        .right-side {
            position: relative;
            z-index: 1;
            padding: 60px;
            background: #f6f6f6;
        }

        input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: transparent;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 18px;
            transition: all 0.5s;
        }

        input:focus {
            border: 2px solid #000;
        }

        label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: block;
        }

        .login-btn {
            width: 100%;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 10px 0;
            margin-top: 12px;
            border: 2px solid #6b7280;
            border-radius: 5px;
            background-color: #f6f6f6;
            cursor: pointer;
            transition: all 0.5s;
        }

        .login-btn:hover {
            background-color: #000;
            color: #eee;
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        a {
            color: #000;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.4s ease;
        }

        a:hover {
            color: rgb(13, 133, 185);
        }
    </style>
</head>

<body>
    <main>
        {{-- <main class="animated-border"> --}}

        <div class="left-side"></div>

        <div class="right-side">
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <button type="submit" class="login-btn">Login</button>

                <div class="links">
                    <a href="#">Forgot password?</a>
                    <a href="#">Don't have an account?</a>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
