<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}" />
    <title>Vale Lar - Login</title>
  </head>
  <body>
    <div class="login">
      <div class="overlap-wrapper">
        <div class="overlap">
          <div class="rectangle"></div>
          <div class="text-wrapper">
             <a href="{{ route('register') }}" class="link-cadastro">Não tem conta?</a>
          </div>


          <img class="line" src="img/line-1.png" />
          <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
            @csrf <!-- CSRF Token for Laravel -->
            <div class="box"><div class="rectangle"></div></div>

            <!-- Botão de Entrar -->
            <div class="group">
              <div class="overlap-group">
                <button type="submit" class="div">Entrar</button>
              </div>
            </div>

            <!-- Texto de Abaixo -->
            <div class="overlap-group-wrapper">
              <div class="div-wrapper">
                <div class="text-wrapper-2">Vale Lar</div>
              </div>
            </div>

            <!-- Campo de E-mail -->
            <div class="form-group">
              <label for="email" class="text-wrapper-3">E-mail</label>
              <input type="email" id="email" name="email" class="rectangle-2" required />
            </div>

            <!-- Campo de Senha -->
            <div class="form-group">
              <label for="password" class="text-wrapper-4">Senha</label>
              <input type="password" id="password" name="password" class="rectangle-3" required />
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
