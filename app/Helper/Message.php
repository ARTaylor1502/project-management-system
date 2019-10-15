<?php

namespace App\Helper;

class Message
{
    public function getWelcomeMessage() {
        if (date('H') < 12) {
            $message = 'Good Morning';
        } else if(date('H') >= 12 && date('H') < 17) {
            $message = 'Good Afternoon';
        } else {
            $message = 'Good Evening';
        }

        return $message;
    }
}
