<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use App\Models\Reservation;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    protected $model;

    public function index(Request $request)
    {
        $items = new Reservation();

        if ($request->conditions)
            $items = $items->where(json_decode($request->conditions,true));

        if ($request->with)
            $items = $items->with($request->with);
        return $request->noPaginate ? $items->get() : $items->paginate();
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Reservation::class);
        try {
            DB::beginTransaction();
            $item = new Reservation();
            $data = $request->only($item->fillable);
            
            $reservation = $item->create($data);
            DB::commit();
        }catch (\Exception $exception){
            return response($exception->getMessage(),419);
        }
        return $reservation;
    }

    public function show(Reservation $reservation)
    {
        return $reservation;
    }

    public function update(Request $request, Reservation $reservation)
    {
        Gate::authorize('update', $reservation);
        try {
            DB::beginTransaction();
            $data = $request->only($reservation->fillable);

            $reservation->update($data);
            DB::commit();
        }catch (\Exception $exception){
            return response($exception->getMessage(),419);
        }
        return $reservation;
    }

    public function destroy(Reservation $reservation)
    {
        Gate::authorize('delete', $reservation);
        try {
            DB::beginTransaction();
            $reservation->delete();
            DB::commit();
        }catch (\Exception $exception){
            return response($exception->getMessage(),419);
        }
        return response("با موفقیت حذف شد");
    }
}
