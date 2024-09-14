<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\Room;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    protected $model;

    public function index(Request $request)
    {
        $items = new Room();

        if ($request->conditions)
            $items = $items->where(json_decode($request->conditions,true));

        if ($request->with)
            $items = $items->with($request->with);
        return $request->noPaginate ? $items->get() : $items->paginate();
    }

    public function store(Request $request)
    {
//        Gate::authorize('create', Room::class);
        try {
            DB::beginTransaction();
            $item = new Room();
            $data = $request->only($item->fillable);
            
            $room = $item->create($data);
            DB::commit();
        }catch (\Exception $exception){
            return response($exception->getMessage(),419);
        }
        return $room;
    }

    public function show(Room $room)
    {
        return $room;
    }

    public function update(Request $request, Room $room)
    {
//        Gate::authorize('update', $room);
        try {
            DB::beginTransaction();
            $data = $request->only($room->fillable);
            
            $room->update($data);
            DB::commit();
        }catch (\Exception $exception){
            return response($exception->getMessage(),419);
        }
        return $room;
    }

    public function destroy(Room $room)
    {
//        Gate::authorize('delete', $room);
        try {
            DB::beginTransaction();
            $room->delete();
            DB::commit();
        }catch (\Exception $exception){
            return response($exception->getMessage(),419);
        }
        return response("با موفقیت حذف شد");
    }
}
