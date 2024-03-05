<?php

namespace App\Enums;

class Category
{

    public static function get()
    {

        // product models
        return [
            'chant' => [
                'Simple ep' => 'Simple ep',
                'Double ep' => 'Double ep',
            ],

            'charniére' => [
                'Plat Simple' => 'Plat Simple',
                'Plat a Pompe' => 'Plat a Pompe',
                'Semi coudé simple ' => 'Semi coudé simple ',
                'Semi coudé a Pompe' => 'Semi coudé a Pompe',
                'Coudé simple' => 'Coudé simple',
                'Coudé a Pompe' => 'Coudé a Pompe',
            ]

        ];
    }



    public static function getc()
    {

        // product models
        return [
            1 => 'chant',
            2 => 'charniére',
            3 => 'pied',
            4 => 'poignée',
            5 => 'mecanisme',
            6 => 'vis',
            7 => 'kitkat',
            8 => 'separateur',
            9 => 'tiroir',
            10 => 'baguette',
            11 => 'passe cable',
            12 => 'surrure',
            13 => 'cheville',
            14 => 'ammortisseur',
            15 => 'equerre',
            16 => 'gravure',
            17 => 'sabot',
            18 => 'colle',
            19 => 'glissiére',
            20 => 'button'
        ];
    }
}
