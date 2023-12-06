<?php

namespace georgePompidou;

spl_autoload_register(static function (string $fqcn) {
    $path = str_replace('\\', '/', $fqcn) . '.php';
    require_once($path);
});

echo 'fkoooooooooooooukou';

$data = file_get_contents('georgePompidou/menu.json');

$diam['petite'] = new diametre(30, 'petite');
$diam['grande'] = new diametre(40, 'grande');
$diam['extra'] =  new diametre(50, 'extra');

foreach (json_decode($data) as  $type => $types) {
    foreach ($types as  $pizza => $pizzas) {
        $pizzaClass = new pizza($pizza, $type);
        foreach ($pizzas as $taille => $prix) {
            $pizzaClass->addTarification(new tarification($prix, $diam[$taille]));
        }
        $carte[] = $pizzaClass;
    }
}


$deuxAchete = new variable(3, 0);

$commande[] = new individuelle($diam['petite'], $carte[25]);
$commande[] = new individuelle($diam['grande'], $carte[8]);
$commande[] = new individuelle($diam['extra'], $carte[16]);
$commande[] = new individuelle($diam['grande'], $carte[32]);
$commande[] = new individuelle($diam['grande'], $carte[40]);


$devis = new devis($commande);

$devis;
