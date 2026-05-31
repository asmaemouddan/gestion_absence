@extends('layouts.app')

@section('content')
<div class="sp-wrapper">
    <aside class="sp-sidebar">
        <div class="sp-logo">
            <div class="sp-logo-icon">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div>
                <div class="sp-logo-title">SmartPresence</div>
                <div class="sp-logo-subtitle">Administration</div>
            </div>
        </div>

        <div class="sp-user-box">
            <div class="sp-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="sp-user-name">{{ Auth::user()->name ?? 'Administrateur' }}</div>
                <div class="sp-user-role">Administrateur</div>
            </div>
        </div>

        <div class="sp-menu-label">Menu principal</div>

        <a href="{{ route('admin_dashboard') }}" class="sp-nav-link {{ request()->routeIs('admin_dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            <span>Tableau de bord</span>
        </a>

        <a href="{{ route('etudiants.index') }}" class="sp-nav-link {{ request()->routeIs('etudiants.*') ? 'active' : '' }}">
            <i class="bi bi-mortarboard"></i>
            <span>Étudiants</span>
        </a>

        <a href="{{ route('classes.index') }}" class="sp-nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>Classes</span>
        </a>

        <a href="{{ route('modules.index') }}" class="sp-nav-link {{ request()->routeIs('modules.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i>
            <span>Modules</span>
        </a>

        <a href="{{ route('professeurs.index') }}" class="sp-nav-link {{ request()->routeIs('professeurs.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i>
            <span>Professeurs</span>
        </a>

        <a href="{{ route('seances.index') }}" class="sp-nav-link {{ request()->routeIs('seances.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-event"></i>
            <span>Séances</span>
        </a>

        <a href="{{ route('presences.index') }}" class="sp-nav-link {{ request()->routeIs('presences.*') ? 'active' : '' }}">
            <i class="bi bi-check2-square"></i>
            <span>Présences</span>
        </a>

        <a href="{{ route('justifications.index') }}" class="sp-nav-link {{ request()->routeIs('justifications.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Justifications</span>
        </a>

        <div class="sp-logout">
            <a href="{{ route('logout') }}" class="sp-nav-link"
               onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>

            <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>

    <main class="sp-main">
        <div class="sp-topbar">
            <div>
                <h1 class="sp-title">@yield('page-title', 'Tableau de bord')</h1>
                <p class="sp-subtitle">@yield('page-subtitle', 'Gestion intelligente des présences')</p>
            </div>

            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                <span class="sp-badge sp-badge-info">
                    <i class="bi bi-shield-check"></i>
                    Admin
                </span>
                <div class="sp-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </div>

        <div class="sp-page">
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check2-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Veuillez vérifier les informations saisies.</strong>
                </div>
            @endif

            @yield('admin-content')
        </div>
    </main>
</div>
@endsection