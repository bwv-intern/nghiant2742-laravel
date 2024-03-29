<nav class="d-flex justify-content-between p-2 px-4 navbarAdmin">
    <label class="projectName">Intern Training</label>

    <div>
        <label class="px-4">{{ session('user')->name }}</label>
        <a href="{{ route('logout') }}">Logout</a>
    </div>
</nav>