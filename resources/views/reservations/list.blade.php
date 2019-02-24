@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายการใช้ห้องประชุม
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">รายการใช้ห้องประชุม</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="reservationCtrl">

        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">ค้นหาข้อมูล</h3>
                    </div>

                    <form id="frmSearch" name="frmSearch" role="form">
                        <div class="box-body">
                            <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label>ห้อง</label>
                                    <select id="creditor1" class="form-control select2" style="width: 100%; font-size: 12px;">

                                        <option value="" selected="selected">-- กรุณาเลือก --</option>
                                         @foreach($rooms as $room)

                                            <option value="{{ $room->room_id }}">
                                                {{ $room->room_name }}
                                            </option>

                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Date and time range -->
                                <div class="form-group">
                                    <label>ระหว่างวันที่-วันที่:</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="searchdate" name="searchdate">
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->                            
                            </div>
                                         
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer">
                            <button ng-click="getLedgerData('/account/ledger-rpt')" class="btn btn-primary">
                                ค้นหา
                            </button>
                            <a href="{{ url('reserve/list') }}" class="btn btn-warning">
                                ยกเลิก
                            </a>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><i class="fa fa-list"></i> รายการใช้ห้องประชุม</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <table class="table table-bordered table-striped" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th style="width: 3%; text-align: center;">#</th>
                                    <th style="width: 10%; text-align: center;">ผู้จอง</th>
                                    <th style="width: 10%; text-align: center;">ห้อง</th>
                                    <th style="width: 12%; text-align: center;">วัน เวลา ที่ใช้ห้อง</th>
                                    <th style="text-align: left;">รายละเอียด</th>
                                    <th style="width: 6%; text-align: center;">รูปแบบ</th>
                                    <th style="width: 4%; text-align: center;">สถานะ</th>
                                    <th style="width: 6%; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $index = 0; ?>
                                @foreach($reservations as $reservation)
                                <?php $status = ''; ?>

                                    <tr>
                                        <td style="text-align: center;">{{ ++$index }}</td>
                                        <td style="text-align: left;">
                                            {{ $reservation->user->person_firstname. '  ' .$reservation->user->person_lastname }}
                                        </td>
                                        <td style="text-align: left;">{{ $reservation->room->room_name }}</td>
                                        <td style="text-align: center;">
                                            {{ $reservation->reserve_sdate. ' ' .$reservation->reserve_stime }} <br>
                                            {{ $reservation->reserve_edate. ' ' .$reservation->reserve_etime }}
                                        </td>
                                        <td style="text-align: left;">
                                            <b>{{ $reservation->activity->activity_type_name }}</b><br>
                                            {{ $reservation->reserve_topic }}<br>
                                            จำนวนผู้ร่วมประชุม {{ $reservation->reserve_att_num }} ราย
                                        </td>
                                        <td style="text-align: center;">{{ $reservation->layout->reserve_layout_name }}</td>
                                        <td style="text-align: center;">
                                            <!--/** Reservation status is 0=none, 1=read, 2=approved, 3=cancel */-->
                                            @if($reservation->reserve_status == '1')
                                                <?php $status = 'primary'; ?>
                                            @elseif($reservation->reserve_status == '2')
                                                <?php $status = 'success'; ?>
                                            @endif

                                            <i class="fa fa-circle fa-2x text-{{ $status }}"></i>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="{{ url('/reserve/edit/'.$reservation->reserve_id) }}" class="">
                                                <i class="fa fa-edit fa-2x text-warning"></i>
                                            </a>
                                            <a href="{{ url('/reserve/edit/'.$reservation->reserve_id) }}">
                                                <i class="fa fa-trash fa-2x text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>           
                        
                    </div><!-- /.box-body -->

                    <!-- Loading (remove the following to stop the loading)-->
                    <div ng-show="loading" class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <!-- end loading -->

                    <div class="box-footer clearfix">
                        <!-- <a  ng-show="debts.length"
                            ng-click="arrearToExcel('/account/arrear-excel')"
                            class="btn btn-success">
                            Excel
                        </a> -->

                        <ul class="pagination">
                            @if($reservations->currentPage() !== 1)
                                <li>
                                    <a href="{{ $reservations->url($reservations->url(1)).'&searchdate='.$searchdate }}" aria-label="First">
                                        <span aria-hidden="true">First</span>
                                    </a>
                                </li>
                            @endif

                            <li class="{{ ($reservations->currentPage() === 1) ? 'disabled' : '' }}">
                                <a href="{{ $reservations->url($reservations->currentPage() - 1).'&searchdate='.$searchdate }}" aria-label="Prev">
                                    <span aria-hidden="true">Prev</span>
                                </a>
                            </li>
                            
                            @for($i=$reservations->currentPage(); $i < $reservations->currentPage() + 10; $i++)
                                @if ($reservations->currentPage() <= $reservations->lastPage() && ($reservations->lastPage() - $reservations->currentPage()) > 10)
                                    <li class="{{ ($reservations->currentPage() === $i) ? 'active' : '' }}">
                                        <a href="{{ $reservations->url($i).'&searchdate='.$searchdate }}">
                                            {{ $i }}
                                        </a>
                                    </li> 
                                @else
                                    @if ($i <= $reservations->lastPage())
                                        <li class="{{ ($reservations->currentPage() === $i) ? 'active' : '' }}">
                                            <a href="{{ $reservations->url($i).'&searchdate='.$searchdate }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endfor
                            
                            @if ($reservations->currentPage() < $reservations->lastPage() && ($reservations->lastPage() - $reservations->currentPage()) > 10)
                                <li>
                                    <a href="{{ $reservations->url($reservations->currentPage() + 10).'&searchdate='.$searchdate }}">
                                        ...
                                    </a>
                                </li>
                            @endif
                            
                            <li class="{{ ($reservations->currentPage() === $reservations->lastPage()) ? 'disabled' : '' }}">
                                <a href="{{ $reservations->url($reservations->currentPage() + 1).'&searchdate='.$searchdate }}" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>

                            @if($reservations->currentPage() !== $reservations->lastPage())
                                <li>
                                    <a href="{{ $reservations->url($reservations->lastPage()).'&searchdate='.$searchdate }}" aria-label="Last">
                                        <span aria-hidden="true">Last</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>

                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Date range picker with time picker
            $('#debtDate').daterangepicker({
                timePickerIncrement: 30,
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: " , ",
                }
            });
        });
    </script>

@endsection