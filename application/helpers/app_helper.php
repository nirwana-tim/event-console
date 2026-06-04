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

if (!function_exists('status_label')) {
    function status_label($status)
    {
        $labels = array(
            'dibuka' => 'Open',
            'ditutup' => 'Closed',
            'selesai' => 'Completed',
            'pending' => 'Pending',
            'approved' => 'Approved',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
        );

        return isset($labels[$status]) ? $labels[$status] : ucfirst((string) $status);
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

if (!function_exists('attendance_label')) {
    function attendance_label($attendance)
    {
        $labels = array(
            'present' => 'Present',
            'absent' => 'Absent',
            'unconfirmed' => 'Unconfirmed',
        );

        return isset($labels[$attendance]) ? $labels[$attendance] : ucfirst((string) $attendance);
    }
}

if (!function_exists('app_timezone')) {
    function app_timezone()
    {
        return new DateTimeZone('Asia/Jakarta');
    }
}

if (!function_exists('app_datetime')) {
    function app_datetime($date)
    {
        if (!$date) {
            return false;
        }

        try {
            return new DateTime($date, app_timezone());
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('app_date')) {
    function app_date($date)
    {
        if (!$date) {
            return '-';
        }

        $datetime = app_datetime($date);
        if (!$datetime) {
            return $date;
        }

        $day = $datetime->format('j');
        $month = (int) $datetime->format('n');
        $year = $datetime->format('Y');

        $months = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );

        return $day . ' ' . $months[$month] . ' ' . $year;
    }
}

if (!function_exists('human_diff')) {
    function human_diff($date)
    {
        if (!$date) {
            return '-';
        }

        $datetime = app_datetime($date);
        if (!$datetime) {
            return $date;
        }

        $now = new DateTime('now', app_timezone());
        $diff = $now->getTimestamp() - $datetime->getTimestamp();

        if ($diff == 0) {
            return 'Now';
        }

        $is_future = $diff < 0;
        $diff = abs($diff);

        $units = array(
            31536000 => 'year',
            2592000  => 'month',
            604800   => 'week',
            86400    => 'day',
            3600     => 'hour',
            60       => 'minute',
            1        => 'second'
        );

        foreach ($units as $seconds => $label) {
            if ($diff >= $seconds) {
                $count = floor($diff / $seconds);
                $result = $count . ' ' . $label . ($count > 1 ? 's' : '');
                
                if ($is_future) {
                    return 'in ' . $result;
                }
                return $result . ' ago';
            }
        }

        return $date;
    }
}
