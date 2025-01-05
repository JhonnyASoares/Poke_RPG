<h1 class="title"><?= $this->data['name'] ?></h1>
<section>
    <div class="image-types">
        <div class="image">
            <img src="<?= $this->data['images']['front_default'] ?>" id="pkm_img">
            <button onclick="shinyChange()" value="<?= $this->data['images']['front_shiny'] ?>" id="swap_image">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="50" height="50" fill="currentColor">
                    <polygon points="50,0 60,40 100,50 60,60 50,100 40,60 0,50 40,40" />
                </svg>
            </button>
        </div>
        <div class="types">
            <?php foreach ($this->data["types"] as $type) { ?>
                <a href="/search?filter=<?= $type["name"] ?>" style="background-color:#<?= $type["color"] ?>BF"><?= $type["name"] ?></a>
            <?php } ?>
        </div>
        <div class="evolutions">
            <?php if (!empty($this->data['evolution_chain'])) {
                foreach ($this->data['evolution_chain'] as $evolution) {  ?>
                    <div class="evolution">
                        <i class="fa-solid fa-arrow-right"></i>
                        <div class="evolution-img">
                            <a href="/pokemon?name=<?= $evolution['name'] ?>">
                                <img src="<?= $evolution['front_default'] ?>">
                            </a>
                        </div>

                        <?php if (!empty($evolution['evolves_to'])) { ?>
                            <div class="evolution">
                                <i class="fa-solid fa-arrow-right"></i>
                                <div>
                                    <?php foreach ($evolution['evolves_to'] as $evolves_to) { ?>
                                        <div class="evolution-img">
                                            <a href="/pokemon?name=<?= $evolves_to['name'] ?>">
                                                <img src="<?= $evolves_to['front_default'] ?>">
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
    <div class="pkm-data">

    </div>
    <div class="stats">
        <h3>Stats</h3>
        <div class="stat">
            <div class="stat-name">
                <h4>HP:</h4>
                <span class="stat-value"><?= $this->data['hp'] ?></span>
            </div>
            <div class="progress-bar"></div>
        </div>
        <div class="stat">
            <div class="stat-name">
                <h4>Attack:</h4>
                <span class="stat-value"><?= $this->data['attack'] ?></span>
            </div>
            <div class="progress-bar"></div>
        </div>
        <div class="stat">
            <div class="stat-name">
                <h4>Defense:</h4>
                <span class="stat-value"><?= $this->data['defense'] ?></span>
            </div>
            <div class="progress-bar"></div>
        </div>
        <div class="stat">
            <div class="stat-name">
                <h4>Sp. attack:</h4>
                <span class="stat-value"><?= $this->data['special_attack'] ?></span>
            </div>
            <div class="progress-bar"></div>
        </div>
        <div class="stat">
            <div class="stat-name">
                <h4>Sp. defense:</h4>
                <span class="stat-value"><?= $this->data['special_defense'] ?></span>
            </div>
            <div class="progress-bar"></div>
        </div>
        <div class="stat">
            <div class="stat-name">
                <h4>Speed:</h4>
                <span class="stat-value"><?= $this->data['speed'] ?></span>
            </div>
            <div class="progress-bar"></div>
        </div>
    </div>
</section>
<article>
    <div class="moves">
        <div class="grid-header">
            <h4>Name</h4>
            <h4>Type</h4>
            <h4>Damage class</h4>
            <h4>Accuracy</h4>
            <h4>Power</h4>
            <h4>PP</h4>
            <h4>Effect</h4>
        </div>
        <?php foreach ($this->data['moves'] as $move) { ?>
            <div class="move">
                <span><?= str_replace('-', ' ', $move['name']) ?></span>
                <a href="/search?type=<?= $move['type'] ?>" style="background-color: #<?= $move['type_color'] ?>BF;"><?= $move['type'] ?></a>
                <span><?= $move['damage_class'] ?></span>
                <span><?= $move['accuracy'] ?? '-' ?></span>
                <span><?= $move['power'] ?? '-' ?></span>
                <span><?= $move['pp'] ?></span>
                <span><?= $move['effect'] ?? '-' ?></span>
            </div>
        <?php } ?>
    </div>
</article>
<script src="/app/Sts/Assets/Js/pokemon.js"></script>
<?php
/*
print_r('<pre>');
print_r($this->evChain);
print_r($this->data);
print_r('</pre>');*/
