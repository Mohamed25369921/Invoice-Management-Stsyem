<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            
        $total = Invoice::count();
        $paid = Invoice::where('value_status',1)->count() / $total *100;
        $unpaid = Invoice::where('value_status',2)->count() / $total *100;
        $partial_paid = Invoice::where('value_status',3)->count() / $total *100;

        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 300])
        ->labels(['الفواتير غير المدفوعة', 'الفواتير المدفوعة جزئيا', 'الفواتير المدفوعة'])
        ->datasets([
            [
                "label" => "الفواتير الغير المدفوعة",
                'backgroundColor' => ['#ec5858'],
                'data' => [$unpaid]
            ],
            [
                "label" => "الفواتير المدفوعة",
                'backgroundColor' => ['#81b214'],
                'data' => [$paid]
            ],
            [
                "label" => "الفواتير المدفوعة جزئيا",
                'backgroundColor' => ['#ff9642'],
                'data' => [$partial_paid]
            ],
        ])
        ->options([]);

        $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير غير المدفوعة','الفواتير المدفوعة'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [$unpaid, $paid]
                ]
            ])
            ->options([]);
        return view('home', compact('chartjs', 'chartjs2'));
    }
}
