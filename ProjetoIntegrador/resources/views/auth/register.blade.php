<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <title>Vale Lar - Criar Conta</title>
</head>

<body>
    <div class="criar-conta">
        <div class="div">
            <div class="overlap">
                <div class="rectangle"></div>
                <div class="rectangle-3"></div>

                <div class="text-wrapper-3">Seja bem-vindo!</div>
                <p class="crie-ou-acesse-sua">Crie ou acesse sua<br />conta agora mesmo</p>

                <div class="textos-e-destaques">
                    <div class="vale-lar">Vale <br />&nbsp;&nbsp; Lar</div>
                </div>

                <!-- Formulário de Cadastro -->
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="register">
                        <!-- Botão Entrar -->
                        <div class="overlap-group">
                            <a href="{{ route('login') }}" class="text-wrapper-4">
                                <div class="rectangle-4"></div>
                                Entrar
                            </a>
                        </div>
                        <!-- Campos de Entrada -->
                        <div class="overlap-2">
                            <label class="text-wrapper-5" for="nome-completo">Nome Completo*</label><br>
                            <input type="text" id="name" name="name" class="rectangle-5" required />
                        </div>

                        <div class="overlap-3">
                            <label class="text-wrapper-5" for="telefone1">Telefone 1*</label>
                            <input type="tel" id="user_phone1" name="user_phone1" class="rectangle-6" required />
                        </div>

                        <div class="overlap-4">
                            <label class="telefone" for="telefone2">Telefone 2 (Opcional)</label>
                            <input type="tel" id="user_phone2" name="user_phone2" class="rectangle-7" />
                        </div>

                        <div class="overlap-group-2">
                            <label class="text-wrapper-5" for="email">E-mail*</label>
                            <input type="email" id="email" name="email" class="rectangle-6" required />
                        </div>

                        <!-- Senha -->
                        <div class="overlap-group-3">
                            <label class="text-wrapper" for="senha">Senha*</label>
                            <input type="password" id="password" name="password" class="rectangle-1" required />
                        </div>
                        <div class="overlap-group-4">
                            <label class="text-wrapper-2" for="confirmar-senha">Confirme sua senha*</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="rectangle-2" required />
                        </div>

                        <!-- Foto de Perfil -->
                        <div>
                            <label class="text-wrapper-10" for="foto-perfil">Foto de Perfil:</label>
                            <input type="file" id="user_photo" name="user_photo" accept="image/*" class="rectangle-8" />
                        </div>

                        <!-- Botão de Cadastro -->
                        <div class="frame">
                            <button type="submit" class="text-wrapper-6">Cadastrar</button>
                        </div>
                    </div>
                </form>

            </div>

            <div class="text-wrapper-7">Crie sua conta</div>
            <img class="line" src="img/line-10.svg" />
        </div>
    </div>
</body>

</html>
