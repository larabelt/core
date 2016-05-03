<ul class="nav navbar-nav navbar-right">
    @if(!Auth::user())
        <li><a href="/login">Login</a></li>
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="/admin">Admin</a></li>
                <li><a href="/admin-user">My Account</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </li>
    @endif
</ul>