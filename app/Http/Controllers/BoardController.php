<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Comment;
use App\Models\Guess;
use App\Models\Title;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id; //récupération de l'id de l'utilisateur connecté
        $name = Auth::user()->name; //récupération du nom de l'utilisateur connecté
        $email = Auth::user()->email; //récupération du mail de l'utilisateur connecté

        $boards = Title::with('card', 'user') // requete de la table title et user en relation
            ->where('user_id', $user_id)
            ->orderByDesc('created_at')
            ->get();

        $boardsGuess = Guess::with('board.user') //requete de la table guess en relation avec la table title et user
            ->where('guess', $email)
            ->get();

        return view('tasks.overview', compact('boards', 'name', 'user_id', 'boardsGuess'));
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
        $user_id = Auth::user()->id; //récupération de l'id de l'utilisateur connecté

        $validated = $request->validate([
            'title' => 'required|string',
        ], [
            'title.required' => "Oops, you're trying to create a board without a title."
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
        $user_id = Auth::user()->id; //récupération de l'id de l'utilisateur connecté

        $board = Title::find($id); //récupération des tableaux correspondant a l'id

        $boardUser = Title::with('user') //requete de la table title en relation avec user
            ->where('id', $id)
            ->get();

        $cards = Card::with('user', 'comment.user') //requete de la table card en relation avec user et comment avec user
            ->orderByDesc('created_at')
            ->where('table_id', $id)
            ->get();

        $user = Comment::with('user') //requete de la table commment en relation avec user
            ->get();

        return view('tasks.task', compact('board', 'cards', 'user_id', 'user', 'boardUser'));
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
        $user_id = Auth::user()->id;

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
