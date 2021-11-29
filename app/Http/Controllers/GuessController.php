<?php

namespace App\Http\Controllers;

use App\Models\Guess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuessController extends Controller
{
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'guess' => 'required|email|exists:users,email',
        ], [
            'guess.required' => "Oops, the field is empty.",
            'guess.exists' => "The guess you're trying to invite doesn't have an account.",
        ]);

        $guess = [
            'guess' => $request->guess,
            'table_id' => $request->table_id,
            'user_id' => $request->user_id,
        ];

        Guess::create($guess);

        return redirect()->back()
            ->with('success', "You've invited: " . $request->guess);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guess = Guess::find($id);
        $guess->delete();

        return redirect()->back()
            ->with('success', 'The guess has been deleted!');
    }
}
