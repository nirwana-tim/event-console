<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('e')) {
    function e($value)
    {
        return html_escape($value);
    }
}

if (!function_exists('active_sidebar_class')) {
    function active_sidebar_class($menu, $active_menu)
    {
        return $menu === $active_menu ? ' active' : '';
    }
}

if (!function_exists('flash_alert')) {
    function flash_alert($type)
    {
        $CI =& get_instance();
        $message = $CI->session->flashdata($type);

        if (!$message) {
            return '';
        }

        $classes = array(
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info',
        );

        $icons = array(
            'success' => 'bi-check-circle',
            'error' => 'bi-exclamation-circle',
            'warning' => 'bi-exclamation-triangle',
            'info' => 'bi-info-circle',
        );

        $class = isset($classes[$type]) ? $classes[$type] : 'alert-secondary';
        $icon = isset($icons[$type]) ? $icons[$type] : 'bi-info-circle';

        return '<div class="alert '.$class.'"><i class="bi '.$icon.' me-2"></i>'.e($message).'</div>';
    }
}

if (!function_exists('status_badge_class')) {
    function status_badge_class($status)
    {
        $classes = array(
            'approved' => 'success',
            'verified' => 'success',
            'pending' => 'warning',
            'rejected' => 'danger',
            'dibuka' => 'success',
            'ditutup' => 'warning',
            'selesai' => 'secondary',
        );

        return isset($classes[$status]) ? $classes[$status] : 'secondary';
    }
}

if (!function_exists('attendance_badge_class')) {
    function attendance_badge_class($attendance)
    {
        $classes = array(
            'present' => 'success',
            'absent' => 'danger',
            'unconfirmed' => 'secondary',
        );

        return isset($classes[$attendance]) ? $classes[$attendance] : 'secondary';
    }
}

if (!function_exists('role_badge_class')) {
    function role_badge_class($role)
    {
        $classes = array(
            'admin' => 'primary',
            'participant' => 'secondary',
        );

        return isset($classes[$role]) ? $classes[$role] : 'secondary';
    }
}

if (!function_exists('app_date')) {
    function app_date($date)
    {
        if (!$date) {
            return '-';
        }

        $timestamp = strtotime($date);

        return $timestamp ? date('d/m/Y', $timestamp) : $date;
    }
}
