<div class="d-flex flex-column flex-shrink-0 p-3 text-light"
    style="height: 100vh; position: fixed; top: 0; left: 0; bottom: 0;">
    <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" href="/dashboard">
        <span class="fs-4">Rasaank Labz Balad</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a class="nav-link text-light" href="dashboard">
                <i class="fa-solid fa-chart-bar"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/unverified-words">
                <i class="fa-solid fa-file-circle-xmark"></i>
                Unverified Words
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="/verified-words">
                <i class="fa-solid fa-file-circle-check"></i>
                Verified Words
            </a>
        </li>
        @if (Auth::user() && Auth::user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link text-light" href="/users">
                    <i class="fa-solid fa-user"></i>
                    Users
                </a>
            </li>
        @endif
    </ul>

    <div class="mt-auto pt-3" style="position: absolute; bottom: 20px; width: 100%;">
        @auth
            <a class="nav-link text-light border-top pt-3" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>
            <form id="logout-form" style="display: none;" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        @endauth
    </div>
</div>
