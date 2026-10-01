<?php

return [
    'cavalry' => [
        'name' => 'cavalry',
        'label' => 'cavalry::seat.menu_label',
        'icon' => 'fas fa-fighter-jet',
        'route_segment' => 'cavalry',
        'permission' => 'cavalry.view',
        'entries' => [
            [
                'name' => 'overview',
                'label' => 'cavalry::seat.menu_overview',
                'icon' => 'fas fa-binoculars',
                'route' => 'cavalry::overview',
                'permission' => 'cavalry.view',
            ],
        ],
    ],
];
