<?php

namespace georgePompidou;



class devis
{
    public array $associations;
    public array $individuelles;
    public int $prix;

    function __construct(array $indivuelles)
    {
        /*trie des pizzas du plus au moins cher*/
        uasort($indivuelles, function ($premier, $second) {
            if ($premier->prix == $second->prix) {
                if ($premier->pizza->gourmet == $second->pizza->gourmet) {
                    return 0;
                }
                if ($premier->pizza->gourmet) {
                    return -1;
                }
                return 1;
            }
            return ($premier->prix > $second->prix) ? -1 : 1;
        });

        //offre sur 2 pizzas achetée une offerte
        $deuxAchete = new variable(3, 0);
        $association = new association($deuxAchete);
        $restantes = [];
        foreach ($indivuelles as $value) {
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
        $this->prix = $this->associations ? array_sum(array_column($this->associations, 'prix')) : 0;
        $this->prix += $this->individuelles ? array_sum(array_column($this->individuelles, 'prix')) : 0;
    }

    private function promoUnique(individuelle $individuelle)
    {
        if ($individuelle->pizza->classique) {
            if ($individuelle->diametre->nom == 'grande') {
                $association = new association(new fixe(1, 0, 10, new diametre(30, 'grande')));
                $association->setIndividuelles([$individuelle]);
                $this->associations[] = $association;
                return;
            }
            if ($individuelle->diametre->nom == 'petite') {
                $association = new association(new fixe(1, 0, 6, new diametre(20, 'petite')));
                $association->setIndividuelles([$individuelle]);
                $this->associations[] = $association;
                return;
            }
        }
        $this->individuelles[] = $individuelle;
    }

    function promoDouble(array $restantes)
    {
        $premier = $restantes[0];
        $second = $restantes[1];

        //si on peut beneficier de l'offre extra
        $promo = new fixe(2, 3, 30, new diametre(40, 'extra'));
        if ($promo->checkValider($restantes)) {
            $association = new association($promo);
            $association->setIndividuelles($restantes);
            $this->associations[] = $association;
            return;
        }

        //si on peut bénéficier de l'offre grande, sans prendre en compte les classique
        if ($premier->diametre->nom == 'grande' && $second->diametre->nom == 'grande') {
            if (!$premier->pizza->classique and !$second->pizza->classique) {
                $association = new association(new fixe(2, 2, 24, new diametre(30, 'grande')));
                $association->setIndividuelles($restantes);
                $this->associations[] = $association;
                return;
            }
        }
        $this->promoUnique($premier);
        $this->promoUnique($second);
    }
}
