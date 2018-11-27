<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotificationController;
use App\Model\User;
use Illuminate\Console\Command;

class SendNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:send-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send user notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $now = date('Y-m-d H:i:s');

        $users = User::where('last_activity', '<', date('Y-m-d H:i:s', strtotime("$now - 3 hours")))->where('subscribe_view', 1)->get();

        foreach ($users as $user){

            NotificationController::sendViewProducts($user);

        }

        $users = User::where('last_activity', '<', date('Y-m-d H:i:s', strtotime("$now - 7 days")))->where('subscribe_wishlist', 1)->get();

        foreach ($users as $user){

            NotificationController::sendWishListProducts($user);

        }

        $users = User::where('last_activity', '<', date('Y-m-d H:i:s', strtotime("$now - 24 hours")))->where('subscribe_cart', 1)->get();

        foreach ($users as $user){

            NotificationController::sendCartProducts($user);

        }


    }
}
