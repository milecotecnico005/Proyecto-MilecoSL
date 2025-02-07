@extends('layouts.clientlayout')

@section('content')

<style>
    .login{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        background-color: #ffffff;
        padding: 30px;
        width: 450px;
        border-radius: 20px;
        font-family: 'Poppins', sans-serif;
        background: rgba( 255, 255, 255, 0.2 );
        box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
        backdrop-filter: blur( 4px );
        -webkit-backdrop-filter: blur( 4px );
        border-radius: 10px;
        border: 1px solid rgba( 255, 255, 255, 0.18 );
        margin-bottom: 5rem
    }

    ::placeholder {
        font-family: 'Poppins', sans-serif;
    }

    .form button {
        align-self: flex-end;
    }

    .flex-column > label {
        color: #151717;
        font-weight: 600;
    }

    .inputForm {
        border: 1.5px solid #ecedec;
        border-radius: 10px;
        height: 50px;
        display: flex;
        align-items: center;
        padding-left: 10px;
        transition: 0.2s ease-in-out;
    }

    .input {
        margin-left: 10px;
        border-radius: 10px;
        border: none;
        width: 85%;
        height: 100%;
    }

    .input:focus {
        outline: none;
    }

    .inputForm:focus-within {
        border: 1.5px solid #2d79f3;
    }

    .flex-row {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
        justify-content: space-between;
    }

    .flex-row > div > label {
        font-size: 14px;
        color: black;
        font-weight: 400;
    }

    .span {
        font-size: 14px;
        margin-left: 5px;
        color: #2d79f3;
        font-weight: 500;
        cursor: pointer;
    }

    .button-submit {
        margin: 20px 0 10px 0;
        background-color: #151717;
        border: none;
        color: white;
        font-size: 15px;
        font-weight: 500;
        border-radius: 10px;
        height: 50px;
        width: 100%;
        cursor: pointer;
    }

    .button-submit:hover {
        background-color: #252727;
    }

    .p {
        text-align: center;
        color: black;
        font-size: 14px;
        margin: 5px 0;
    }

    .btn {
        margin-top: 10px;
        width: 100%;
        height: 50px;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 500;
        gap: 10px;
        border: 1px solid #ededef;
        background-color: white;
        cursor: pointer;
        transition: 0.2s ease-in-out;
    }

    .btn:hover {
        border: 1px solid #2d79f3;
    }

    .loginBtnDisabled {
        background-color: #b3b3b3;
        cursor: not-allowed;
    }
</style>

<section class="section login">
    <form id="loginForm" class="form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="flex-column">
          <label>Email </label></div>
          <div class="inputForm">
            <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg"><g id="Layer_3" data-name="Layer 3"><path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path></g></svg>
            <input 
                type="email" 
                name="email" 
                class="input @error('email') is-invalid @enderror"
                value="{{ old('email') }}" 
                placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
          </div>
          @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
        
        <div class="flex-column">
          <label>Password </label></div>
          <div class="inputForm">
            <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path></svg>        
            <input type="password" name="password" class="input @error('password') is-invalid @enderror"
            placeholder="{{ __('adminlte::adminlte.password') }}">
          </div>
          @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        
        <div class="flex-row">
          <span class="span">
            <a href="{{ route('password.request') }}">Olvidaste tu contraseña?</a>
          </span>
        </div>

        <button id="loginBtn" class="button-submit">Inicia sesión</button>

        <script>
            const loginBtn = document.getElementById('loginBtn');
            const email = document.querySelector('input[name="email"]');
            const password = document.querySelector('input[name="password"]');
            const btn = document.querySelector('.button-submit');
            const form = document.getElementById('loginForm');

            email.addEventListener('input', () => {

                const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

                if (email.value.length > 0 && password.value.length > 0) {
                    btn.classList.remove('loginBtnDisabled');
                } else {
                    btn.classList.add('loginBtnDisabled');
                }

                if (regex.test(email.value)) {
                    email.style.border = '1.5px solid #2d79f3';
                } else {
                    email.style.border = '1.5px solid #ff0000';
                }

            });

            password.addEventListener('input', () => {

                if (email.value.length > 0 && password.value.length > 0) {
                    btn.classList.remove('loginBtnDisabled');
                } else {
                    btn.classList.add('loginBtnDisabled');
                }

            });

            btn.addEventListener('click', () => {

                // validar email
                const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

                if (!regex.test(email.value)) {
                    email.style.border = '1.5px solid #ff0000';
                    return;
                }

                if (btn.classList.contains('loginBtnDisabled')) {
                    return;
                } else {
                    btn.classList.add('loginBtnDisabled');
                    btn.innerHTML = 'Iniciando sesión...';
                    btn.style.cursor = 'not-allowed';
                    btn.disabled = true;
                    form.submit();
                    setTimeout(() => {
                        btn.innerHTML = 'Inicia sesión';
                        btn.style.cursor = 'pointer';
                        btn.disabled = false;
                        btn.classList.remove('loginBtnDisabled');
                    }, 3000);
                }
            });

        </script>
    
    </div>
</form>
</section

@stop
