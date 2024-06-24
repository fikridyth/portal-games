<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Http\Resources\GameResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::latest()->paginate(5);
        return new GameResource(true, 'List Data Games', $games);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'id_category' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');
        $image->storeAs('public/games', $image->hashName());

        $game = Game::create([
            'title' => $request->title,
            'id_category' => $request->id_category,
            'image' => $image->hashName(),
        ]);

        return new GameResource(true, 'Data Game Berhasil Ditambahkan!', $game);
    }

    public function show($id)
    {
        $game = Game::with('category')->find($id);
        $game['name_category'] = $game->category->name;
        return new GameResource(true, 'Detail Data Game!', $game);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'id_category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $game = Game::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/games', $image->hashName());
            Storage::delete('public/games/' . basename($game->image));

            $game->update([
                'title' => $request->title,
                'id_category' => $request->id_category,
                'image' => $image->hashName(),
            ]);
        } else {
            $game->update([
                'title' => $request->title,
                'id_category' => $request->id_category,
            ]);
        }

        return new GameResource(true, 'Data Game Berhasil Diubah!', $game);
    }

    public function destroy($id)
    {
        $game = Game::find($id);
        Storage::delete('public/games/'.basename($game->image));

        $game->delete();

        return new GameResource(true, 'Data Game Berhasil Dihapus!', null);
    }
}
