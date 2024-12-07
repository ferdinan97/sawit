<?php

namespace App\Repositories;

use App\Models\IncomeModel;
use Exception;
use Illuminate\Support\Facades\DB;

class incomeRepository
{
    function getRequestFilter($data, $request)
    {
        if (isset($request['name']) && $request['name'] !== null) {
            $data = $data->where('name','like', "%{$request['name']}%");
        }

        if (isset($request['date']) && $request['date'] !== null) {
            $data = $data->where('date', $request['date']);
        }

        return $data;
    }

    function data($request)
    {
        $data = IncomeModel::orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function getIncomeById($id)
    {
        $data = IncomeModel::where('id', $id)->first();

        return $data;
    }

    function insert($request)
    {        
        DB::beginTransaction();
        try {
            $data = [
                'date' => $request->date,
                'description' => $request->description,
                'price_per_kg' => $request->price_per_kg,
                'total_weight' => $request->total_weight,
                'total' => $request->total,
            ];

            $insert = IncomeModel::create($data);

            DB::commit();
            $message = [
                'status' => true,
                'data' => true,
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            $message = [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }


        return $message;
    }

    function update($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'date' => $request->date,
                'description' => $request->description,
                'price_per_kg' => $request->price_per_kg,
                'total_weight' => $request->total_weight,
                'total' => $request->total,
            ];

            $expense = IncomeModel::where('id', $request->id)->update($data);

            DB::commit();
            $message = [
                'status' => true,
                'data' => true,
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            $message = [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }


        return $message;
    }

    function delete($id)
    {
        DB::beginTransaction();
        try {
            $data = IncomeModel::where('id', $id)->firstOrFail();
            $data->delete();
            DB::commit();

            $message = [
                'status' => true,
                'data' => true,
            ];
        } catch (\Exception $exception) {
            DB::rollback();
            $message = [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }


        return $message;
    }
}
