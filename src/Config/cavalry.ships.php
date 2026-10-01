<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Jump-capable ship groups
    |--------------------------------------------------------------------------
    |
    | Curated InvGroup IDs for hulls with jump drives (capitals + black ops).
    | Command Carriers were converted into Force Auxiliaries in EVE Online.
    |
    */
    'groups' => [
        30 => [
            'key' => 'titans',
            'label' => 'Titans',
            'icon' => 'fas fa-crown',
            'color' => 'danger',
        ],
        659 => [
            'key' => 'supercarriers',
            'label' => 'Supercarriers',
            'icon' => 'fas fa-fighter-jet',
            'color' => 'warning',
        ],
        547 => [
            'key' => 'carriers',
            'label' => 'Carriers',
            'icon' => 'fas fa-plane',
            'color' => 'info',
        ],
        485 => [
            'key' => 'dreadnoughts',
            'label' => 'Dreadnoughts',
            'icon' => 'fas fa-crosshairs',
            'color' => 'primary',
        ],
        1538 => [
            'key' => 'force_auxiliaries',
            'label' => 'Force Auxiliaries',
            'icon' => 'fas fa-medkit',
            'color' => 'success',
        ],
        902 => [
            'key' => 'jump_freighters',
            'label' => 'Jump Freighters',
            'icon' => 'fas fa-truck',
            'color' => 'secondary',
        ],
        898 => [
            'key' => 'black_ops',
            'label' => 'Black Ops',
            'icon' => 'fas fa-user-secret',
            'color' => 'dark',
        ],
        883 => [
            'key' => 'capital_industrials',
            'label' => 'Capital Industrials',
            'icon' => 'fas fa-industry',
            'color' => 'olive',
        ],
    ],
];
