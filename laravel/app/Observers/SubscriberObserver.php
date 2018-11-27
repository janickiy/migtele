<?php

namespace App\Observers;


class SubscriberObserver
{

    public function saving($subscriber)
    {
        $subscriber->unsubscriber_hash = md5(str_random(10));
    }

}