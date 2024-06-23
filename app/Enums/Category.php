<?php

namespace App\Enums;

class Category
{

    public static function get()
    {

        // product models
        return [
            'Chant' => [
                'Simple ep' => 'Simple ep',
                'Double ep' => 'Double ep',
            ],

            'Charniére' => [
                'Plat Simple' => 'Plat Simple',
                'Plat a Pompe' => 'Plat a Pompe',
                'Semi coudé simple ' => 'Semi coudé simple ',
                'Semi coudé a Pompe' => 'Semi coudé a Pompe',
                'Coudé simple' => 'Coudé simple',
                'Coudé a Pompe' => 'Coudé a Pompe',
            ], 
             'Gléssiere' => [
                'Téléscopique Simple' => 'Téléscopique Simple',
                'Téléscopique A Pompe' => 'Téléscopique A Pompe',
                'Ordinaire' => 'Ordinaire',
            ],
           'Pass Cable' => [
                'Carrée' => 'Carrée',
                'Ovale' => 'Ovale',
            ],

            'Vis' => [
                '3 cm' => '3 cm' ,
                '3.5 cm' => '3.5 cm' ,
                '4 cm' => '4 cm' ,
                '5 cm' => '5 cm' , 
            ],

             'Roulette' => [
                'Dressing' => 'Dressing',
                'Caisson'=> 'Caisson',
                'Blanc Frigédere'=>'Blanc Frigédere',
            ],

            'Poigné' => [
                '32 mm' => '32 mm',
                '96 mm' => '96 mm',
                '128 mm' => '128 mm',
                '160 mm' => '160 mm',
                '225 mm' => '225 mm',
                '320 mm' => '320 mm',
                '192 mm' => '192 mm',
                'Porte Dressing' => 'Porte Dressing',
            ],

            'Pied' => [
                'Bureaux' => 'Bureaux',
                'Bureaux mini' => 'Bureaux mini',
                'Cuisine' => 'Cuisine',
                'Rond' => 'Rond',
                'Rond Chromé' => 'Rond Chromé',
                'V 850mm'=>'V 850mm'
            ],
            
           'Baguette' => [
                'Baguette' => 'Baguette',
                'Porte Dressing' => 'Porte Dressing',
                 'Traingle' => 'Traingle',
            ],

          'Colle' => [
                'Adhesif'=>'Adhesif',
                'Sac Machine' => 'Sac Machine',
                'Bois' => 'Bois',
            ],

           'Cuisine' => [
            'Mécanisme'=>'Mécanisme',
           'Amartisseur'=>'Amartisseur',
            ],

         'Surrure' => [
                'Armoire'=>'Armoire',
                'Poursoire' => 'Poursoire',
            ],


            'Support' => [
                'Element Cuisine'=>'Element Cuisine',
                'Etagére' => 'Etagére',
                'Plexy' => 'Plexy',
                'Traingle' =>'Traingle'
            ],

           'Delion' => [
                '5 litre'=>'5 litre',
                '25 litre'=>'25 litre',
            ],

          'Surfaceur' => [
                '5 litre'=>'5 litre',
            ],

             'Vernie' => [
                '5 litre'=>'5 litre',
            ],

             'Cheville' => [
                'En Bois' => 'En Bois',
                'Plastique' => 'Plastique' ,
            ],

          'Equerre'=> [
                'Coudée' => 'Coudée',
                'Lit' => 'Lit' ,
            ],


            'Aure Piéces' => [
                'Button'=>'Button',
                'Gravaise'=>'Gravaise',
                'Sabot'=>'Sabot',
                'Changement Direction 12cm'=>'Changement Direction 12cm',
                'Separatteur'=>'Separatteur',
                'Kit Kat' => 'Kit Kat',
                 'Silofane' => 'Silofane',
                 'Ferrure' => 'Ferrure' 
            ],
          
          

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
