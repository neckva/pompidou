<?php

namespace georgePompidou;

session_start();

//demarre Twig
require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
    'debug' => true,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

spl_autoload_register(static function (string $fqcn) {
    $path = str_replace('\\', '/', $fqcn) . '.php';
    require_once($path);
});

//model-controllers: transforme les pizzas en json



$data = file_get_contents('georgePompidou/menu.json');

$diam['petite'] = new diametre(30, 'petite');
$diam['grande'] = new diametre(40, 'grande');
$diam['extra'] =  new diametre(50, 'extra');

$i = 1;
foreach (json_decode($data) as  $type => $types) {

    foreach ($types as  $pizza => $pizzas) {
        $pizzaClass = new pizza($pizza, $type, $i);
        foreach ($pizzas as $taille => $prix) {
            $pizzaClass->addTarification(new tarification($prix, $diam[$taille]));
        }
        $carte[$i] = $pizzaClass;
        $i++;
    }
}


if ($numPizza = $_POST['ajouter'] ?? false) {
    $liste[] = new individuelle($diam['grande'], $carte[$numPizza]);
    if ($_SESSION['commande'] ?? false) {

        $liste = array_merge($liste, unserialize($_SESSION['commande']));
    }

    $devis = new devis($liste);

    $_SESSION['commande'] = serialize($liste);
    $_SESSION['devis'] = serialize($devis);
}

if ($numPizza = $_POST['retirer'] ?? false and $_SESSION['commande']) {
    $needle = new individuelle($diam['grande'], $carte[$numPizza]);
    $liste = unserialize($_SESSION['commande']);


    foreach ($liste as $key => $value) {
        if ($needle->pizza->clef == $value->pizza->clef) {
            unset($liste[$key]);
            $devis = new devis($liste);

            $_SESSION['commande'] = serialize($liste);
            $_SESSION['devis'] = serialize($devis);
            break;
        }
    }
}

if ($commande = $_POST['commande'] ?? false) {
    session_unset();
}

if ($devis = $devis ?? isset($_SESSION['devis']) ? unserialize($_SESSION['devis']) : null) {
    $ticket = $twig->render('devis.twig', ['devis' => $devis]);
}

$menu = $twig->render('menu.twig', ['menu' => $carte, 'ticket' => $devis ? array_count_values(array_column($devis->getPizzas(), 'clef')) : null]);


include_once 'templates/layout.php';
