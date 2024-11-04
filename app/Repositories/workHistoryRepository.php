<?php

namespace App\Repositories;

use App\Models\WorkHistoryModel;
use App\Models\WorkingHourDetailModel;
use Illuminate\Support\Facades\DB;

class workHistoryRepository
{
    function getRequestFilter($data, $request)
    {
        if (isset($request['name'])) {
            $data = $data->where('name', $request['name']);
        }

        if (isset($request['date'])) {
            $data = $data->where('date', $request['date']);
        }

        return $data;
    }

    function getWorkingHistory($request)
    {
        $data = WorkHistoryModel::with('Detail')->orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->first();
        return $result;
    }

    function getWorkingHistoryById($id)
    {
        $data = WorkHistoryModel::where('id', $id)->with('Detail')->first();
        return $data;
    }

    function getWorkingHistoryList($request)
    {
        $data = WorkHistoryModel::with('Detail')->withCount('Detail')->orderByDesc('id');
        $data = $this->getRequestFilter($data, $request);
        $result = $data->paginate(10);
        return $result;
    }

    function addWorkingHour($request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request['name'],
                'date' => $request['date'],
                'type' => $request['work_type'],
                'price_per_item' => $request['price_per_item']
            ];

            $work = WorkHistoryModel::create($data);
            $workers = [];

            if ($request['work_type'] == 0) {
                foreach ($request['staffs'] as $key => $staff) {
                    $worker = [
                        'staff_id' => $staff,
                        'type' => $request['type'][$key],
                        'working_hour_id' => $work->id,
                        'is_paid' => 0,
                    ];

                    $workers[] = $worker;
                }
            } else {
                foreach ($request['staffs'] as $key => $staff) {
                    $worker = [
                        'staff_id' => $staff,
                        'type' => $request['type'][$key],
                        'total_item' => $request['total_item'][$key],
                        'working_hour_id' => $work->id,
                        'is_paid' => 0,
                    ];

                    $workers[] = $worker;
                }
            }


            $detail = WorkingHourDetailModel::insert($workers);

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

    function updateWorkingHour($request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request['name'],
                'date' => $request['date'],
            ];
            $work = WorkHistoryModel::where('id', $request['id'])->update($data);
            $workers = [];

            $oldData = WorkingHourDetailModel::where('working_hour_id', $request['id'])->get();
            if (!$oldData->isEmpty()) {
                $delete = WorkingHourDetailModel::where('working_hour_id', $request['id'])->delete();
            }

            foreach ($request['staffs'] as $key => $staff) {
                if ($request['work_type'] == 0) {
                    $worker = [
                        'staff_id' => $staff,
                        'type' => $request['type'][$key],
                        'working_hour_id' => $request['id'],
                        'is_paid' => $request['is_paid'][$key],
                    ];

                    $workers[] = $worker;
                } else {
                    $worker = [
                        'staff_id' => $staff,
                        'type' => $request['type'][$key],
                        'total_item' => $request['total_item'][$key],
                        'working_hour_id' => $request['id'],
                        'is_paid' => $request['is_paid'][$key],
                    ];

                    $workers[] = $worker;
                }
            }            

            $detail = WorkingHourDetailModel::insert($workers);

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


    function deleteWorkingHour($id)
    {
        DB::beginTransaction();
        try {
            $data = WorkHistoryModel::where('id', $id)->firstOrFail();;
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
