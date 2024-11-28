<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PMS Flipcode</title>

    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/logoMini.png') }}" /> --}}
    <style>
        *,
        *::before,
        *::after {
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

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        main {
            display: grid;
            grid-template-columns: 45% 55%;
            place-items: center;
            background: #f6f6f6;
            width: min(700px, 95%);
            border-radius: 20px;
        }

        /* Left Side */

        .left-side {
            height: 100%;
            width: 100%;
            background-image: url(https://github.com/ecemgo/mini-samples-great-tricks/assets/13468728/64ef8d9a-9202-4543-b838-82f4c7c91ccf);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            pointer-events: none;
            border-radius: 20px 0 0 20px;
        }

        /* Right Side */

        .right-side {
            padding: 60px;
        }

        /* Button Group */

        .btn-group {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 5px;
            margin-bottom: 32px;
        }

        .btn-group .btn {
            display: flex;
            align-items: center;
            column-gap: 4px;
            width: max-content;
            font-size: 0.8rem;
            font-weight: 500;
            padding: 8px 6px;
            border: 2px solid #6b7280;
            border-radius: 5px;
            background-color: #f6f6f6;
            transform: scale(1);
            cursor: pointer;
            transition: transform 0.1s ease, background-color 0.5s, color 0.5s;
        }

        .btn-group .btn:active {
            transform: scale(0.97);
        }

        .btn-group .btn:hover {
            background-color: #000;
            color: #eee;
        }

        .btn img {
            width: 16px;
            height: 16px;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f6f6f6;
            border-radius: 50%;
            padding: 2px;
        }

        /* OR */

        .or {
            position: relative;
            text-align: center;
            margin-bottom: 24px;
            font-size: 1rem;
            font-weight: 600;
        }

        .or::before,
        .or::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #000;
        }

        .or::before {
            left: 0;
        }

        .or::after {
            right: 0;
        }

        /* Inputs and Labels */

        input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #ccc;
            outline: 0;
            border-radius: 5px;
            background-color: transparent;
            margin: 4px 0 18px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.5s;
        }

        input:focus {
            border: 2px solid #000;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-background-clip: text;
            -webkit-text-fill-color: #000;
            transition: background-color 5000s ease-in-out 0s;
        }

        label {
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Login Button */

        .login-btn {
            width: 100%;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 8px 24px;
            margin: 12px 0 24px;
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

        /* Links */

        .links {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        a:link,
        a:visited,
        a:hover,
        a:active {
            text-decoration: none;
        }

        a {
            color: #000;
            font-size: 0.88rem;
            font-weight: 600;
            letter-spacing: -1px;
            transition: all 0.4s ease;
        }

        a:hover {
            color: rgb(13, 133, 185);
        }
    </style>
</head>

<body>
    {{-- <div class="container-scroller ">
        <div class="container-fluid  page-body-wrapper full-page-wrapper">
            <div class="content-wrapperLogin d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-start p-5">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/images/logo.png') }}">
                            </div>

                            <form class="pt-3" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type="submit">Login </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div> --}}



    <main>
        <div class="left-side"></div>

        <div class="right-side">
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <label for="email">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <label for="password">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <button type="submit" class="login-btn">Login</button>
                <div class="links">
                    <a href="#">Forgot password?</a>
                    <a href="#">Do not have an account?</a>
                </div>
            </form>
        </div>
    </main>


    {{-- <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script> --}}

</body>

</html>
