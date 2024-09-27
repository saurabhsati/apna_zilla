<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\BusinessListingModel;
use App\Models\DealsOffersModel;
use Session;
use Sentinel;
use DB;
use Khill\Lavacharts\Lavacharts as Lava;

class DashboardController extends Controller
{
 	public function __construct()
 	{
 		$arr_except_auth_methods = array();
 		$this->middleware('\App\Http\Middleware\SentinelCheck',['except' => $arr_except_auth_methods]);
 	}   

 	public function index()
 	{
 		$page_title   = "Dashboard";

 		$vender_count = $sales_executive_count = $business_listing_count = $deals_count = 0;
 		$obj_user     = $obj_sales_executive  = $obj_business_listing = $obj_deal = [];

 		$obj_user     = Sentinel::createModel()->where('role','=','normal')->get();
 		if($obj_user!= FALSE)
 		{
 			$vender_count=	sizeof($obj_user->toArray());
 		}

 		$obj_sales_executive = Sentinel::createModel()->where('role','=','sales')->get();
    $all_sales_executive=[];
 		if($obj_sales_executive!=FALSE)
 		{
      $all_sales_executive=$obj_sales_executive->toArray();
 			$sales_executive_count=	sizeof($obj_sales_executive->toArray());
 		}

 		$obj_business_listing = BusinessListingModel::get();
        if($obj_business_listing)
        {
            $business_listing_count = sizeof($obj_business_listing->toArray());
        }

 		$obj_deal=DealsOffersModel::get();
        if($obj_deal)
         {
            $deals_count = sizeof($obj_deal->toArray());
         }
      
            $users = DB::table('users')
              ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(id) as user_count'))
              ->where('role','=','normal')
              ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
              ->get();

               $users_array = json_decode(json_encode($users), True);

           $sales_executive = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(id) as executive_count'))
            ->where('role','=','sales')
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

           $sales_executive_array = json_decode(json_encode($sales_executive), True);
           //123456789
          
           $businesses = DB::table('business')
              ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(id) as business_count'))
              ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
              ->get();

               $businesses_array = json_decode(json_encode($businesses), True);

           $deals = DB::table('deals')
              ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(id) as deal_count'))
              ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
              ->get();

            $deals_array = json_decode(json_encode($deals), True);
             

            


		return view('web_admin.dashboard.dashboard',compact('page_title','page_title','vender_count','sales_executive_count','business_listing_count','deals_count','users_array','sales_executive_array','businesses_array','deals_array','all_sales_executive'));
 	}	

  public function view_sales_activity(Request $request)
  {
     $from_date=$request->input('from_date',true);
     $to_date=$request->input('to_date',true);
     $sales_user_public_id=$request->input('sales_user_public_id',true);
     list($month,$day,$year)=explode('/',$from_date);
     $from=$year."-".$month."-".$day;
     list($month,$day,$year)=explode('/',$to_date);
      $to=$year."-".$month."-".$day;

      $format="csv";


       if($format=="csv")
        {
            $arr_business_list = array();
            $obj_business_list = BusinessListingModel::with(['user_details','category_details.category_business','get_sub_category.category_list.parent_category'])->
            where('sales_user_public_id',$sales_user_public_id)
            ->whereBetween('created_at',array($from.' 00:00:00',$to.' 00:00:00'))
            ->get();
            //dd($obj_business_list);

            if($obj_business_list)
            {
                $arr_business_list = $obj_business_list->toArray();

              /*  \Excel::create('BUSINESS_LIST-'.date('Ymd').uniqid(), function($excel) use($arr_business_list)
                {
                    $excel->sheet('Business_list', function($sheet) use($arr_business_list)
                    {
                        // $sheet->cell('A1', function($cell) {
                        //     $cell->setValue('Generated on :'.date("d-m-Y H:i:s"));
                        // });

                        $sheet->row(3, array(
                            'Sr.No.','Business Name','Business Category :: Sub-Category', 'Full Name', 'Email', 'mobile No.'
                        ));

                        if(sizeof($arr_business_list)>0)
                        {
                            $arr_tmp = array();
                            foreach ($arr_business_list as $key => $business_list)
                            {
                                $arr_tmp[$key][] = $key+1;
                                $arr_tmp[$key][] = $business_list['business_name'];

                                $cat_subcat_title = '';
                                foreach($business_list['get_sub_category'] as $cat_subcat)
                                {
                                    $cat_subcat_title.=  $cat_subcat['category_list']['parent_category']['title'].' :: '.$cat_subcat['category_list']['title'];
                                    $cat_subcat_title.= ', ';
                                }
                                $arr_tmp[$key][] = $cat_subcat_title;

                                $arr_tmp[$key][] = $business_list['user_details']['first_name'].' '.$business_list['user_details']['last_name'];
                                $arr_tmp[$key][] = $business_list['user_details']['email'];
                                $arr_tmp[$key][] = $business_list['user_details']['mobile_no'];
                            }

                            $sheet->rows($arr_tmp);
                        }

                    });

                })->export('csv');*/
            }
           
        }




     $business_listing =[];
     $obj_business_listing = BusinessListingModel::with(['user_details','category_details.category_business','get_sub_category.category_list.parent_category'])->where('sales_user_public_id',$sales_user_public_id)
         ->whereBetween('created_at',array($from.' 00:00:00',$to.' 00:00:00'))
         ->get();
       //  dd($obj_business_listing);
        if($obj_business_listing)
        {
            $business_listing = $obj_business_listing->toArray();
        }
    
     $str='';
      $str.="<table class='table table-bordered'>
              <thead>
                <tr>
                 <th>Business Id</th>
                  <th>Business Name</th>
                  <th>Vendor Name</th>
                  <th>Business Category :: SubCategory</th>
                  <th>Phone Number</th>
                  <th>City</th>
                  <th>Created Date</th>
                 </tr>
              </thead>
              <tbody>";
                if(sizeof($business_listing)>0)
                 {
                  foreach($business_listing as $key => $business)
                   {

                      $cat_subcat_title = '';
                      foreach($business['get_sub_category'] as $cat_subcat)
                      {
                          $cat_subcat_title.=  $cat_subcat['category_list']['parent_category']['title'].' :: '.$cat_subcat['category_list']['title'];
                          $cat_subcat_title.= ', ';
                      }
                      //$arr_tmp[$key][] = $cat_subcat_title;
                    
                     $str.="<tr> <td>". $business['busiess_ref_public_id']."</td>
                       <td>". ucfirst($business['business_name'])."</td>
                       <td>". ucfirst($business['user_details']['first_name'])."</td>

                       <td>". $cat_subcat_title."</td>
                        <td>".$business['user_details']['mobile_no']."</td>
                       <td>". $business['city']."</td>
                       <td>". date('d M Y',strtotime($business['created_at']))."</td>
                      </tr> ";              
                   }
                       $str.="<tr><td colspan='7'><div id='pagging' style='padding-top:10px;' class='paginate'></div></td></tr>";
                } 
                else 
                { 
                  $str.="<tr><td colspan='7'><strong>He Don't Have Any Business Records Available.</strong></td></tr>";
                
                 }
              $str.="</tbody>
            </table>";
      /*$str.='<script type="text/javascript">
      FusionCharts.ready(function () {
      var revenueChart = new FusionCharts({
          "type": "column3d",
          "renderAt": "view_job_chart",
          "width": "900",
          "height": "300",
          "dataFormat": "json",
          "dataSource": {
             "chart": {
                "caption": "Job Application Posted",
                "xAxisName": "Month",
                "yAxisName": "No of Application posted",
                "theme": "fint"
             },
             "data": [';
                 
                      $i=0;
                      if(sizeof($business_listing)>0 && isset($business_listing))
                      foreach($business_listing as $row)
                      { 
                          $i++;   
     
                         $str.='{
                             "label": "'.ucfirst($row['post_month']).'",
                             "value": "'.ucfirst($row['job_count']).'"
                          },';
                 }
                      if($i<count($res))
                          echo",";
              
             $str.=' ]
          }

      });
      revenueChart.render();
  });
   </script>';*/
   echo $str;
   }


  
}
