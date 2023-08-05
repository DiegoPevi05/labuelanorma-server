<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh;">
    <a href={{route('home')}} class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <img src="https://labuelanorma.com/server/public/Logo.png" alt="" width="40" height="40" class="bi me-2">
      <span class="fs-4">Panel de Control</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href={{ route('home') }} class="nav-link text-white {{ request()->is('/') ? 'active' : '' }}" aria-current="page">
          Inicio
        </a>
      </li>

      @if (Auth::user() && Auth::user()->role !== 'MODERATOR')
      <li>
        <a href={{ route('users.index') }} class="nav-link text-white {{ request()->is('users*') ? 'active' : '' }}">
          Usuarios
        </a>
      </li>
      @endif
      <li>
        <a href={{ route('webcontents.index') }} class="nav-link text-white {{ request()->is('webcontents*') ? 'active' : '' }}">
          Contenido Web 
        </a>
      </li>

      <li>
        <a href={{ route('giveaways.index') }} class="nav-link text-white {{ request()->is('giveaways*') ? 'active' : '' }}">
          Sorteos 
        </a>
      </li>
      <li>
        <a href={{ route('giveawayparticipants.index') }} class="nav-link text-white {{ request()->is('giveawayparticipants*') ? 'active' : '' }}">
          Participantes de Sorteos 
        </a>
      </li>
      <li>
        <a href={{ route('partners.index') }} class="nav-link text-white {{ request()->is('partners*') ? 'active' : '' }}">
          Partners 
        </a>
      </li>
      <li>
        <a href={{ route('categories.index') }} class="nav-link text-white {{ request()->is('categories*') ? 'active' : '' }}">
          Categorias Productos
        </a>
      </li>
      <li>
        <a href={{ route('products.index') }} class="nav-link text-white {{ request()->is('products*') && !request()->is('productsizes*') ? 'active' : '' }}">
          Productos
        </a>
      </li>
      <li>
        <a href={{ route('productsizes.index') }} class="nav-link text-white {{ request()->is('productsizes*') ? 'active' : '' }}">
          Tallas Productos
        </a>
      </li>
      <li>
        <a href={{ route('discountcodes.index') }} class="nav-link text-white {{ request()->is('discountcodes*') ? 'active' : '' }}">
          Codigos de Descuento
        </a>
      </li>

      <li>
        <a href={{ route('subscribers.index') }} class="nav-link text-white {{ request()->is('subscribers*') ? 'active' : '' }}">
          Subscriptores 
        </a>
      </li>
      <li>
        <a href={{ route('orders.index') }} class="nav-link text-white {{ request()->is('orders*') ? 'active' : '' }}">
           Ordenes
        </a>
      </li>

    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://labuelanorma.com/server/public/Logo.png" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong>{{ Auth::user()->name }}</strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1" style="">
        <li>
          <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
            Salir</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
        </li>
      </ul>
    </div>
  </div>
