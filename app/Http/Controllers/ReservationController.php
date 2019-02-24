<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Activity;
use App\Models\Layout;
use App\Models\Department;
use App\Models\Reservation;

use App\Exports\LedgerExport;
use App\Exports\LedgerDebttypeExport;
use App\Exports\ArrearExport;
use App\Exports\CreditorPaidExport;

class ReservationController extends Controller
{
    public function calendar()
    {
        return view('reservations.calendar', [
            "rooms"         => Room::all(),
            "reservations"  => Reservation::orderBy('reserve_sdate', 'DESC')->paginate(10)
        ]);
    }

    public function list()
    {
        return view('reservations.list', [
            "rooms"     => Room::all(),
            "reservations"  => Reservation::orderBy('reserve_sdate', 'DESC')
                                ->with('activity')
                                ->with('room')
                                ->with('layout')
                                ->with('user')
                                ->paginate(10),
            "searchdate"    => '2019-02-19',
        ]);
    }

    public function add()
    {
        return view('reservations.add', [
            "rooms"         => Room::all(),
            "departments"   => Department::all(),
            "activities"    => Activity::all(),
            "layouts"       => Layout::all(),
        ]);
    }

    public function store(Request $req)
    {
        $equipments = implode(",", $req['reserve_equipment']);

        $newReservation = new Reservation();
        $newReservation->reserve_topic          = $req['reserve_topic'];
        $newReservation->reserve_activity_type  = $req['reserve_activity_type'];
        $newReservation->reserve_att_num        = $req['reserve_att_num'];
        $newReservation->reserve_layout         = $req['reserve_layout'];
        $newReservation->reserve_sdate          = convThDateToDb($req['reserve_sdate']);
        $newReservation->reserve_stime          = $req['reserve_stime'];
        $newReservation->reserve_edate          = convThDateToDb($req['reserve_edate']);
        $newReservation->reserve_etime          = $req['reserve_etime'];
        $newReservation->reserve_room           = $req['reserve_room'];
        $newReservation->reserve_equipment      = $equipments;
        $newReservation->reserve_depart         = $req['reserve_depart'];
        $newReservation->reserve_user           = $req['reserve_user'];
        $newReservation->reserve_tel            = $req['reserve_tel'];
        $newReservation->reserve_budget         = $req['reserve_budget'];
        $newReservation->reserve_status         = $req['reserve_status'];
        $newReservation->reserve_comment        = $req['reserve_comment'];
        $newReservation->reserve_remark         = $req['reserve_remark'];
        $newReservation->reserve_pay_rate       = $req['reserve_pay_rate'];
        $newReservation->reserve_pay_price      = $req['reserve_pay_price'];

        $newReservation->created_by             = $req['reserve_user'];
        // $newReservation->updated_by          = $req['reserve_user'];

        /** Use angularJS */
        if($newReservation->save()){
            return [
                "status" => "success",
                "message" => "Insert success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Insert failed.",
            ];
        }

        /** Use flash message in Laravel */
        // if($newReservation->save()){
        //     \Session::flash('message', 'This is a message!'); 
        //     \Session::flash('alert-class', 'alert-success'); 
        // } else {
        //     \Session::flash('message', 'This is a message!'); 
        //     \Session::flash('alert-class', 'alert-danger');
        // }

        // return redirect('reserve/list');
    }

    public function edit()
    {
        return view('reservations.newform', [
            "rooms"         => Room::all(),
            "departments"   => Department::all(),
            "activities"    => Activity::all(),
            "layouts"       => Layout::all(),
        ]);
    }

    public function update(Request $req)
    {
        $equipments = implode(",", $req['reserve_equipment']);

        $editReservation = Reservation::find($req['reserve_id']);
        $editReservation->reserve_topic          = $req['reserve_topic'];
        $editReservation->reserve_activity_type  = $req['reserve_activity_type'];
        $editReservation->reserve_att_num        = $req['reserve_att_num'];
        $editReservation->reserve_layout         = $req['reserve_layout'];
        $editReservation->reserve_sdate          = convThDateToDb($req['reserve_sdate']);
        $editReservation->reserve_stime          = $req['reserve_stime'];
        $editReservation->reserve_edate          = convThDateToDb($req['reserve_edate']);
        $editReservation->reserve_etime          = $req['reserve_etime'];
        $editReservation->reserve_room           = $req['reserve_room'];
        $editReservation->reserve_equipment      = $equipments;
        $editReservation->reserve_depart         = $req['reserve_depart'];
        $editReservation->reserve_user           = $req['reserve_user'];
        $editReservation->reserve_tel            = $req['reserve_tel'];
        $editReservation->reserve_budget         = $req['reserve_budget'];
        $editReservation->reserve_status         = $req['reserve_status'];
        $editReservation->reserve_comment        = $req['reserve_comment'];
        $editReservation->reserve_remark         = $req['reserve_remark'];
        $editReservation->reserve_pay_rate       = $req['reserve_pay_rate'];
        $editReservation->reserve_pay_price      = $req['reserve_pay_price'];

        $editReservation->created_by             = $req['reserve_user'];
        // $editReservation->updated_by          = $req['reserve_user'];

        if($editReservation->save()){
            
        }

        return redirect('reserve/list');
    }

    public function ajaxlayout($id)
    {
        return Layout::find($id);
    }

    public function ajaxcalendar($sdate, $edate)
    {
        /** 
         * Reserve status 
         * 0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก
         */
        $events = [];
        $reservations = Reservation::whereBetween('reserve_sdate', [$sdate, $edate])
                                // ->whereIn('status', ['0','1','2','3'])
                                ->with('activity')
                                ->with('room')
                                ->with('layout')
                                ->with('user')
                                ->get();

        foreach ($reservations as $reserve) {             
            $event = [
                'id'    => $reserve->reserve_id,
                'title' => $reserve->activity->activity_type_name. 
                            '/' .$reserve->reserve_topic. 
                            '/' .$reserve->room->room_name. 
                            '/จำนวน ' .$reserve->reserve_att_num. ' ราย',
                'start' => $reserve->reserve_sdate. 'T' .$reserve->reserve_stime,
                'end'   => $reserve->reserve_edate. 'T' .$reserve->reserve_etime,
            ];

            array_push($events, $event);
        }

        return $events;
    }

    // public function arrearRpt($debttype, $creditor, $sdate, $edate, $showall)
    // {
    //     $debts = [];

    //     if($showall == 1) {
    //         $debts = \DB::table('nrhosp_acc_debt')
    //                     ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_app.app_recdoc_date',
    //                              'nrhosp_acc_app.app_id')
    //                     ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
    //                     ->join('nrhosp_acc_app_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_app_detail.debt_id')
    //                     ->join('nrhosp_acc_app', 'nrhosp_acc_app_detail.app_id', '=', 'nrhosp_acc_app.app_id')
    //                     ->whereNotIn('nrhosp_acc_debt.debt_status', [2,3,4])
    //                     ->paginate(20);

    //         $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
    //                             ->sum('debt_total');
    //     } else {
    //         if($debttype != 0 && $creditor != 0) {
    //             /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */
    //             $debts = \DB::table('nrhosp_acc_debt')
    //                         ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_app.app_recdoc_date',
    //                                  'nrhosp_acc_app.app_id')
    //                         ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
    //                         ->join('nrhosp_acc_app_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_app_detail.debt_id')
    //                         ->join('nrhosp_acc_app', 'nrhosp_acc_app_detail.app_id', '=', 'nrhosp_acc_app.app_id')
    //                         ->whereNotIn('nrhosp_acc_debt.debt_status', [2,3,4])
    //                         ->where('nrhosp_acc_debt.debt_type_id', '=', $debttype)
    //                         ->where('nrhosp_acc_debt.supplier_id', '=', $creditor)
    //                         ->whereBetween('nrhosp_acc_debt.debt_date', [$sdate, $edate])
    //                         ->paginate(20);

    //             $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
    //                             ->where('debt_type_id', '=', $debttype)
    //                             ->where('supplier_id', '=', $creditor)
    //                             ->whereBetween('debt_date', [$sdate, $edate])
    //                             ->sum('debt_total');
    //         } else {
    //             if($debttype != 0 && $creditor == 0) {
    //                 $debts = \DB::table('nrhosp_acc_debt')
    //                             ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_app.app_recdoc_date',
    //                                      'nrhosp_acc_app.app_id')
    //                             ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
    //                             ->join('nrhosp_acc_app_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_app_detail.debt_id')
    //                             ->join('nrhosp_acc_app', 'nrhosp_acc_app_detail.app_id', '=', 'nrhosp_acc_app.app_id')
    //                             ->whereNotIn('nrhosp_acc_debt.debt_status', [2,3,4])
    //                             ->where('nrhosp_acc_debt.debt_type_id', '=', $debttype)
    //                             ->whereBetween('nrhosp_acc_debt.debt_date', [$sdate, $edate])
    //                             ->paginate(20);

    //                 $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
    //                                 ->where('debt_type_id', '=', $debttype)
    //                                 ->whereBetween('debt_date', [$sdate, $edate])
    //                                 ->sum('debt_total');
    //             } else if($debttype == 0 && $creditor != 0) {
    //                  $debts = \DB::table('nrhosp_acc_debt')
    //                                 ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_app.app_recdoc_date',
    //                                          'nrhosp_acc_app.app_id')
    //                                 ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
    //                                 ->join('nrhosp_acc_app_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_app_detail.debt_id')
    //                                 ->join('nrhosp_acc_app', 'nrhosp_acc_app_detail.app_id', '=', 'nrhosp_acc_app.app_id')
    //                                 ->whereNotIn('nrhosp_acc_debt.debt_status', [2,3,4])
    //                                 ->where('nrhosp_acc_debt.supplier_id', '=', $creditor)
    //                                 ->whereBetween('nrhosp_acc_debt.debt_date', [$sdate, $edate])
    //                                 ->paginate(20);

    //                 $totalDebt = Debt::whereNotIn('debt_status', [2,3,4])
    //                                 ->where('supplier_id', '=', $creditor)
    //                                 ->whereBetween('debt_date', [$sdate, $edate])
    //                                 ->sum('debt_total');
    //             }   
    //         }   
    //     }
        
    //     return [
    //         "debts"     => $debts,
    //         "totalDebt" => $totalDebt,
    //     ];
    // }

    // public function arrearExcel($debttype, $creditor, $sdate, $edate, $showall)
    // {
    //     $fileName = 'arrear-' . date('YmdHis') . '.xlsx';
    //     return (new ArrearExport($debttype, $creditor, $sdate, $edate, $showall))->download($fileName);
    // }

    // public function creditorPaid()
    // {
    //     return view('accounts.creditor-paid', [
    //         "creditors" => Creditor::all(),
    //     ]);
    // }

    // public function creditorPaidRpt($creditor, $sdate, $edate, $showall)
    // {
    //     $debts = [];

    //     if($showall == 1) {
    //         $payments = \DB::table('nrhosp_acc_payment')
    //                             ->select('nrhosp_acc_payment.*', 'nrhosp_acc_debt.debt_id', 'nrhosp_acc_debt.debt_type_detail', 
    //                                 'nrhosp_acc_debt.deliver_no', 'nrhosp_acc_debt.debt_total', 'nrhosp_acc_debt.debt_status',
    //                                 'nrhosp_acc_com_bank.bank_acc_no', 'nrhosp_acc_com_bank.bank_acc_name', 'nrhosp_acc_bank.bank_name',
    //                                 'nrhosp_acc_debt_type.debt_type_name')
    //                             ->join('nrhosp_acc_payment_detail', 'nrhosp_acc_payment.payment_id', '=', 'nrhosp_acc_payment_detail.payment_id')
    //                             ->join('nrhosp_acc_debt', 'nrhosp_acc_payment_detail.debt_id', '=', 'nrhosp_acc_debt.debt_id')
    //                             ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
    //                             ->join('nrhosp_acc_com_bank', 'nrhosp_acc_payment.bank_acc_id', '=', 'nrhosp_acc_com_bank.bank_acc_id')
    //                             ->join('nrhosp_acc_bank', 'nrhosp_acc_com_bank.bank_id', '=', 'nrhosp_acc_bank.bank_id')
    //                             ->where('nrhosp_acc_payment.paid_stat', '=', 'Y')
    //                             ->paginate(20);

    //         $totalDebt = Payment::where('paid_stat', '=', 'Y')
    //                             ->sum('total');
    //     } else {
    //         if($creditor != 0) {
    //             /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */
                
    //             $payments = \DB::table('nrhosp_acc_payment')
    //                             ->select('nrhosp_acc_payment.*', 'nrhosp_acc_debt.debt_id', 'nrhosp_acc_debt.debt_type_detail', 
    //                                 'nrhosp_acc_debt.deliver_no', 'nrhosp_acc_debt.debt_total', 'nrhosp_acc_debt.debt_status',
    //                                 'nrhosp_acc_com_bank.bank_acc_no', 'nrhosp_acc_com_bank.bank_acc_name', 'nrhosp_acc_bank.bank_name',
    //                                 'nrhosp_acc_debt_type.debt_type_name')
    //                             ->join('nrhosp_acc_payment_detail', 'nrhosp_acc_payment.payment_id', '=', 'nrhosp_acc_payment_detail.payment_id')
    //                             ->join('nrhosp_acc_debt', 'nrhosp_acc_payment_detail.debt_id', '=', 'nrhosp_acc_debt.debt_id')
    //                             ->join('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
    //                             ->join('nrhosp_acc_com_bank', 'nrhosp_acc_payment.bank_acc_id', '=', 'nrhosp_acc_com_bank.bank_acc_id')
    //                             ->join('nrhosp_acc_bank', 'nrhosp_acc_com_bank.bank_id', '=', 'nrhosp_acc_bank.bank_id')
    //                             ->where('nrhosp_acc_payment.supplier_id', '=', $creditor)
    //                             ->whereBetween('nrhosp_acc_payment.paid_date', [$sdate, $edate])
    //                             ->paginate(20);

    //             $totalDebt = Payment::where('paid_stat', '=', 'Y')
    //                             ->where('supplier_id', '=', $creditor)
    //                             ->whereBetween('paid_date', [$sdate, $edate])
    //                             ->sum('total');
    //         }
    //     }
        
    //     return [
    //         "payments"     => $payments,
    //         "totalDebt" => $totalDebt,
    //     ];
    // }

    // public function creditorPaidExcel($creditor, $sdate, $edate, $showall)
    // {
    //     $fileName = 'creditor-paid-' . date('YmdHis') . '.xlsx';
    //     return (new CreditorPaidExport($creditor, $sdate, $edate, $showall))->download($fileName);
    // }

    // public function ledger($sdate, $edate, $showall)
    // {
    //     $debts = [];

    //     $debts = \DB::table('nrhosp_acc_debt')
    //                     ->select('nrhosp_acc_debt.*', 'nrhosp_acc_debt_type.debt_type_name', 'nrhosp_acc_payment_detail.cheque_amt',
    //                              'nrhosp_acc_payment_detail.rcpamt', 'nrhosp_acc_payment.cheque_no', 'nrhosp_acc_payment.payment_id')
    //                     ->leftJoin('nrhosp_acc_debt_type', 'nrhosp_acc_debt.debt_type_id', '=', 'nrhosp_acc_debt_type.debt_type_id')
    //                     ->leftJoin('nrhosp_acc_payment_detail', 'nrhosp_acc_debt.debt_id', '=', 'nrhosp_acc_payment_detail.debt_id')
    //                     ->leftJoin('nrhosp_acc_payment', 'nrhosp_acc_payment_detail.payment_id', '=', 'nrhosp_acc_payment.payment_id')
    //                     ->whereNotIn('nrhosp_acc_debt.debt_status', [3,4])
    //                     ->whereBetween('nrhosp_acc_debt.debt_date', [$sdate, $edate])
    //                     ->get();

    //     $subQuery = \DB::table('nrhosp_acc_debt')
    //                     ->select('nrhosp_acc_debt.supplier_id', 'nrhosp_acc_debt.supplier_name')
    //                     ->whereBetween('nrhosp_acc_debt.debt_date', [$sdate, $edate])
    //                     ->groupBy('nrhosp_acc_debt.supplier_id', 'nrhosp_acc_debt.supplier_name');

    //     $creditors = \DB::table(\DB::raw("(" .$subQuery->toSql() . ") as creditors"))
    //                     ->mergeBindings($subQuery)
    //                     ->get();

    //     return view('accounts.ledger', [
    //         "creditors" => $creditors,
    //         "debts"     => $debts,
    //         "sdate"     => $sdate,
    //         "edate"     => $edate,
    //         "showall"  => $showall,
    //     ]);
    // }

    // public function ledgerExcel($sdate, $edate, $showall)
    // {
    //     $fileName = 'ledger-' . date('YmdHis') . '.xlsx';
    //     return (new LedgerExport($sdate, $edate, $showall))->download($fileName);
    // }

    // public function ledgerDebttype($sdate, $edate, $showall)
    // {
    //     $debts = [];

    //     $sql = "SELECT d.debt_type_id, dt.debt_type_name,
    //             SUM(debt_total) as debit,
    //             SUM(pd.rcpamt) as credit
    //             FROM nrhosp_acc_debt d 
    //             LEFT JOIN nrhosp_acc_debt_type dt ON (d.debt_type_id=dt.debt_type_id)
    //             LEFT JOIN nrhosp_acc_payment_detail pd ON (d.debt_id=pd.debt_id) 
    //             WHERE (d.debt_status NOT IN ('3','4')) ";

    //     if($showall == '0') {
    //         $sql .= "AND (d.debt_date BETWEEN '$sdate' AND '$edate') ";
    //     }

    //     $sql .= "GROUP BY d.debt_type_id, dt.debt_type_name
    //              ORDER BY debt_type_id";

    //     $debts = \DB::select($sql);

    //     return view('accounts.ledger-debttype', [
    //         "debts"     => $debts,
    //         "sdate"     => $sdate,
    //         "edate"     => $edate,
    //         "showall"  => $showall,
    //     ]);
    // }

    // public function ledgerDebttypeExcel($sdate, $edate, $showall)
    // {
    //     $fileName = 'ledger-debttype' . date('YmdHis') . '.xlsx';
    //     return (new LedgerDebttypeExport($sdate, $edate, $showall))->download($fileName);
    // }
}
