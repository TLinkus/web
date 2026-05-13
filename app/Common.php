<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('lt_role')) {
    function lt_role(?string $role): string
    {
        return [
            'system_admin' => 'Sistemos administratorius',
            'company_admin' => 'Įmonės administratorius',
            'tutor' => 'Korepetitorius',
            'student' => 'Mokinys',
        ][$role] ?? (string) $role;
    }
}

if (! function_exists('lt_status')) {
    function lt_status(?string $status): string
    {
        return [
            'active' => 'Aktyvus',
            'inactive' => 'Neaktyvus',
            'planned' => 'Planuojama',
            'completed' => 'Įvyko',
            'cancelled' => 'Atšaukta',
        ][$status] ?? (string) $status;
    }
}
