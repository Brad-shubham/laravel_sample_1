<!-- Sidebar -->
<div class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center tb-logo" href="{{route('dashboard')}}">
        <div class="sidebar-brand-text"><img src="{{ asset('images/login.png') }}"></div>
        <div class="sidebar-brand-text d-block d-lg-none sm-logo"><img src="{{ asset('images/sm-logo.png') }}"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <ul class="list-unstyled my-3">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{Route::is('dashboard') ? 'active' :''}}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fa fa-th-large" aria-hidden="true"></i>
                <span>Dashboard</span></a>
        </li>

        <li class="nav-item {{Route::is(['courses.index','courses.create','courses.edit']) ? 'active' :''}}">
            <a class="nav-link" href="{{route('courses.index')}}">
                <i class="fas fa-book-medical"></i>
                <span>Courses</span></a>
        </li>

        <li class="nav-item {{Route::is(['books.index', 'books.create', 'books.edit'])? 'active':''}}">
            <a class="nav-link" href="{{route('books.index')}}">
                <i class="fas fa-book"></i>
                <span>Books</span></a>
        </li>

        <li class="nav-item {{Route::is(['lessons.index', 'lessons.create', 'lessons.edit'])? 'active':''}}">
            <a class="nav-link" href="{{route('lessons.index')}}">
                <i class="fas fa-book-open"></i>
                <span>Lessons</span></a>
        </li>

        <li class="nav-item {{Route::is('students.*') ? 'active' :''}}">
            <a class="nav-link" href="{{ route('students.index') }}">
                <i class="fas fa-book-reader"></i>
                <span>Students</span></a>
        </li>

        <li class="nav-item {{Route::is('tests.*') ? 'active' :''}}">
            <a class="nav-link" href="{{ route('tests.index') }}">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Tests</span></a>
        </li>

        <!-- Nav Item - Test Results -->
        <li class="nav-item {{Route::is('test-answers.*') ? 'active' :''}}">
            <a class="nav-link" href="{{ route('test-answers.index') }}">
                <i class="fas fa-clipboard-check"></i>
                <span>Test Results</span></a>
        </li>
        <!-- Nav Item - Users -->
        <li class="nav-item {{Route::is('users.*') ? 'active' :''}}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-user-friends"></i>
                <span>Users</span></a>
        </li>
        <!-- Nav Item - Users -->
        <li class="nav-item {{Route::is('gift.*') ? 'active' :''}}">
            <a class="nav-link" href="{{ route('gift.reminder') }}">
                <i class="fas fa-gift"></i>
                <span>Gift Reminder</span></a>
        </li>
        <!-- Nav Item - Users -->
        <li class="nav-item {{Route::is('offline.*') ? 'active' :''}}">
            <a class="nav-link" href="{{ route('offline.test.entry') }}">
                <i class="fas fa-notes-medical"></i>
                <span>Offline Test Entry</span></a>
        </li>
    </ul>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</div>
<!-- End of Sidebar -->
