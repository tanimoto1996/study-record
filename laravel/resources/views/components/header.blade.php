<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="height: 80px;">
  <div class="container" style="max-width: 100%;">
    <a class="navbar-brand" href="{{ route('top') }}">
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}様
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
            <!-- <button class="dropdown-item" type="button">
              ・・・
            </button> -->
            <div class="dropdown-divider"></div>
            <button form="logout-button" class="dropdown-item" type="submit">
              ログアウト
            </button>
          </div>
        </li>
        <form id="logout-button" method="POST" action="{{ route('logout') }}">
          @csrf
        </form>
        </a>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
