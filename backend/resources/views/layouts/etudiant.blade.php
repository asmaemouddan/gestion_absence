@extends('layouts.app')

@section('content')
<div class="sp-wrapper">
    <aside class="sp-sidebar">
        <div class="sp-logo">
            <div class="sp-logo-icon">
                <i class="bi bi-mortarboard"></i>
            </div>
            <div>
                <div class="sp-logo-title">SmartPresence</div>
                <div class="sp-logo-subtitle">Espace étudiant</div>
            </div>
        </div>

        <div class="sp-user-box">
            <div class="sp-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'E', 0, 1)) }}
            </div>
            <div>
                <div class="sp-user-name">{{ Auth::user()->name ?? 'Étudiant' }}</div>
                <div class="sp-user-role">Étudiant</div>
            </div>
        </div>

        <div class="sp-menu-label">Menu</div>

        <a href="{{ route('etudiant_dashboard') }}" class="sp-nav-link {{ request()->routeIs('etudiant_dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            <span>Tableau de bord</span>
        </a>

<a href="{{ route('etudiant.justifications') }}"
   class="sp-nav-link {{ request()->routeIs('etudiant.justifications') ? 'active' : '' }}">
    <i class="bi bi-file-earmark-text"></i>
    <span>Justifications</span>
</a>
        <div class="sp-logout">
            <a href="{{ route('logout') }}" class="sp-nav-link"
               onclick="event.preventDefault(); document.getElementById('logout-form-etudiant').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>

            <form id="logout-form-etudiant" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>

    <main class="sp-main">
        <div class="sp-topbar">
            <div>
                <h1 class="sp-title">@yield('page-title', 'Tableau de bord')</h1>
                <p class="sp-subtitle">@yield('page-subtitle', 'Espace étudiant')</p>
            </div>

            <span class="sp-badge sp-badge-success">
                <i class="bi bi-mortarboard"></i>
                Étudiant
            </span>
        </div>

        <div class="sp-page">
            @yield('etudiant-content')
        </div>
    </main>
</div>
@endsection