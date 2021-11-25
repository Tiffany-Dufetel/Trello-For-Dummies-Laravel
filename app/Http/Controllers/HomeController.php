<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $boards = Title::all();
        $cards = DB::table('titles')
            ->join('cards','titles.id',"=",'cards.table_id')
            ->where('cards.table_id', 50)
            // // ->select('cards.*','titles.*')
            ->get();
        // dd($cards) ;
        return view('tasks.overview', compact('boards','cards'));
    }
}
