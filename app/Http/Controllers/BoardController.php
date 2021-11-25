<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $boards = Title::all()
            ->sortByDesc('created_at');


        $cards = DB::table('titles')
            ->join('cards', 'titles.id', "=", 'cards.table_id')
            ->where('cards.table_id', 50)
            // // ->select('cards.*','titles.*')
            ->get();
        // dd($boards->sortBy('created_at'));
        return view('tasks.overview', compact('boards', 'cards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $validated = $request->validate([
            'title' => 'required|string',
        ]);

        $title = [
            'title' => $request->title,
            'user_id' => $user_id,
        ];

        Title::create($title);

        return redirect()->back()
            ->with('success', "Your board has been create!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $board = Title::find($id);
        $cards = DB::table('titles')
            ->join('cards', 'titles.id', "=", 'cards.table_id')
            ->where('cards.table_id', $id)
            ->get();

        // dd($cards);
        return view('tasks.task', compact('board', 'cards'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $board = Title::find($id);
        $board->title = $request->custom_title;
        $board->user_id = $user_id;

        $board->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = Title::find($id);
        $card->delete();

        return redirect()->back()
            ->with('success', 'Your board "' . $card->title . '" has been deleted!');
    }
}
