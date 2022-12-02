@extends('layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-5">
    <form method="POST" action="{{route('login.auth')}}" class="card py-4 px-4">
        @csrf
        @if (Session::get('success'))
             <div class="alert alert-success w-75">
                 {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::get('fail'))
             <div class="alert alert-danger">
                 {{ Session::get('fail') }}
            </div>
        @endif
        @if (Session::get('notAllowed'))
             <div class="alert alert-danger">
                 {{ Session::get('notAllowed') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
       
        <div class="text-center mt-3 ">
            
            <b class="text-start">LOGIN</b>
        
        </div>
        <div class="position-relative mt-3 form-input">
            <label>Username</label>
            <input class="form-control" type="text" name="username">
            <i class="fas fa-user"></i>
        </div>
        <div class="position-relative mt-3 form-input">
            <label>Password</label>
            <input class="form-control" type="password" name="password">
            <i class="fas fa-lock"></i>
        </div>
        <button class="w-100 btn btn-lg mt-4 shadow-lg" type="submit" style="font-size: 70%"><i class="fas fa-long-arrow-right"> Login</i></button>
        <div class=" mt-5 d-flex justify-content-between align-items-center">
            <small>Tidak punya akun?</span><a href="{{route('register')}}" style="text-decoration: underline;"> Register Now! </a></small>
            {{-- <button type="submit" class="go-button"><i class="fas fa-long-arrow-right"></i></button> --}}
        </div>
    </form>
</div>
@endsection
