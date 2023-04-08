

<div class="col">
    <header class="d-flex justify-content-center py-3">
      <ul class="nav nav-pills">
        <li class="nav-item"><a href="login" class="nav-link {{ (request()->is('login')) ? 'active' : '' }}" aria-current="page">войти</a></li>
        <li class="nav-item"><a href="register" class="nav-link {{ (request()->is('register*')) ? 'active' : '' }}">регистрация</a></li>
      </ul>
    </header>
</div>
