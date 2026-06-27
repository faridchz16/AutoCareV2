<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse | AutoCare</title>

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
                linear-gradient(135deg, rgba(8,20,47,.88), rgba(37,99,235,.48)),
                url("{{ asset('images/autocare/auth-bg.png') }}");
            background-size:cover;
            background-position:center;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
        }

        .auth-container{
            width:min(1250px, 92%);
            display:grid;
            grid-template-columns:1fr 480px;
            gap:120px;
            align-items:center;
        }

        .auth-info h1{
            font-size:62px;
            line-height:1.05;
            margin-bottom:22px;
            font-weight:800;
        }

        .auth-info p{
            max-width:560px;
            color:#E2E8F0;
            font-size:18px;
            line-height:1.7;
        }

        .auth-card{
            background:rgba(8,20,47,.76);
            border:1px solid rgba(6,182,212,.28);
            border-radius:28px;
            padding:34px;
            box-shadow:0 30px 70px rgba(0,0,0,.35);
            backdrop-filter:blur(14px);
        }

        .auth-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:28px;
            margin-bottom:28px;
        }

        .auth-text{
            flex:1;
        }

        .auth-header h2{
            font-size:36px;
            color:#FFFFFF;
            margin:0;
            font-weight:800;
        }

        .auth-header .subtitle{
            color:#CBD5E1;
            font-size:15px;
            margin-top:8px;
            margin-bottom:0;
        }

        .auth-logo{
            width:85px;
            height:85px;
            object-fit:contain;
            flex-shrink:0;
            transition:.3s;
        }

        .auth-logo:hover{
            transform:scale(1.05);
        }

        .form-group{
            margin-bottom:16px;
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
            margin-top:8px;
        }

        .btn-auth:hover{
            background:#22D3EE;
            transform:translateY(-2px);
        }

        .auth-bottom{
            margin-top:20px;
            text-align:center;
            color:#CBD5E1;
            font-size:14px;
        }

        a{
            color:#22D3EE;
            text-decoration:none;
            font-weight:700;
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
            }

            .auth-logo{
                width:65px;
                height:65px;
            }
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-info">
        <h1>Crea tu<br>cuenta</h1>
        <p>
            Comienza una nueva experiencia con AutoCare. Regístrate y disfruta de una forma más inteligente,
            rápida y segura de gestionar el mantenimiento de tus vehículos.
        </p>
    </div>

    <div class="auth-card">

        <div class="auth-header">
            <div class="auth-text">
                <h2>Registrarse</h2>
                <p class="subtitle">
                    Completa tus datos para crear tu cuenta
                </p>
            </div>

            <img
                src="{{ asset('images/autocare/logo.png') }}"
                alt="Logo AutoCare"
                class="auth-logo">
        </div>

        @if ($errors->any())
            <div class="error">
                Revisa los campos del formulario e inténtalo nuevamente.
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nombre completo</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn-auth">
                Crear cuenta
            </button>
        </form>

        <div class="auth-bottom">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}">Inicia sesión</a>
        </div>

    </div>
</div>

</body>
</html>