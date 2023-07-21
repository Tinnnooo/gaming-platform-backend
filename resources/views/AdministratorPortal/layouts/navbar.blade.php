    <nav class="navbar navbar-expand-lg fixed-top bg-dark" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="/">Administrator Portal</a>

            @if (auth('admin_users')->check())
                <button class="navbar-toggler" type="button" data-bs-toggle='collapse' data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon "></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a href="/dashboard"
                                class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">Admin Users</a></li>
                        <li class="nav-item"><a href="/manage-platform-users"
                                class="nav-link {{ request()->is('manage-platform-users*') ? 'active' : '' }}">Platform
                                Users</a></li>
                        <li class="nav-item"><a href="/manage-games"
                                class="nav-link {{ request()->is('manage-games*') ? 'active' : '' }}">Games</a></li>
                    </ul>
                    <div class="d-flex align-items-center gap-4">
                        <span class="text-white fw-medium fs-5">{{ auth('admin_users')->user()->username }}</span>
                        <form action="{{ route('admin.logout') }}" class="d-flex" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm ">Logout</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </nav>
