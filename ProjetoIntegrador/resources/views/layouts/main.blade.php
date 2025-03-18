<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Sidebar azul */
    @import url('https://fonts.googleapis.com/css2?family=Aclonica&display=swap');

    .sidebar {
      height: 100vh;
      background-color: #2f80cd !important; /* Força a cor azul */
      padding: 15px;
      position: fixed;
      top: 23px;
      left: 0;
      width: 250px;
      transform: translateX(-250px);
      transition: transform 0.3s ease;
    }

    .sidebar a {
      color: white;
      display: block;
      padding: 10px 10px;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
    }

    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.2); /* Efeito suave no hover */
      border-radius: 5px;
    }

    /* Botão de fechar */
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

    /* Ajustes no conteúdo principal */
    .content {
      padding-top: 60px;
    }

    /* Navbar superior azul */
    .navbar {
      background-color: #2f80cd !important; /* Cor azul na barra superior */
    }

    .navbar .navbar-brand,
    .navbar .nav-link {
      color: white; /* Cor branca para o texto */
    }

    .navbar .navbar-brand:hover,
    .navbar .nav-link:hover {
      color: #f0f0f0; /* Cor mais clara no hover */
    }

    /* Para telas menores */
    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
        transform: translateX(-200px);
      }
    }

    /* Alterar cor do ícone de menu e o fundo */
    #sidebarToggle {
      color: white; /* Cor do ícone (branco) */
      font-size: 30px; /* Tamanho do ícone */
      background-color: #2f80cd; /* Cor de fundo azul */
      border: none; /* Remover borda */
      padding: 10px; /* Adicionar um pouco de padding para o botão */
      border-radius: 5px; /* Deixar os cantos arredondados */
    }

    #sidebarToggle:hover {
      background-color: #1d6fa5; /* Azul mais escuro ao passar o mouse */
      color: white; /* Cor do ícone mantém branco */
    }
    .aclonica{
    position: absolute;
    width: 147px;
    top: 0;
    left: 0;
    transform: rotate(0.17deg);
    font-family: "Aclonica", Helvetica;
    font-weight: 400;
    color: #ffffff;
    font-size: 48px;
    letter-spacing: 0;
    line-height: normal;
    }
  </style>
</head>
<body>

<!-- Navbar Horizontal -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container-fluid">
    <button class="btn" type="button" id="sidebarToggle">
      ☰
    </button>
    <a class="navbar-brand" class="aclonica" href="/">Vale Lar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="/dashboard">Página Principal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="cadastroCasa">Anuncie seu Imóvel</a>
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
<div class="sidebar" id="sidebar">
  <span class="close-btn" id="closeSidebar">&times;</span> <!-- Botão de fechar -->
  <a href="/dashboard">Vale Lar</a>
  <a href="minhasCasas">Minhas Casas</a>
  <a href="{{ route('minhas.visitas') }}">Minhas Visitas</a>
  <a href="/chats">Conversas</a>
</div>

<!-- Conteúdo Principal -->
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
