<?php

if (!function_exists('adminSidebarItems')) {
    function adminSidebarItems(): array
    {
        return [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.admin.index', 'activePattern' => 'dashboard.admin.index'],
            ],
            'master data' => [
                ['label' => 'visions', 'icon' => 'ti ti-eye', 'route' => 'dashboard.admin.master-data.visions.index', 'activePattern' => 'dashboard.admin.master-data.visions.*'],
                ['label' => 'mission', 'icon' => 'ti ti-rocket', 'route' => 'dashboard.admin.master-data.missions.index', 'activePattern' => 'dashboard.admin.master-data.missions.*'],
                ['label' => 'school histories', 'icon' => 'ti ti-book', 'route' => 'dashboard.admin.master-data.school-histories.index', 'activePattern' => 'dashboard.admin.master-data.school-histories.*'],
                ['label' => 'contacts', 'icon' => 'ti ti-message', 'route' => 'dashboard.admin.master-data.contacts.index', 'activePattern' => 'dashboard.admin.master-data.contacts.*'],
            ]
        ];
    }
}

if (!function_exists('teacherSidebarItems')) {
    function teacherSidebarItems(): array
    {
        return [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.teacher.index', 'activePattern' => 'dashboard.teacher.index'],
            ],
        ];
    }
}
