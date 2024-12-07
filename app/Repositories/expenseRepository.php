<?php

namespace App\Repositories;

use App\Models\ExpenseDetailModel;
use App\Models\ExpenseModel;
use App\Models\StaffModel;
use App\Models\WorkingHourDetailModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class expenseRepository
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
        $data = ExpenseModel::with('Detail')->withCount('Detail')->orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function getExpenseById($id)
    {
        $data = ExpenseModel::where('id', $id)->with('Detail')->first();

        return $data;
    }

    function insert($request)
    {
        DB::beginTransaction();
        try {
            $total_price = 0;
            foreach ($request->total_item as $val) {
                $total_price += $val;
            }
            $data = [
                'name' => $request->name,
                'total' => $total_price,
                'description' => $request->description,
                'date' => $request->date,
                'created_at' => Carbon::now(),
            ];
            $expense = ExpenseModel::create($data);
            $detail = [];
            foreach ($request->item_name as $key => $val) {
                $data = [
                    'name' => $val,
                    'total' => $request['total_item'][$key],
                    'expense_id' => $expense->id,
                    'created_at' => Carbon::now(),
                ];

                $detail[] = $data;
            }

            $expense_detail = ExpenseDetailModel::insert($detail);

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
            $total_price = 0;
            foreach ($request->total_item as $val) {
                $total_price += $val;
            }
            $data = [
                'name' => $request->name,
                'total' => $total_price,
                'description' => $request->description,
                'date' => $request->date,
            ];
            $expense = ExpenseModel::where('id', $request->id)->update($data);
            $new_data = [];
            //'id' => isset($request['item_id'][$key]) ? $request['item_id'][$key] : 0,
            foreach ($request->item_id as $key => $val) {
                if ($val != 0) {
                    $data = [
                        'name' => $request['item_name'][$key],
                        'expense_id' => $request->id,
                        'total' => $request['total_item'][$key],
                        'created_at' => Carbon::now(),
                    ];
                    $update = ExpenseDetailModel::where('id', $val)->update($data);
                } else {
                    $data = [
                        'name' => $request['item_name'][$key],
                        'total' => $request['total_item'][$key],
                        'expense_id' => $request->id,
                        'created_at' => Carbon::now(),
                    ];
                    $new_data[] = $data;
                }
            }            

            $new_detail = ExpenseDetailModel::insert($new_data);

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
            $data = ExpenseModel::where('id', $id)->firstOrFail();
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
