<?php

namespace App\Http\Controllers;

use App\Events\TeamResourceUpdated;
use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
	public function index()
	{
		return Team::all();
	}
	
    public function get(Team $team)
    {
    	return $team;
    }

    public function update(Team $team)
    {
    	$team->update([
    		'water' => request()->water,
    		'food' => request()->food,
    		'money' => request()->money
    	]);

        TeamResourceUpdated::dispatch($team);

    	return $team;
    }

    public function reduce()
    {
        foreach(Team::all() as $team) {
            $team->update(['water' => $team->water - 10, 'food' => $team->food - 10]);
        }
    }
}
