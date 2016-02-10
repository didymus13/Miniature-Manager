<h1>{{ $user->name }}</h1>

<ul>
    <li>Email: {{ $user->email }}</li>
    <li><img src="{{ $user->photo }}" alt="{{ $user->name }}"></li>
</ul>

<form method="POST" action="{{ route('logout') }}" >
    {{ csrf_field() }}
    <button>Logout</button>
</form>