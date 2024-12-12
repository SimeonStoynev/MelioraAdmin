<?php

return [
    'rolesWithPermissions' => [
        'Super Admin' => ['manage_ads', 'manage_ad_templates', 'read_dashboard', 'system_configurations'],
        'Admin' => ['manage_ads', 'manage_ad_templates', 'read_dashboard'],
        'Editor' => ['manage_ads', 'manage_ad_templates'],
        'Viewer' => ['read_dashboard'],
    ]
];
