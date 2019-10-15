<div class="logo-container">
    <img class="nav-logo" src="{{ asset('img/logo.svg')}}">
</div>
<ul class="icon_nav">
    <li>
        <a href="{{route('client.dashboard')}}">
            <i class="fal fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{route('client.project.list')}}">
            <i class="fal fa-folder-open"></i>
            <span>Projects</span>
        </a>
    </li>
</ul>
