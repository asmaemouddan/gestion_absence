@extends('layouts.app')

@section('content')
<div class="sp-login-page">

    <div class="sp-login-left">
        <div class="sp-logo mb-4" style="color:#005746;">
            <div class="sp-logo-icon" style="background:#007f68;color:white;">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div>
                <div class="sp-logo-title">SmartPresence</div>
                <div class="sp-logo-subtitle" style="color:#7b8f8a;">
                    Gestion des présences
                </div>
            </div>
        </div>

        <h1 class="sp-login-title">Bienvenue sur SmartPresence</h1>

        <p class="sp-subtitle fs-5 mt-3" style="max-width:550px;">
            Plateforme web dédiée à la gestion intelligente des présences,
            permettant le suivi des étudiants, des séances, des absences
            et des justifications de manière simple et efficace.
        </p>
    </div>

    <div class="d-flex align-items-center justify-content-center p-4">
        <div class="sp-login-card">
            <div class="text-center mb-4">
                <div class="sp-stat-icon sp-icon-green mx-auto mb-3">
                    <i class="bi bi-person-lock"></i>
                </div>
                <h3 class="fw-bold mb-1">Connexion</h3>
                <p class="text-muted mb-0">Accédez à votre espace</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">
                        Adresse email
                    </label>

                    <input id="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        Mot de passe
                    </label>

                    <input id="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           required
                           autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="remember"
                               id="remember"
                               {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            Se souvenir de moi
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="fw-bold"
                           style="color:#007f68;">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="sp-btn w-100 justify-content-center">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Se connecter
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
