<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\TransactionModel;
use App\Models\UserModel;
use App\Models\DealsOffersModel;
use App\Models\BusinessListingModel;
use SMS;
use Mail;

class MembershipExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business_membership:update_expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membership Expired ';

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

        $dt_today =   \date("Y-m-d");
        $obj_transaction_listing = TransactionModel::where('expire_date',$dt_today)->get();
        if($obj_transaction_listing)
        {
            $transaction_listing = $obj_transaction_listing->toArray();
        }
        $notify_user_emails =[];
       // dd($transaction_listing);
        if(sizeof($transaction_listing)>0 && isset($transaction_listing))
        {
            
            foreach ($transaction_listing as $exp_membership) 
            {
                $user_id=$exp_membership['user_id'];
                $business_id=$exp_membership['business_id'];

                $obj_user_data = UserModel::where('id',$user_id)->first(['first_name','email','mobile_no']);

                if ($obj_user_data) 
                {
                    $user_data = $obj_user_data->toArray();

                    $notify_user_emails[] = $user_data;
                }

                $update_deal_array['is_active']=0;
                $update_deals=DealsOffersModel::where('business_id',$business_id)->update($update_deal_array);

                $update_businss_array['is_active']=0;
                $update_businss_array['is_verified']=0;
                $update_business = BusinessListingModel::where('id',$business_id)->update($update_businss_array);

              
            }
        }
         if (isset($notify_user_emails) && sizeof($notify_user_emails)>0) 
          {

               foreach ($notify_user_emails as $users) 
               {
                    if($users['email'] !='')
                    {
                       $user_email = $users['email'];
                    }
                    $name = $users['first_name'];
                    $mobile_no = $users['mobile_no'];
                    $expiry_date = $dt_today;
                    $loign_link  = url().'/login';

                    $data['name'] = $name;
                    $data['expiry_date'] = $expiry_date;
                    $data['loign_link'] = $loign_link;
                    if($users['email'] !='')
                    {
                      Mail::send('front.email.expiry_location_membership', $data, function ($message) use ($user_email) 
                      {
                            $message->from('support@rightnext.com', 'RightNext');
                            $message->subject('RightNext :: Expiration of Business Membership Plan');
                            $message->to($user_email);
                      }); 
                      $this->info('The Mail  were sent successfully!');
                    }
                    else
                    {
                        SMS::to($mobile_no)
                       ->msg('Dear ' . $first_name . ',Your Membership Plan Get Expired !')
                       ->send();
                       $this->info('The messages were sent successfully!');
                    }     
               }
              
          }
          $this->info('The Notification were sent successfully!');

    }
}
