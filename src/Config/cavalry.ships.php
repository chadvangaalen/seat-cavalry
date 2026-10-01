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
    | "accent" drives metric-card icon wells (SRUN muted palette — no Bootstrap blues).
    |
    */
    'groups' => [
        30 => [
            'key' => 'titans',
            'label' => 'Titans',
            'icon' => 'fas fa-crown',
            'accent' => 'titans',
        ],
        659 => [
            'key' => 'supercarriers',
            'label' => 'Supercarriers',
            'icon' => 'fas fa-fighter-jet',
            'accent' => 'supercarriers',
        ],
        547 => [
            'key' => 'carriers',
            'label' => 'Carriers',
            'icon' => 'fas fa-plane',
            'accent' => 'carriers',
        ],
        485 => [
            'key' => 'dreadnoughts',
            'label' => 'Dreadnoughts',
            'icon' => 'fas fa-crosshairs',
            'accent' => 'dreadnoughts',
        ],
        1538 => [
            'key' => 'force_auxiliaries',
            'label' => 'Force Auxiliaries',
            'icon' => 'fas fa-medkit',
            'accent' => 'force_auxiliaries',
        ],
        902 => [
            'key' => 'jump_freighters',
            'label' => 'Jump Freighters',
            'icon' => 'fas fa-truck',
            'accent' => 'jump_freighters',
        ],
        898 => [
            'key' => 'black_ops',
            'label' => 'Black Ops',
            'icon' => 'fas fa-user-secret',
            'accent' => 'black_ops',
        ],
        883 => [
            'key' => 'capital_industrials',
            'label' => 'Capital Industrials',
            'icon' => 'fas fa-industry',
            'accent' => 'capital_industrials',
        ],
    ],
];
