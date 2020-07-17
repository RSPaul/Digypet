@extends('layouts.app')
@section('content')
<section class="signbg">
   <div class="container">
      <div class="row">
         <div class="col-lg-6 mx-auto">
            <h1>Sign up</h1>
            <div class="btnpart">
               <a href="#" class="btn btn-primary googlebtn">Sign up with Google</a>
               <a href="#" class="btn btn-primary facebtn">Sign up with Facebook</a>
            </div>
            <div class="or">or</div>
            <form method="POST" action="{{ route('register') }}">
               @csrf
               <div class="formsign">
                  <div class="form-group">
                     <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>        
                     @error('first_name')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror               
                  </div>
                  <div class="form-group">
                     <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name" value="{{ old('last_name') }}" required autocomplete="first_name" autofocus>   
                     @error('last_name')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror                     
                  </div>
                  <div class="form-group cityform">
                     <input type="text" name="city" placeholder="City" class="form-control  @error('city') is-invalid @enderror citycls" required autocomplete="city" autofocus value="{{ old('city') }}">  
                     @error('city')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror  
                     <select class="form-control @error('last_name') is-invalid @enderror statecls">
                        <option>State</option>
                     </select>
                     @error('state')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror  
                     <input type="text" name="zip" placeholder="Zip" class="form-control @error('zip') is-invalid @enderror zipcls" required autocomplete="zip" autofocus value="{{ old('zip') }}">   
                     @error('zip')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror                 
                  </div>
                  <div class="form-group">  
                     <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Username/email">
                     @error('email')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a Password">
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                  </div>
                  <div class="form-group">
                     <p class="bysign">By signing up, <a href="#"> I agree to the Terms of Service </a>and the <a href=""> Privacy Policy </a> </p>
                  </div>
                  <div class="form-group mb-5">
                     <input type="submit" name="" value="Join" class="btn btn-primary joinbtn">
                     <input type="hidden" name="type" value="Provider">
                  </div>
                  <div class="form-group">
                     <p>Have an account? <a href="/login">Log in</a></p>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
@endsection