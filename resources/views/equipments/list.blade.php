@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายการอุปกรณ์ห้องประชุม
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">รายการอุปกรณ์ห้องประชุม</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="eqiupmentCtrl">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title">ค้นหาข้อมูล</h3>
                    </div>

                    <form id="frmSearch" name="frmSearch" role="form">
                        <div class="box-body">
                            <div class="col-md-12">                                
                                <div class="form-group">
                                    <label>ค้นหาอุปกรณ์ห้องประชุม</label>
                                    <input type="text" id="searchKey" ng-keyup="getData($event)" class="form-control">
                                </div><!-- /.form group -->
                            </div>

                        </div><!-- /.box-body -->
                  
                        <div class="box-footer">
                            <a href="{{ url('/debttype/add') }}" class="btn btn-primary"> เพิ่มอุปกรณ์ห้องประชุม</a>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box">

                    <div class="box-header with-border">
                      <h3 class="box-title">รายการอุปกรณ์ห้องประชุม</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                      <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 3%; text-align: center;">#</th>
                                    <th style="width: 15%; text-align: center;">รูปปภาพ</th>
                                    <th style="width: 25%; text-align: center;">ชื่ออุปกรณ์</th>
                                    <th style="text-align: left;">รายละเอียด</th>
                                    <th style="width: 8%; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $index = 0; ?>
                                @foreach($equipments as $equipment)
                                    <tr>
                                        <td style="text-align: center;">{{ ++$index }}</td>
                                        <td style="text-align: center;">
                                            <img src="{{ asset('uploads/equipments/'.$equipment->equipment_img) }}" width="120" height="100" alt="{{ $equipment->equipment_name }}">
                                        </td>
                                        <td style="text-align: left;">{{ $equipment->equipment_name }}</td>
                                        <td style="text-align: left;">{{ $equipment->equipment_description }}</td>
                                        <td style="text-align: center;">
                                            <a ng-click="edit($equipment->equipment_id)" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @if(Auth::user()->person_id == '1300200009261')

                                                <a ng-click="delete($equipment->equipment_id)" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            @if($equipments->currentPage() !== 1)
                                <li>
                                    <a href="{{ $equipments->url($equipments->url(1)) }}" aria-label="First">
                                        <span aria-hidden="true">First</span>
                                    </a>
                                </li>
                            @endif

                            <li class="{{ ($equipments->currentPage() === 1) ? 'disabled' : '' }}">
                                <a href="{{ $equipments->url($equipments->currentPage() - 1) }}" aria-label="Prev">
                                    <span aria-hidden="true">Prev</span>
                                </a>
                            </li>
                            
                            @for($i=$equipments->currentPage(); $i < $equipments->currentPage() + 10; $i++)
                                @if ($equipments->currentPage() <= $equipments->lastPage() && ($equipments->lastPage() - $equipments->currentPage()) > 10)
                                    <li class="{{ ($equipments->currentPage() === $i) ? 'active' : '' }}">
                                        <a href="{{ $equipments->url($i) }}">
                                            {{ $i }}
                                        </a>
                                    </li> 
                                @else
                                    @if ($i <= $equipments->lastPage())
                                        <li class="{{ ($equipments->currentPage() === $i) ? 'active' : '' }}">
                                            <a href="{{ $equipments->url($i) }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endfor
                            
                            @if ($equipments->currentPage() < $equipments->lastPage() && ($equipments->lastPage() - $equipments->currentPage()) > 10)
                                <li>
                                    <a href="{{ $equipments->url($equipments->currentPage() + 10) }}">
                                        ...
                                    </a>
                                </li>
                            @endif
                            
                            <li class="{{ ($equipments->currentPage() === $equipments->lastPage()) ? 'disabled' : '' }}">
                                <a href="{{ $equipments->url($equipments->currentPage() + 1) }}" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>

                            @if($equipments->currentPage() !== $equipments->lastPage())
                                <li>
                                    <a href="{{ $equipments->url($equipments->lastPage()) }}" aria-label="Last">
                                        <span aria-hidden="true">Last</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div><!-- /.box-footer -->

                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

@endsection