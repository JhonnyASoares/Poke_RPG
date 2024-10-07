<?php
if (!defined('P0K3M4RP5G')) {
    header("Location: /");
    die("Erro: Pagina nao encontrada!");
}
// Redirecionor para home caso o usuário esteja logado
if (isset($_SESSION['user_id'])) {
    header("Location: /home");
}

// Extraindo os dados do para facilitar atribuilos ao formulario
if (isset($this->data['form'])) {
    $valueForm = $this->data['form'];
    extract($valueForm);
}

?>



<nav>
    <div class="logo">
        <a href="/"><img src="/app/Sts/Assets/Images/PokeRPG.png" alt="Logo">
        </a>
    </div>

</nav>

<section class="container">
    <div class="main">
        <h2>Login</h2>
        <?php
        if (isset($_SESSION['msg'])) {
            echo "<span class='msg'>{$_SESSION['msg']}</span>";
            unset($_SESSION['msg']);
        }
        ?>

        <form action="" method="POST">
            <div class="form-imgs">
                <img class="pikachu pkm" src="/app/Sts/Assets/Images/Gifs/pikachu.gif">
                <img class="red master" src="/app/Sts/Assets/Images/Gifs/red.gif">
            </div>
            <div class="inputs">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= isset($email) ? $email : '' ?>">
                </div>
                <div>
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" value="<?= isset($password) ? $password : '' ?>">
                </div>
            </div>
            <button value="login" name="submit">Enviar</button>
        </form>
        <span class="click-here">Não tem uma conta? <a href="/register">Clique aqui.</a></span>
    </div>

</section>