<h1 class="title"><?= $this->data['pokedex_name'] ?></h1>
<section class="pkm-container">
    <?php foreach ($this->data['pokemons'] as $pokemon) { ?>
        <a href="/pokemon?name=<?= $pokemon["name"] ?>">
            <div class="card">
                <h2>N°: <?= $pokemon["entry_number"] ?> </h2>
                <img src="<?= $pokemon["front_default"] ?>" width="200" height="200" alt="pokemons image">
                <h3><?= $pokemon["name"] ?> </h3>
                <div class="types">
                    <?php foreach ($pokemon["types"] as $type) { ?>
                        <span href="/search?type=<?= $type["name"] ?>" style="background-color:#<?= $type["color"] ?>BF"><?= $type["name"] ?></span>
                    <?php }; ?>
                </div>
            </div>
        </a>
    <?php }; ?>

    <div class="pages-selector">
        <ul>
            <?php $_GET['pg'] = $_GET['pg'] ?? 1; ?>
            <?= $_GET['pg'] > 1 ? '<li><a href="/pokedex?pdx=' . $_GET['pdx'] . '&pg=1"><i class="fa-solid fa-angles-left"></i></a> </li>' : ''; ?>
            <?= $_GET['pg'] > 2 ? '<li><a href="/pokedex?pdx=' . $_GET['pdx'] . '&pg=' . $_GET['pg'] - 1 . '"><i class="fa-solid fa-angle-left"></i></a></li>' : ''; ?>
            <li><span class=" pg-active"><?= $_GET['pg'] ?? 1; ?></span></li>
            <?= $_GET['pg'] < $this->data['pgs'] ? '<li><a href="/pokedex?pdx=' . $_GET['pdx'] . '&pg=' . $_GET['pg'] + 1 . '"><i class="fa-solid fa-angle-right"></i></a></li>' : ''; ?>
            <?= $_GET['pg'] < $this->data['pgs'] - 1 ? '<li><a href="/pokedex?pdx=' . $_GET['pdx'] . '&pg=' . $this->data['pgs'] . '"><i class="fa-solid fa-angles-right"></i></a></li>' : ''; ?>
        </ul>
    </div>
</section>