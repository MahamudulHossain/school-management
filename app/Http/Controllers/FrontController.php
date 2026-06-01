<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notice;
use App\Models\AboutUs;
use App\Models\Portfolio;
use App\Models\EventHoliday;
use App\Models\PortfolioTag;
use Illuminate\Http\Request;
use App\Models\FrontCarousel;

class FrontController extends Controller
{
    public function front(){
        $carousels = FrontCarousel::where('status','active')->orderBy('serial')->get();
        $aboutUs = AboutUs::first();
        $notice = Notice::orderBy('id', 'desc')->get()->take(10);
        $current_date = date('Y-m-d').' 00:00:00';
        $current_date2 = date('Y-m-d').' 23:59:59';
        $s_year=date('Y').'-00-00 00:00:00';
        $e_year=date('Y').'-12-31 23:59:59';
        $holiday = EventHoliday::where('type','holiday')
            ->whereBetween('start_date' ,[$current_date,$e_year])
            ->orderBy('start_date')
            ->get();
        $recent_holiday = EventHoliday::where('type','holiday')
            ->whereBetween('end_date' ,[$s_year,$current_date])
            ->orderBy('start_date','DESC')
            ->get();

        $users = User::with('teacher')->with('imageprofile')->where('user_type_id',3)->orderBy('id','DESC')->get();
        $portfolio_tags = PortfolioTag::where('status', 'active')->get();
        $portfolios = Portfolio::whereHas('tag', function ($query) {
            $query->where('status', 'active');
        })->get();
        // dd($portfolios);
        return view('front.site',compact('carousels','aboutUs','notice','holiday','recent_holiday','users','portfolio_tags','portfolios'));
    }

    public function getEvents()
    {
        $events = EventHoliday::all()->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->start_date,
                'end'   => date('Y-m-d', strtotime($event->end_date . ' +1 day')),
            ];
        });

        return response()->json($events);
    }
}
