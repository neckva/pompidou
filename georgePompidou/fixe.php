<?php

namespace georgePompidou;

class fixe implements promo
{

    public function __construct(public int $nombrePizza, public int $gourmet = 0, public ?int $prix = null, public string $name, public ?diametre $diametre = null)
    {
    }

    public function getPrix(array $individuelles)
    {
    }

    public function checkValider(array $individuelles)
    {
        if (count($individuelles) == $this->nombrePizza) {
            $gourmet = 0;
            foreach ($individuelles as  $value) {
                if ($value->diametre->nom != $this->diametre->nom) {
                    return null;
                }
                if ($value->pizza->type == 'gourmet') {
                    $gourmet += $this->gourmet;
                }
            }
            return $this->prix + $gourmet;
        }
    }
}
