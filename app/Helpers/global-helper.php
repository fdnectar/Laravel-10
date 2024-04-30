<?php

if(!function_exists('timeAgo')) {
    function timeAgo($timestamps) {
        $timedifference = time() - strtotime($timestamps);
        $seconds = $timedifference;
        $minutes = round($timedifference / 60);
        $hours = round($timedifference / 3600);
        $days = round($timedifference / 86400);

        if($seconds <= 60) {
            if($seconds <= 1) {
                return "Now";
            }
            return $seconds. "s ago";
        } elseif($minutes <= 60) {
            return $minutes. "m ago";
        } elseif($hours <= 24) {
            return $hours. "h ago";
        } else {
            return date('J M y', strtotime($timestamps));
        }
    }
}
