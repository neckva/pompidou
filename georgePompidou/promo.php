<?php

namespace georgePompidou;

interface promo
{
    function __construct(int $nombrePizza, int $gourmet = 0, int $prix = null, string $name, ?diametre $diametre = null);
    function checkValider(array $individuelles);
}
