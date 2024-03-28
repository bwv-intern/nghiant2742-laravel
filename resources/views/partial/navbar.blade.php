<nav class="d-flex justify-content-between p-2 px-4 navbarAdmin">
    <h5>Intern Training</h5>

    <div>
        <span class="px-4">{{ session('user')->name }}</span>
        <a href="{{ route('logout') }}">Logout</a>
    </div>
</nav>