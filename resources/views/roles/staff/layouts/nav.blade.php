<div class="logo-container">
    <img class="nav-logo" src="{{ asset('img/logo.svg')}}">
</div>
<ul class="icon_nav">
    <li>
        <a href="{{route('staff.dashboard')}}">
            <i class="fal fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="has-children">
        <span class="icon-container">
            <i class="fal fa-folder-open"></i>
            <span>Projects</span>
        </span>
        <ul>
            <li>
                <a href="{{route('staff.project.list')}}">All Projects</a>
            </li>
            <li>
                <a href="{{route('staff.project.add')}}">Add</a>
            </li>
        </ul>
    </li>
    <li class="has-children">
        <span class="icon-container">
            <i class="fal fa-user-friends"></i>
            <span>Clients</span>
        </span>
        <ul>
            <li>
                <a href="{{route('staff.client.list')}}">All Clients</a>
            </li>
            <li>
                <a href="{{route('staff.client.add')}}">Add</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{route('staff.event.list')}}">
            <i class="fal fa-calendar-alt"></i>
            <span>Events</span>
        </a>
    </li>
    <li class="has-children">
        <span class="icon-container">
            <i class="fal fa-user-cog"></i>
            <span>Users</span>
        </span>
        <ul>
            <li>
                <a href="{{route('staff.user.list')}}">All Users</a>
            </li>
            <li>
                <a href="{{route('staff.user.add')}}">Add</a>
            </li>
        </ul>
    </li>
</ul>
