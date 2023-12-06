<?php

namespace georgePompidou;

class variable implements promo
{

    public function __construct(int $nombrePizza, int $gourmet = 0, ?int $prix = null, ?diametre $diametre = null)
    {
    }

    public function checkValider(array $individuelles)
    {
        uasort($individuelles, function ($premier, $second) {
            if ($premier->prix == $second->prix) {
                return 0;
            }
            return ($premier->prix > $second->prix);
        });

        array_shift($individuelles);
        return array_sum(array_column($individuelles, 'prix'));
    }
}
