<?php


namespace georgePompidou;

//mappe le s namespaces avec les fichiers
spl_autoload_register(static function (string $fqcn) {
    $path = str_replace('\\', '/', $fqcn) . '.php';
    require_once($path);
});

echo 'koukou';

$grande = new diametre(30, 'grande');
$extra = new diametre(40, 'extra');
$jumbo = new diametre(50, 'jumbo');

$deuxAchete = new variable(3, 0);


$royale = new pizza('la royale', false, true);
$royale->addTarification(new tarification(12, $grande));
$royale->addTarification(new tarification(16, $extra));
$royale->addTarification(new tarification(22, $jumbo));
$pizzas[] = new individuelle($extra, $royale);

$chef = new pizza('la chef', false, true);
$chef->addTarification(new tarification(13, $grande));
$chef->addTarification(new tarification(18, $extra));
$chef->addTarification(new tarification(24, $jumbo));
$pizzas[] = new individuelle($grande, $chef);

$saumona = new pizza('la saumona', false);
$saumona->addTarification(new tarification(9, $grande));
$saumona->addTarification(new tarification(16, $extra));
$saumona->addTarification(new tarification(22, $jumbo));
$pizzas[] = new individuelle($jumbo, $saumona);
$pizzas[] = new individuelle($extra, $saumona);

$cheeroke = new pizza('la cherokee', false);
$cheeroke->addTarification(new tarification(15, $grande));
$cheeroke->addTarification(new tarification(18, $extra));
$cheeroke->addTarification(new tarification(24, $jumbo));
$pizzas[] = new individuelle($grande, $cheeroke);

$devis = new devis($pizzas);
$devis;
