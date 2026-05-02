<?php

if (!function_exists('adminSidebarItems')) {
    function adminSidebarItems(): array
    {
        return [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.admin.index', 'activePattern' => 'dashboard.admin.index'],
            ],
            'master data' => [
                ['label' => 'visions', 'icon' => 'ti ti-target', 'route' => 'dashboard.admin.master-data.visions.index', 'activePattern' => 'dashboard.admin.master-data.visions.*'],
                ['label' => 'mission', 'icon' => 'ti ti-list-check', 'route' => 'dashboard.admin.master-data.missions.index', 'activePattern' => 'dashboard.admin.master-data.missions.*'],
                ['label' => 'school histories', 'icon' => 'ti ti-timeline-event', 'route' => 'dashboard.admin.master-data.school-histories.index', 'activePattern' => 'dashboard.admin.master-data.school-histories.*'],
                ['label' => 'contacts', 'icon' => 'ti ti-message-2-share', 'route' => 'dashboard.admin.master-data.contacts.index', 'activePattern' => 'dashboard.admin.master-data.contacts.*'],
                ['label' => 'subjects', 'icon' => 'ti ti-book', 'route' => 'dashboard.admin.master-data.subjects.index', 'activePattern' => 'dashboard.admin.master-data.subjects.*'],
                ['label' => 'classrooms', 'icon' => 'ti ti-chalkboard', 'route' => 'dashboard.admin.master-data.classrooms.index', 'activePattern' => 'dashboard.admin.master-data.classrooms.*'],
            ],
            'gallery' => [
                ['label' => 'groups', 'icon' => 'ti ti-folders', 'route' => 'dashboard.admin.gallery.groups.index', 'activePattern' => 'dashboard.admin.gallery.groups.*'],
                ['label' => 'images', 'icon' => 'ti ti-photo', 'route' => 'dashboard.admin.gallery.images.index', 'activePattern' => 'dashboard.admin.gallery.images.*'],
                ['label' => 'videos', 'icon' => 'ti ti-video', 'route' => 'dashboard.admin.gallery.videos.index', 'activePattern' => 'dashboard.admin.gallery.videos.*'],
            ],
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
