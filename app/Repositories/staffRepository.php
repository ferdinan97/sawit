<?php

namespace App\Repositories;

use App\Models\StaffModel;
use App\Models\WorkingHourDetailModel;
use Illuminate\Support\Facades\DB;

class staffRepository
{
    function getRequestFilter($data, $request)
    {
        if (isset($request['name']) && $request['name'] != null) {
            $data = $data->where('name','like', "%{$request['name']}%");
        }

        return $data;
    }

    function getStaff($request)
    {
        $data = StaffModel::orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function getStaffById($id)
    {
        $paid = 0;
        $not_paid = 0;

        $staff = StaffModel::where('id', $id)->firstOrFail();
        $workDetail = WorkingHourDetailModel::where('staff_id', $id)->selectRaw('is_paid,SUM(CASE WHEN type = 0 THEN 1 ELSE 0.5 END) as count')->groupBy('is_paid')->get();

        foreach ($workDetail as $val) {
            if ($val->is_paid == 1) {
                $money_value = MoneyValue($val->count, $val->type);
                $paid += $money_value;
            } else {
                $money_value = MoneyValue($val->count, $val->type);
                $not_paid += $money_value;
            }
        }

        $data = [
            'staff' => $staff,
            'total_paid' => $paid,
            'total_not_paid' => $not_paid,
        ];

        return $data;
    }

    function getAllStaff()
    {
        $data = StaffModel::get();
        return $data;
    }

    function addStaff($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request['name']
            ];

            $insert = StaffModel::create($data);

            DB::commit();
            $message = [
                'status' => true,
                'data' => $insert,
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

    function editStaff($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request['name']
            ];

            StaffModel::where('id', $request['id'])->update($data);

            DB::commit();
            $message = [
                'status' => true,
                'data' => null,
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

    function deleteStaff($id)
    {
        DB::beginTransaction();
        try {
            $data = StaffModel::where('id', $id)->firstOrFail();;
            $data->delete();

            DB::commit();
            $message = [
                'status' => true,
                'data' => null,
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
