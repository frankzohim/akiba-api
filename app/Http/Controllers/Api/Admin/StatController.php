<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Town;
use App\Http\Resources\TownResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Payment;

class StatController extends Controller
{
    public function users(){

        $dateFrom = Carbon::now()->subDays(30);
        $dateTo = Carbon::now();

        $monthly = User::where('suspended_at',"=",null)->whereBetween('created_at', [$dateFrom, $dateTo])->count();
        $previousDateFrom = Carbon::now()->subDays(60);
        $previousDateTo = Carbon::now()->subDays(31);
        $previousMonthly = User::where('suspended_at',"=",null)->whereBetween('created_at', [$previousDateFrom, $previousDateTo])->count();
        if ($previousMonthly < $monthly) {
            if ($previousMonthly > 0) {
                $percent_from = $monthly - $previousMonthly;
                if($percent_from != 0)
                  (int)  $percent = ($previousMonthly * 100)/$percent_from ; //increase percent
                else 
                    $percent = 0;
                return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent)]);
            } else {
                (int) $percent = 100;
                return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent)]);
            }
        } else {
            $percent_from = $previousMonthly - $monthly;
             if($percent_from != 0)
              (int) $percent = ($previousMonthly * 100)/$percent_from ;
            else
              $percent = 0;

            return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent)]);
        }

    }

    public function escorts(){

        $dateFrom = Carbon::now()->subDays(30);
        $dateTo = Carbon::now();

        $monthly = User::where('role_id',2)->whereBetween('created_at', [$dateFrom, $dateTo])->count();
        $previousDateFrom = Carbon::now()->subDays(60);
        $previousDateTo = Carbon::now()->subDays(31);
        $previousMonthly = User::where('role_id',2)->whereBetween('created_at', [$previousDateFrom, $previousDateTo])->count();
        if ($previousMonthly < $monthly) {
            if ($previousMonthly > 0) {
                $percent_from = $monthly - $previousMonthly;
                  if($percent_from != 0)
                        (int)  $percent = ($previousMonthly * 100)/$percent_from ; //increase percent
                else
                    $percent = 0;
                return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent)]);
            } else {
                (int) $percent = 100;
                return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent)]);
            }
        } else {
            $percent_from = $previousMonthly - $monthly;
             if($percent_from != 0)
              (int) $percent = ($previousMonthly * 100)/$percent_from ;
            else
                $percent = 0;

            return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent)]);
        }


    }

    public function statIncomes(){
        $dateFrom = Carbon::now()->subDays(30);
        $dateTo = Carbon::now();
        $incomes=Payment::whereBetween('created_at', [$dateFrom, $dateTo])->get();
        $monthly=Payment::whereBetween('created_at', [$dateFrom, $dateTo])->count();
        $total=$incomes->sum('price');
        $previousDateFrom = Carbon::now()->subDays(60);
        $previousDateTo = Carbon::now()->subDays(31);
        $previousMonthly = User::where('role_id',2)->whereBetween('created_at', [$previousDateFrom, $previousDateTo])->count();
        if ($previousMonthly < $monthly) {
            if ($previousMonthly > 0) {
                $percent_from = $monthly - $previousMonthly;
                 if($percent_from != 0)
                    (int)  $percent = ($previousMonthly * 100)/$percent_from ; //increase percent
                 else
                    $percent = 0;
                return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent),'total'=>$total]);
            } else {
                (int) $percent = 100;
                return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent),'total'=>$total]);
            }
        } else {
            $percent_from = $previousMonthly - $monthly;
             if($percent_from != 0)
                (int) $percent = ($previousMonthly * 100)/$percent_from ;
             else
                $percent = 0;

            return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent),'total'=>$total]);
        }

    }

    public function statAnnounces(){
        $dateFrom = Carbon::now()->subDays(30);
        $dateTo = Carbon::now();

        $monthly = Announcement::whereBetween('created_at', [$dateFrom, $dateTo])->count();
        $previousDateFrom = Carbon::now()->subDays(60);
        $previousDateTo = Carbon::now()->subDays(31);
        $previousMonthly = Announcement::whereBetween('created_at', [$previousDateFrom, $previousDateTo])->count();
        if ($previousMonthly < $monthly) {
            if ($previousMonthly > 0) {
                $percent_from = $monthly - $previousMonthly;
                 if($percent_from != 0)
                    (int)  $percent = ($previousMonthly * 100)/$percent_from ; //increase percent
                 else 
                  $percent = 0;
                return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent)]);
            } else {
                (int) $percent = 100;
                return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent)]);
            }
        } else {
            $percent_from = $previousMonthly - $monthly;
             if($percent_from != 0)
                (int) $percent = ($previousMonthly * 100)/$percent_from ;
             else 
              $percent = 0;

            return response()->json(['monthly'=>$monthly,'percent'=>number_format($percent)]);
        }

    }

    public function statCurrentWeek(){
        $currentWeek=Payment::where('created_at', '>', Carbon::now()->startOfWeek())
     ->where('created_at', '<', Carbon::now()->endOfWeek())
     ->get();
     $total=$currentWeek->sum('price');

     return $total;
    }
    public function statPreviousWeek(){
        $currentWeek=Payment::where('created_at', '>', Carbon::now()->startOfWeek()->subDays(7))
        ->where('created_at', '<', Carbon::now()->startOfWeek()->subDays(1))
        ->get();
        $total=$currentWeek->sum('price');

        return $total;

     //return Carbon::now()->startOfWeek()->subDays(1);
    }

    public function statTown(){

        $towns = TownResource::collection(Town::all());
        $towns = $towns->sortBy([
                            ['ads', 'desc'],
                        ]);
        $towns = $towns->take(5);
        return $towns;
    }

}
