@extends('layouts.app')

@section('content')
<div class="sp-wrapper">
    <aside class="sp-sidebar">
        <div class="sp-logo">
            <div class="sp-logo-icon">
                <i class="bi bi-person-badge"></i>
            </div>
            <div>
                <div class="sp-logo-title">SmartPresence</div>
                <div class="sp-logo-subtitle">Espace professeur</div>
            </div>
        </div>

        <div class="sp-user-box">
            <div class="sp-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
            </div>
            <div>
                <div class="sp-user-name">{{ Auth::user()->name ?? 'Professeur' }}</div>
                <div class="sp-user-role">Professeur</div>
            </div>
        </div>

      <div class="sp-menu-label">Menu</div>

<a href="{{ route('professeur_dashboard') }}"
   class="sp-nav-link {{ request()->routeIs('professeur_dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid-1x2"></i>
    <span>Tableau de bord</span>
</a>

<a href="{{ route('professeur.presences') }}"
   class="sp-nav-link {{ request()->routeIs('professeur.presences') ? 'active' : '' }}">
    <i class="bi bi-check2-square"></i>
    <span>Présences</span>
</a>

        <div class="sp-logout">
            <a href="{{ route('logout') }}" class="sp-nav-link"
               onclick="event.preventDefault(); document.getElementById('logout-form-professeur').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>

            <form id="logout-form-professeur" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>

    <main class="sp-main">
        <div class="sp-topbar">
            <div>
                <h1 class="sp-title">@yield('page-title', 'Tableau de bord')</h1>
                <p class="sp-subtitle">@yield('page-subtitle', 'Espace professeur')</p>
            </div>

            <span class="sp-badge sp-badge-info">
                <i class="bi bi-person-badge"></i>
                Professeur
            </span>
        </div>

        <div class="sp-page">
            @yield('professeur-content')
        </div>
    </main>
</div>
@endsection