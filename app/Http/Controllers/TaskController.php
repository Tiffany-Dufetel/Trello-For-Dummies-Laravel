<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index($id)
    {
        return view('tasks.addTask', compact('id'));
    }

    public function store(Request $request, $id)
    {
        $user_id = Auth::user()->id;

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

        return redirect()->route('overviews.show', $id)
            ->with('success', "Your card has been create!");
    }

    public function edit($id)
    {
        return view('tasks.edit');
    }


    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $board = Card::findOrFail($id);
        $board->card_title = $request->edit_card_title;
        $board->content = $request->edit_content;

        $board->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $card = Card::find($id);
        $card->delete();

        return redirect()->back()
            ->with('success', 'Your card has been deleted');
    }
}
