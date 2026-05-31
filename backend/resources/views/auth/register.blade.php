@extends('layouts.app')

@section('content')
<div class="sp-login-page">
    <div class="sp-login-left">
        <div class="sp-logo mb-4" style="color:#005746;">
            <div class="sp-logo-icon" style="background:#007f68;color:white;">
                <i class="bi bi-person-plus"></i>
            </div>
            <div>
                <div class="sp-logo-title">SmartPresence</div>
                <div class="sp-logo-subtitle" style="color:#7b8f8a;">Création de compte</div>
            </div>
        </div>

        <h1 class="sp-login-title">Créer un compte</h1>
        <p class="sp-subtitle fs-5 mt-3" style="max-width:560px;">
            L’inscription permet la création d’un accès utilisateur à la plateforme.
            Les rôles et les informations détaillées sont gérés par l’administration.
        </p>
    </div>

    <div class="d-flex align-items-center justify-content-center p-4">
        <div class="sp-login-card">
            <div class="text-center mb-4">
                <div class="sp-stat-icon sp-icon-green mx-auto mb-3">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h3 class="fw-bold mb-1">Inscription</h3>
                <p class="text-muted mb-0">Créer un nouveau compte</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nom complet</label>
                    <input id="name" type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autocomplete="name"
                           autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           required
                           autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
                    <input id="password-confirm" type="password"
                           class="form-control"
                           name="password_confirmation"
                           required
                           autocomplete="new-password">
                </div>

                <button type="submit" class="sp-btn w-100 justify-content-center">
                    <i class="bi bi-check2-circle"></i>
                    Créer le compte
                </button>

                <div class="text-center mt-4">
                    <span class="text-muted">Vous avez déjà un compte ?</span>
                    <a href="{{ route('login') }}" class="fw-bold" style="color:#007f68;">
                        Se connecter
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection