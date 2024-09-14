<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\Guest;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    protected $model;

    public function index(Request $request)
    {
        $items = new Guest();

        if ($request->conditions)
            $items = $items->where(json_decode($request->conditions,true));

        if ($request->with)
            $items = $items->with($request->with);
        return $request->noPaginate ? $items->get() : $items->paginate();
    }

    public function store(Request $request)
    {
//        Gate::authorize('create', Guest::class);
        try {
            DB::beginTransaction();
            $item = new Guest();
            $data = $request->only($item->fillable);
            
            $guest = $item->create($data);

            DB::commit();
        }catch (\Exception $exception){
            return response($exception->getMessage(),419);
        }
        return $guest;
    }

    public function show(Guest $guest)
    {
        return $guest;
    }

    public function update(Request $request, Guest $guest)
    {
//        Gate::authorize('update', $guest);
        try {
            DB::beginTransaction();
            $data = $request->only($guest->fillable);
            
            $guest->update($data);
            
            DB::commit();
        }catch (\Exception $exception){
            return response($exception->getMessage(),419);
        }
        return $guest;
    }

    public function destroy(Guest $guest)
    {
//        Gate::authorize('delete', $guest);
        try {
            DB::beginTransaction();
            $guest->delete();
            DB::commit();
        }catch (\Exception $exception){
            return response($exception->getMessage(),419);
        }
        return response("با موفقیت حذف شد");
    }
}
