<?php

namespace App\Helpers;

class DateAgo {

    public static function handle($time_ago) {
        $current_time = time();
        $time_elapsed = round(($current_time - ($time_ago)));
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        if ($seconds <= 60) {
            return "vừa xong";
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 phút trước";
            } else {
                return $minutes . " phút trước";
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return "1 giờ trước";
            } else {
                return $hours . " giờ trước";
            }
        } else if ($days <= 7) {
            if ($days == 1) {
                return "hôm qua";
            } else {
                return $days . " ngày trước";
            }
        } else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "1 tuần trước";
            } else {
                return $weeks . " tuần trước";
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return "1 tháng ";
            } else {
                return "$months tháng trước";
            }
        } else {
            if ($years == 1) {
                return "1 năm trước ";
            } else {
                return $years . " năm trước";
            }
        }
    }

}
