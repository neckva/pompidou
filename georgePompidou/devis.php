<?php

namespace georgePompidou;

class devis
{
    public ?array $associations = null;
    public ?array $individuelles = null;
    public int $prix;

    function __construct(array $individuelles)
    {
        /*trie des pizzas du plus au moins cher*/
        uasort($individuelles, function ($premier, $second) {
            if ($premier->prix == $second->prix) {
                if ($premier->pizza->type == $second->pizza->type) {
                    return 0;
                }
                if ($premier->pizza->type == 'gourmet') {
                    return -1;
                }
                return 1;
            }
            return ($premier->prix > $second->prix) ? -1 : 1;
        });

        //offre sur 2 pizzas achetée une offerte
        $deuxAchete = new variable(3, 0, null, 'Jamais 203');
        $association = new association($deuxAchete);
        $restantes = [];
        foreach ($individuelles as $value) {

            $restantes[] = $value;
            if (count($restantes) == 3) {
                $association->setIndividuelles($restantes);
                $this->associations[] = $association;
                $association = new association($deuxAchete);
                $restantes = [];
            }
        }

        //meileur offre sur les pizzas restantes (les moins cheres)
        if (count($restantes) == 1) {
            $this->promoUnique(current($restantes));
        }

        if (count($restantes) == 2) {
            $this->promoDouble($restantes);
        }

        //total avec les offres et sans offres
        $this->prix = isset($this->associations) ? array_sum(array_column($this->associations, 'prix')) : 0;
        $this->prix += isset($this->individuelles) ? array_sum(array_column($this->individuelles, 'prix')) : 0;
    }

    private function promoUnique(individuelle $individuelle)
    {
        if ($individuelle->pizza->type = "classique") {
            if ($individuelle->diametre->nom == 'grande') {
                $association = new association(new fixe(1, 0, 10, 'La grande à 10 balles.', new diametre(30, 'grande')));
                $association->setIndividuelles([$individuelle]);
                $this->associations[] = $association;
                return;
            }
            if ($individuelle->pizza->type = "petite") {
                $association = new association(new fixe(1, 0, 6, 'La petite à 6 balles.', new diametre(20, 'petite')));
                $association->setIndividuelles([$individuelle]);
                $this->associations[] = $association;
                return;
            }
        }
        $this->individuelles[] = $individuelle;
    }

    private function promoDouble(array $restantes)
    {
        $premier = $restantes[0];
        $second = $restantes[1];

        //si on peut beneficier de l'offre extra
        $promo = new fixe(2, 3, 30, 'Les 2 extras à 30 balles.', new diametre(40, 'extra'));
        if ($promo->checkValider($restantes)) {
            $association = new association($promo);
            $association->setIndividuelles($restantes);
            $this->associations[] = $association;
            return;
        }

        //si on peut bénéficier de l'offre grande, sans prendre en compte les classique
        if ($premier->diametre->nom == 'grande' && $second->diametre->nom == 'grande') {
            if (!$premier->pizza->type == 'classique' and !$second->pizza->type = 'classique') {
                $association = new association(new fixe(2, 2, 24, 'Les 2 grandes à 24 balles.', new diametre(30, 'grande')));
                $association->setIndividuelles($restantes);
                $this->associations[] = $association;
                return;
            }
        }
        $this->promoUnique($premier);
        $this->promoUnique($second);
    }

    public function getPizzas(): array
    {
        $retour = [];

        if ($this->associations) {
            array_map(function ($association) use (&$retour) {

                foreach ($association->individuelles as  $individuelle) {

                    $retour[] = $individuelle->pizza;
                }
            }, $this->associations);
        }


        if ($this->individuelles) {
            $retour = $retour + array_map(function ($individuelle) {

                return $individuelle->pizza;
            }, $this->individuelles);
        }
        return $retour;
    }

    public function countPizzas(): int
    {
        return count($this->getPizzas());
    }
}
