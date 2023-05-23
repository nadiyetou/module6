<?php

function getDynamicDateTimeDisplay($date, $time) {
    $postDateTime = new DateTime($date . ' ' . $time);
    $currentDateTime = new DateTime();
    
    $interval = $postDateTime->diff($currentDateTime);
    
    if ($interval->y >= 1) {
        return $postDateTime->format('Y-m-d H:i:s');
    } else if ($interval->m >= 1 || $interval->d >= 7) {
        return $postDateTime->format('M j');
    } else if ($interval->d >= 1) {
        return $interval->d == 1 ? 'Yesterday' : $interval->d . ' days ago';
    } else if ($interval->h >= 1) {
        return $interval->h == 1 ? '1 hour ago' : $interval->h . ' hours ago';
    } else if ($interval->i >= 1) {
        return $interval->i == 1 ? '1 minute ago' : $interval->i . ' minutes ago';
    } else {
        return 'Just now';
    }
}

?>
