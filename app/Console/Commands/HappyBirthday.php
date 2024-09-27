<?php

namespace App\Console\Commands;

use App\Models\UserModel;
use Illuminate\Console\Command;

class HappyBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a Happy birthday message to users via SMS';

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
        $obj_users = UserModel::whereRaw('MONTH(d_o_b) = MONTH(NOW())')
            ->whereRaw('Day(d_o_b) = Day(NOW())')
            ->get();
        if ($obj_users) {
            $users = $obj_users->toArray();
            //dd($users);
            /* if(sizeof($users)>0 && isset($users))
             {
                foreach( $users as $user )
                {
                 if($user['mobile_no']!='')
                  {
                    \Sms::send($user['mobile_no'])
                    ->msg('Dear ' . $user->first_name . ', I wish you a happy birthday!')
                    ->send();
                  }

                }
            }*/
        }

        $this->info('The happy birthday messages were sent successfully!');
    }
}
