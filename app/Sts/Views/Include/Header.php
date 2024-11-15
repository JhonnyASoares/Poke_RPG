<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Aceitar caracteres especiais -->
    <meta charset="UTF-8">
    <title>Pokemon RPG</title>
    <!-- identificar o tamanho da tela do dispositivo do usuario -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/app/Sts/Assets/Images/master-ball.ico">
    <link rel="stylesheet" type="text/css" href="<?= URLCSS; ?>main.css">
    <?php
    // Se existir $_GET['url'] ele pega o dado da url até a "/" e adiciona o css com daquela pagina
    if (!empty($_GET['url'])) {
        $var = strtolower($_GET['url']);
        $position = strpos($var, '/'); // Encontra a posição da "/"
        if ($position !== false) {
            $var = substr($var, 0, $position); // Pegar tudo até a "/"
        }
        if ($var != 'login') {
            echo '<link rel="stylesheet" type="text/css" href="' . URLCSS . 'nav.css">';
        }
        // Se o arquivo.css existir coloca o link dele
        if (file_exists("app/Sts/Assets/Css/$var.css")) {
            echo '<link rel="stylesheet" type="text/css" href="' . URLCSS . $var . '.css">';
        }
    } else {
        echo '<link rel="stylesheet" type="text/css" href="' . URLCSS . 'nav.css">
    <link rel="stylesheet" type="text/css" href="' . URLCSS . 'home.css">';
    }
    ?>
</head>

<body>