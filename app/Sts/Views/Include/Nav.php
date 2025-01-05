<nav>
    <div class="nav-up">
        <div class="logo">
            <a href="/">
                <img src="/app/Sts/Assets/Images/PokeRPG.png" alt="logo">
            </a>
        </div>
        <div class="search-bar">
            <input placeholder="Search" name="search" id="search" onkeyup="search(this)">
            <div id="search_results"></div>
        </div>

        <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="nav-user nav-user-logado">
                <div class="nav-user-info">
                    <div class="nav-user-img">
                        <img src="/app/Sts/Assets/Images/PkmRPG.png">
                    </div>
                    <span>USUÁRIO</span>
                </div>
                <i class="fa-solid fa-caret-up"></i>
                <div class="nav-user-menu">
                    <a href="/profile">Perfil</a>
                    <a href="/ficha">Ficha</a>
                    <a href="/logout">Sair</a>
                </div>
            </div>
        <?php } else { ?>
            <div class=" nav-user">
                <a href="/login">Login</a>
                <a href="/login">Register</a>
                <a href="/logout">Logout</a>
            </div>
        <?php } ?>

    </div>
    <div class="nav-down">
        <ul>
            <li><a href="/pokemons">Pokemons</a></li>
            <li><a href="/itens">Itens</a></li>
            <li><a href="/moves">Moves</a></li>
            <li class="dropdown">
                <a>Pokedexes</a>
                <div class="dropdown-content">
                    <?php
                    require_once 'app/Sts/Controllers/Nav.php';
                    $pokedexes = (new \Sts\Controllers\Nav())->pokedexes()[0];
                    foreach ($pokedexes as $pokedex) {
                        echo "<a href='/pokedex?pdx=" . $pokedex['id'] . "'>" . $pokedex['name'] . "</a>";
                    }
                    ?>
                </div>
            </li>
            <li><a href="/jobs">Profissões</a></li>
        </ul>
    </div>
</nav>
<script src="app/Sts/Assets/Js/nav.js"></script>