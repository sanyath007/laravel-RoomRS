@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แก้ไขประเภทหนี้ : {{ $equipment->equipment_id }}
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขประเภทหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="equipmentCtrl" ng-init="getEquipment('{{ $equipment->equipment_id }}')">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">ฟอร์มแก้ไขประเภทหนี้</h3>
                    </div>

                    <form id="frmEditEquipment" name="frmEditEquipment" method="post" action="{{ url('/equipment/update') }}" role="form">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        {{ csrf_field() }}
                        
                        <div class="box-body">
                            <div class="col-md-8">
                                <div class="form-group" ng-class="{ 'has-error' : frmEditEquipment.equipment_name.$invalid}">
                                    <label class="control-label">ประเภทหนี้ :</label>
                                    <input type="text" id="equipment_name" name="equipment_name" ng-model="equipment.equipment_name" class="form-control" required>
                                    <div class="help-block" ng-show="frmEditEquipment.equipment_name.$error.required">
                                        กรุณากรอกประเภทหนี้ก่อน
                                    </div>
                                </div> 

                                <div class="form-group" ng-class="{ 'has-error' : frmEditEquipment.debt_cate_id.$invalid}">
                                    <label class="control-label">ประเภท :</label>
                                    <select id="debt_cate_id"
                                            name="debt_cate_id"
                                            ng-model="equipment.debt_cate_id"
                                            class="form-control select2" 
                                            style="width: 100%; font-size: 12px;" required>

                                        @foreach($cates as $cate)

                                            <option value="{{ $cate->debt_cate_id }}">
                                                {{ $cate->debt_cate_name }}
                                            </option>

                                        @endforeach
                                        
                                    </select>
                                    <div class="help-block" ng-show="frmEditEquipment.debt_cate_id.$error.required">
                                        กรุณาเลือกประเภท
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="add($event, frmEditEquipment)" class="btn btn-warning pull-right">
                                แก้ไข
                            </button>
                        </div><!-- /.box-footer -->
                    </form>

                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        });
    </script>

@endsection