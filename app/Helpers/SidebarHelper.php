<?php

if (!function_exists('adminSidebarItems')) {
    function adminSidebarItems(): array
    {
        return [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.admin.index', 'active_pattern' => 'dashboard.admin.index'],
            ],
            'master data' => [
                ['label' => 'visions', 'icon' => 'ti ti-focus-2', 'route' => 'dashboard.admin.master-data.visions.index', 'active_pattern' => 'dashboard.admin.master-data.visions.*'],
                ['label' => 'mission', 'icon' => 'ti ti-target', 'route' => 'dashboard.admin.master-data.missions.index', 'active_pattern' => 'dashboard.admin.master-data.missions.*'],
            ]
        ];
    }
}

if (!function_exists('teacherSidebarItems')) {
    function teacherSidebarItems(): array
    {
        return [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.teacher.index', 'active_pattern' => 'dashboard.teacher.index'],
            ],
        ];
    }
}
