<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
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

    public function index($id)
    {
        return view('tasks.addTask', compact('id'));
    }

    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $card = [
            'card_title' => $request->title,
            'content' => $request->content,
            'table_id' => $id,
            'user_id' => $user_id,
        ];

        Card::create($card);

        return redirect()->back()
            ->with('success', "Your card has been create!");
    }

    public function edit($id)
    {
        // $post = Post::find($id);
        // dd($post);
        return view('tasks.edit');
    }


    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $board = Card::find($id);
        $board->card_title = $request->edit_card_title;
        $board->content = $request->edit_content;

        $board->save();

        return redirect()->back()
            ->with('success', 'ok');
        ;

    }

    public function destroy($id)
    {
        $card = Card::find($id);
        $card->delete();

        return redirect()->back()
            ->with('success', 'votre carte a bien été supprimé');
    }
}
