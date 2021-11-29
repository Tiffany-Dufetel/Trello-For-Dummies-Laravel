<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Comment;
use App\Models\Guess;
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
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        $email = Auth::user()->email;

        $boards = Title::with('user')
            ->where([['user_id', $user_id]])
            ->orderByDesc('created_at')
            ->get();
        // dd($users);

        $boardsGuess = Guess::with('board')
            ->where('guess', $email)
            ->get();

        // dd($boardsGuess);


        $cards = Card::with('board')
            ->get();

        return view('tasks.overview', compact('boards', 'cards', 'name', 'user_id', 'boardsGuess'));
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

        $auth = Auth::user();
        $user_id = $auth->id;

        $board = Title::find($id);

        // $cards = Card::with('board')
        //     ->orderByDesc('created_at')
        //     ->where('table_id', $id)
        //     ->get();

        $cards = Card::with('comment')
            ->orderByDesc('created_at')
            ->where('table_id', $id)
            ->get();

        $user = Comment::with('user')
            ->get();



        // dd($comments);
        // dd($cards);
        return view('tasks.task', compact('board', 'cards', 'user_id', 'user'));
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
