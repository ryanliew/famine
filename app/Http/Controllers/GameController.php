<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function page()
    {
    	$game = Game::find(1);

    	return view("final", ["game" => $game]);
    }

    public function persist()
    {
    	$game = Game::find(1);

    	$game->update(['hungry_count' => $game->hungry_count + 2]);

    	return response(200);
    }

    public function persistTry()
    {
    	$game = Game::find(1);

    	$game->update(['flag_timer' => $game->flag_timer - 1]);

    	return response(200);
    }

    public function edit()
    {
        $game = Game::find(1);

        $game->update(['hungry_count' => request()->hunger]);

        return response(200);
    }
}
