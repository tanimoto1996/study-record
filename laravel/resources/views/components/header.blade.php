<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ asset('assets/image/header-logo.png') }}" style="width: 160px;">
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        @guest
        {{-- 非ログイン --}}
        <li class="nav-item">
          <a class="btn btn-secondary ml-3" href="{{ route('register') }}" role="button">会員登録</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-info ml-2" href="{{ route('login') }}" role="button">ログイン</a>
        </li>
        @else
        {{-- ログイン済み --}}
        <li class="nav-item dropdown ml-2">
          {{-- ログイン情報 --}}
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

            <form id="logout-button" method="POST" action="{{ route('logout') }}">
              @csrf
              <button form="logout-button" type="submit">ログアウト</button>
            </form>
          </a>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
