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
           <h4 class="warning-message"> 
            @if ($message = Session::get('warning'))
                {{ $message }}
           
            @endif 
        </h4>
            <div class="login-section">
                <form class="signup" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="fontuser">
                        <label><b>Email</b></label>
                        <input type="text" id="email"
                        placeholder="Enter Email"
                        name="email" class="@error('email') is-invalid @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <i class="fa fa-user fa-lg"></i>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="fontpassword">
                        <label><b>Password</b></label>
                        <input id="password" name="password" class="@error('password') is-invalid @enderror" type="password"
                        placeholder="Password"
                        name="uname" required>
                        <i class="fa fa-lock fa-lg"></i>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="checkbox" checked="checked" name="remember" id="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                        <button type="submit"  class="form-btn"> Login </button>
                        <!-- <a href="dashboard.html"><button type="submit"  class="form-btn"> Login </button></a> -->
                        </div> <!-- form-group// -->
                        
                    </form>
                    <span class="account-remember">Don't Have Account ? <a href="{{url('/register')}}">Register Now</a></span>
                </div>
            </div>
        </body>
    </html>  