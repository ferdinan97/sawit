<?php

namespace App\Repositories;

use App\Models\ExpenseModel;
use App\Models\StaffModel;
use App\Models\WorkHistoryModel;
use App\Models\WorkingHourDetailModel;
use Illuminate\Support\Facades\DB;

class reportRepository
{
    function getReport()
    {
        $paid = 0;
        $not_paid = 0;
        $paid_bulk = 0;
        $not_paid_bulk = 0;

        $rawData = WorkingHourDetailModel::with(['Staff' , 'WorkHistory'])->whereHas('WorkHistory', function ($query) {
            $query->WhereNot('type', 1);
        })->where('deleted_at', null)->whereNot('staff_id', 9)->selectRaw('staff_id, is_paid, type, COUNT(*) as count')
            ->groupBy('staff_id', 'is_paid', 'type')->get();

        foreach ($rawData as $val) {
            if ($val->is_paid == 1) {
                $money_value = MoneyValue($val->count, $val->type);
                $paid += $money_value;
            } else {
                $money_value = MoneyValue($val->count, $val->type);
                $not_paid += $money_value;
            }
        }

        $rawDataBulkWork = WorkHistoryModel::with('Detail')->where('type', 1)->get();

        foreach($rawDataBulkWork as $val) {
            foreach($val->Detail as $item){
                if ($item->is_paid == 1) {
                    $money_value = BulkMoneyValue($item->total_item, $val->price_per_item);
                    $paid_bulk += $money_value;
                } else {
                    $money_value = BulkMoneyValue($item->total_item, $val->price_per_item);
                    $not_paid_bulk += $money_value;
                }
            }
        }

        $paid += $paid_bulk;
        $not_paid += $not_paid_bulk;

        $groupByStaff = WorkingHourDetailModel::with('Staff')
            ->selectRaw('staff_id,SUM(CASE WHEN type = 0 THEN 1 ELSE 0.5 END) as count')
            ->groupBy('staff_id')
            ->get();

        $totalExpense = ExpenseModel::sum('total');

        $data = [
            'total_paid' => number_format($paid),
            'total_not_paid' => number_format($not_paid),
            'report' => $groupByStaff,
            'expense' => number_format($totalExpense),
        ];

        return $data;
    }
}
