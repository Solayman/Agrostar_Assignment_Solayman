<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>agrostar.com.bd</title>
        
        <!-- CSS FILES -->
        <link rel="stylesheet"   href="{{asset('assets/plugins/font-awesome-4.7.0/css/font-awesome.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/login_registration.css')}}">
    </head>
    <body>
        
        <div class="container">
            <div class="login-section">
                <form class="signup" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="fontuser">
                        <label><b>Name</b></label>
                        <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                        placeholder="Enter Name"
                        name="uname" required>
                        <i class="fa fa-user fa-lg"></i>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="fontuser">
                        <label><b>Email</b></label>
                        <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Email">
                        <i class="fa fa-envelope"></i>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="fontuser">
                        <label><b>Password</b></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter Password">
                        <i class="fa fa-lock fa-lg"></i>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="fontpassword">
                        <label><b>Password</b></label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                        <i class="fa fa-lock fa-lg"></i>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" checked="checked"> Remember me
                        <button type="submit" class="form-btn"> Register Now </button>
                        </div> <!-- form-group// -->
                        
                    </form>
                    <span class="account-remember">Already Have Account ? <a href="{{url('/login')}}">Login Now</a></span>
                </div>
            </div>
        </body>
    </html>