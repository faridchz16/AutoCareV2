<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña | AutoCare</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            font-family:Arial, Helvetica, sans-serif;
            background:
                linear-gradient(135deg, rgba(8,20,47,.88), rgba(6,182,212,.45)),
                url("{{ asset('images/autocare/auth-bg.png') }}");
            background-size:cover;
            background-position:center;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
        }

        .auth-container{
            width:min(1250px,92%);
            display:grid;
            grid-template-columns:1fr 560px;
            gap:120px;
            align-items:center;
        }

        .auth-info h1{
            font-size:58px;
            line-height:1.05;
            margin-bottom:22px;
            font-weight:800;
        }

        .auth-info p{
            max-width:520px;
            color:#E2E8F0;
            font-size:18px;
            line-height:1.7;
        }

        .auth-card{
            margin-left:80px;
            background:rgba(8,20,47,.76);
            border:1px solid rgba(6,182,212,.28);
            border-radius:28px;
            padding:38px;
            box-shadow:0 30px 70px rgba(0,0,0,.35);
            backdrop-filter:blur(14px);
        }

        .auth-header{
            display:grid;
            grid-template-columns:1fr 85px;
            column-gap:25px;
            align-items:start;
            margin-bottom:30px;
        }

        .auth-text{
            display:contents;
        }


        .auth-header h2{
            grid-column:1;
            font-size:34px;
            color:#FFFFFF;
            margin:0;
            font-weight:800;
            line-height:1.15;
        }


        .auth-header .subtitle{
            grid-column:1 / 3;
            color:#CBD5E1;
            font-size:15px;
            margin-top:12px;
            margin-bottom:0;
            line-height:1.6;
            max-width:100%;
        }

        .auth-logo{
            grid-column:2;
            grid-row:1;
            width:85px;
            height:85px;
            object-fit:contain;
            transition:.3s;
            cursor:default;
        }

        .auth-logo:hover{
            transform:scale(1.05);
        }

        .form-group{
            margin-bottom:20px;
        }

        label{
            display:block;
            font-weight:700;
            margin-bottom:8px;
            color:#E2E8F0;
        }

        input{
            width:100%;
            padding:14px 16px;
            border-radius:14px;
            border:1px solid rgba(226,232,240,.25);
            background:rgba(255,255,255,.95);
            outline:none;
            font-size:15px;
            color:#0F172A;
        }

        input:focus{
            border-color:#06B6D4;
            box-shadow:0 0 0 4px rgba(6,182,212,.18);
        }

        .btn-auth{
            width:100%;
            border:none;
            border-radius:14px;
            padding:14px;
            background:#06B6D4;
            color:#071B2C;
            font-weight:800;
            cursor:pointer;
            transition:.3s;
        }

        .btn-auth:hover{
            background:#22D3EE;
            transform:translateY(-2px);
        }

        .auth-bottom{
            margin-top:22px;
            text-align:center;
            color:#CBD5E1;
            font-size:14px;
        }

        a{
            color:#22D3EE;
            text-decoration:none;
            font-weight:700;
        }

        .message{
            background:rgba(34,197,94,.14);
            border:1px solid rgba(34,197,94,.35);
            color:#BBF7D0;
            padding:12px;
            border-radius:12px;
            margin-bottom:18px;
            font-size:14px;
        }

        .error{
            background:rgba(239,68,68,.14);
            border:1px solid rgba(239,68,68,.35);
            color:#FECACA;
            padding:12px;
            border-radius:12px;
            margin-bottom:18px;
            font-size:14px;
        }

        @media(max-width:900px){
            body{
                padding:40px 0;
            }

            .auth-container{
                grid-template-columns:1fr;
                gap:30px;
            }

            .auth-card{
                margin-left:0;
            }

            .auth-info{
                text-align:center;
            }

            .auth-info h1{
                font-size:42px;
            }

            .auth-info p{
                margin:0 auto;
            }

            .auth-header{
                flex-direction:column;
                text-align:center;
                align-items:center;
            }


            .auth-logo{
                width:65px;
                height:65px;
                margin:18px 0 0;
            }
        }
    </style>
</head>
<body>

<div class="auth-container">

    <div class="auth-info">
        <h1>
            Recupera tu<br>
            contraseña
        </h1>

        <p>
            Ingresa tu correo electrónico y te enviaremos un enlace para que puedas restablecer tu contraseña de forma segura.
        </p>
    </div>

    <div class="auth-card">

        <div class="auth-header">

            <div class="auth-text">
                <h2>¿Olvidaste tu contraseña?</h2>
                <p class="subtitle">
                    No te preocupes. Escribe tu correo y recibirás las instrucciones para recuperar el acceso a tu cuenta.
                </p>
            </div>

            <img
                src="{{ asset('images/autocare/logo.png') }}"
                alt="AutoCare"
                class="auth-logo">

        </div>

        @if (session('status'))
            <div class="message">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error">
                Revisa el correo ingresado e inténtalo nuevamente.
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Correo electrónico</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus>
            </div>

            <button type="submit" class="btn-auth">
                Enviar enlace de recuperación
            </button>
        </form>

        <div class="auth-bottom">
            ¿Recordaste tu contraseña?
            <a href="{{ route('login') }}">Iniciar sesión</a>
        </div>

    </div>

</div>

</body>
</html>