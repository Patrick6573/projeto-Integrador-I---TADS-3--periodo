<!DOCTYPE html>
<html lang=""{{ str_replace('_', '-', app()->getLocale()) }}"">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Estilo básico para a sidebar */
    .sidebar {
      height: 100vh;
      background-color: #343a40;
      padding: 15px;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      transform: translateX(-250px);
      transition: transform 0.3s ease;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 10px 0;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #495057;
      border-radius: 5px;
    }

    /* Botão de fechar dentro da sidebar */
    .sidebar .close-btn {
      color: white;
      font-size: 20px;
      position: absolute;
      top: 10px;
      right: 15px;
      cursor: pointer;
    }

    /* Quando o menu estiver aberto */
    .sidebar.show {
      transform: translateX(0);
    }

    /* Ajustes no conteúdo principal para acomodar a sidebar */
    .main-content {
      margin-left: 250px;
      transition: margin-left 0.3s ease;
    }
    .content{
      padding-top: 60px;
    }
    

    /* Para telas menores */
    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
        transform: translateX(-200px);
      }
      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

<!-- Navbar Horizontal -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid ">
    <button class="btn btn-dark" type="button" id="sidebarToggle">
      ☰
    </button>
    <a class="navbar-brand" href="#">Logo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/dashboard">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="cadastroCasa">Anuncie seu Imovel</a>
        </li>
        @auth
          <li class="nav-item">
            <div class="hidden sm:flex sm:items-center sm:ms-6">
              <x-dropdown align="right" width="48">
                  <x-slot name="trigger">
                      <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                          <div>{{ Auth::user()->name }}</div>

                          <div class="ms-1">
                              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                              </svg>
                          </div>
                      </button>
                  </x-slot>

                  <x-slot name="content">
                      <x-dropdown-link :href="route('profile.edit')">
                          {{ __('Profile') }}
                      </x-dropdown-link>

                      <!-- Authentication -->
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf

                          <x-dropdown-link :href="route('logout')"
                                  onclick="event.preventDefault();
                                              this.closest('form').submit();">
                              {{ __('Log Out') }}
                          </x-dropdown-link>
                      </form>
                  </x-slot>
              </x-dropdown>
          </div>
        @endauth     
        @guest
          <li class="nav-item">
            <a href="/login" class="nav-link">Entrar</a>
          </li>
          <li class="nav-item">
            <a href="/register" class="nav-link">Cadastrar</a>
          </li>
        @endguest
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Sidebar Lateral -->
<div class="sidebar bg-dark" id="sidebar">
  <span class="close-btn" id="closeSidebar">&times;</span> <!-- Botão de fechar -->
  <a href="/dashboard">Logo</a>
  <a href="minhasCasas">Minhas Casas</a>
  <a href="minhasVisitas">Minhas Visitas</a>
</div>

  <div class="content">
    @yield('content')
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Controle da Sidebar
  document.getElementById("sidebarToggle").addEventListener("click", function() {
    var sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("show");
  });

  // Botão de fechar dentro da sidebar
  document.getElementById("closeSidebar").addEventListener("click", function() {
    var sidebar = document.getElementById("sidebar");
    sidebar.classList.remove("show");
  });
</script>

</body>
</html>
