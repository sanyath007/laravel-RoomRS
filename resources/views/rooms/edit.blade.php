@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แก้ไขห้องประชุม
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขห้องประชุม</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="roomCtrl" ng-init="getRoom('{{ $room->room_id }}')">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">แก้ไขห้องประชุม [{{ $room->room_id }}]</h3>
                    </div>

                    <form id="frmEditRoom" 
                            name="frmEditRoom" 
                            method="post" 
                            action="{{ url('/room/update') }}" 
                            role="form" 
                            enctype="multipart/form-data">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        <input type="hidden" id="roomId" name="roomId" value="{{ $room->room_id }}">
                        {{ csrf_field() }}
                        
                        <div class="box-body">

                            <!-- <ul  class="nav nav-tabs">
                                <li class="active">
                                    <a  href="#1a" data-toggle="tab">ข้อมูลทั่วไป</a>
                                </li>
                                <li>
                                    <a href="#2a" data-toggle="tab">ข้อมูลเพิ่มเติม</a>
                                </li>
                            </ul> -->

                            <!-- ข้อมูลทั่วไป -->
                            <!-- <div class="tab-content clearfix">

                                <div class="tab-pane active" id="1a" style="padding: 10px;"> -->

                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.room_name.$invalid}">
                                            <label class="control-label">ชื่อห้อง :</label>
                                            <input type="text" 
                                                    id="room_name" 
                                                    name="room_name" 
                                                    ng-model="room.room_name" 
                                                    class="form-control" required>
                                            <div class="help-block" ng-show="frmEditRoom.room_name.$error.required">
                                                กรุณากรอกชื่อห้องก่อน
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.room_locate.$invalid}">
                                            <label class="control-label">ที่ตั้ง :</label>
                                            <input type="text" 
                                                    id="room_locate" 
                                                    name="room_locate" 
                                                    ng-model="room.room_locate" 
                                                    class="form-control" required>
                                            <div class="help-block" ng-show="frmEditRoom.room_locate.$error.required">
                                                กรุณากรอกที่ตั้งก่อน
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.room_pay_rate.$invalid}">
                                            <label class="control-label">ราคาค่าใช้จ่ายห้อง (บาท) :</label>
                                            <input type="text" 
                                                    id="room_pay_rate" 
                                                    name="room_pay_rate" 
                                                    ng-model="room.room_pay_rate"
                                                    pattern="^[-+]?[0-9]*\.?[0-9]+$"
                                                    class="form-control">
                                            <div class="help-block" ng-show="frmEditRoom.room_pay_rate.$error.required">
                                                กรุณากำหนดราคาค่าใช้จ่ายห้องก่อน
                                            </div>
                                            <div class="help-block" ng-show="frmEditRoom.room_pay_rate.$error.pattern">
                                                กรุณากรอกราคาค่าใช้จ่ายห้องเป็นตัวเลข
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.room_contact_tel.$invalid}">
                                            <label class="control-label">โทรศัพท์ :</label>
                                            <input type="text" 
                                                    id="room_contact_tel" 
                                                    name="room_contact_tel" 
                                                    ng-model="room.room_contact_tel" 
                                                    class="form-control">
                                            <div class="help-block" ng-show="frmEditRoom.room_contact_tel.$error.required">
                                                กรุณากรอกเบอร์โทรศัพท์ก่อน
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">                                
                                        <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.room_size.$invalid}">
                                            <label class="control-label">ขนาด (กxย เมตร) :</label>
                                            <input type="text" 
                                                    id="room_size" 
                                                    name="room_size" 
                                                    ng-model="room.room_size" 
                                                    class="form-control" required>
                                            <div class="help-block" ng-show="frmEditRoom.room_size.$error.required">
                                                กรุณากรอกขนาดก่อน
                                            </div>
                                        </div>    

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.room_capacity.$invalid}">
                                            <label class="control-label">ความจุ (คน) :</label>
                                            <input type="text" 
                                                    id="room_capacity" 
                                                    name="room_capacity" 
                                                    ng-model="room.room_capacity"
                                                    pattern="^[-+]?[0-9]*\.?[0-9]+$"
                                                    class="form-control" required>
                                            <div class="help-block" ng-show="frmEditRoom.room_capacity.$error.required">
                                                กรุณากรอกความจุก่อน
                                            </div>
                                            <div class="help-block" ng-show="frmEditRoom.room_capacity.$error.pattern">
                                                กรุณากรอกความจุเป็นตัวเลข
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.room_reserv_max.$invalid}">
                                            <label class="control-label">จำนวนวันที่จองได้สูงสุด (วัน) :</label>
                                            <input type="number" 
                                                    id="room_reserv_max" 
                                                    name="room_reserv_max" 
                                                    ng-model="room.room_reserv_max"
                                                    pattern="^[-+]?[0-9]*\.?[0-9]+$" 
                                                    class="form-control">
                                            <div class="help-block" ng-show="frmEditRoom.room_reserv_max.$error.required">
                                                กรุณากำหนดจำนวนวันที่จองได้สูงสุดก่อน
                                            </div>
                                            <div class="help-block" ng-show="frmEditRoom.room_reserv_max.$error.pattern">
                                                กรุณากรอกจำนวนวันที่จองได้สูงสุดเป็นตัวเลข
                                            </div>
                                        </div>

                                        <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.room_detail.$invalid}">
                                            <label class="control-label">หมายเหตุ :</label>
                                            <input type="text" 
                                                    id="room_detail" 
                                                    name="room_detail" 
                                                    ng-model="room.room_detail" 
                                                    class="form-control">
                                            <div class="help-block" ng-show="frmEditRoom.room_detail.$error.required">
                                                กรุณากรอกหมายเหตุก่อน
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">รูปภาพ :</label>
                                            <input type="file" 
                                                    id="room_img[]" 
                                                    name="room_img[]" 
                                                    class="form-control">
                                            <div class="help-block" ng-show="false">
                                                กรุณากรอกรูปภาพก่อน
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <img src="{{ asset('uploads/rooms/' .$room->room_id. '/thumbnail.jpg') }}" style="width: 250px; height: 141px;" alt="Photo">
                                        </div>
                                    </div>

                                <!-- </div> --><!-- /.tab-pane -->                      

                                <!-- ข้อมูลเพิ่มเติม -->
                                <!-- <div class="tab-pane" id="2a" style="padding: 10px;">

                                    <div class="row">
                                        <div class="col-md-6">       
                                            <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.supplier_credit.$invalid}">
                                                <label class="control-label">เครดิต (วัน) :</label>
                                                <input type="text" id="supplier_credit" name="supplier_credit" ng-model="room.supplier_credit" class="form-control" required>
                                                <div class="help-block" ng-show="frmEditRoom.supplier_credit.$error.required">
                                                    กรุณากรอกจำนวนวันเครดิตก่อน
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">       
                                            <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.supplier_taxrate.$invalid}">
                                                <label class="control-label">อัตราภาษีที่หัก (%) :</label>
                                                <input type="text" id="supplier_taxrate" name="supplier_taxrate" ng-model="room.supplier_taxrate" class="form-control" required>
                                                <div class="help-block" ng-show="frmEditRoom.supplier_taxrate.$error.required">
                                                    กรุณากรอกอัตราภาษีที่หักก่อน
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <div class="col-md-6">       
                                            <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.supplier_agent_name.$invalid}">
                                                <label class="control-label">ชื่อผู้ติดต่อ :</label>
                                                <input type="text" id="supplier_agent_name" name="supplier_agent_name" ng-model="room.supplier_agent_name" class="form-control">
                                                <div class="help-block" ng-show="frmEditRoom.supplier_agent_name.$error.required">
                                                    กรุณากรอกชื่อผู้ติดต่อก่อน
                                                </div>
                                            </div>

                                            <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.supplier_agent_email.$invalid}">
                                                <label class="control-label">อีเมล์ผู้ติดต่อ :</label>
                                                <input type="text" id="supplier_agent_email" name="supplier_agent_email" ng-model="room.supplier_agent_email" class="form-control">
                                                <div class="help-block" ng-show="frmEditRoom.supplier_agent_email.$error.required">
                                                    กรุณากรอกอีเมล์ผู้ติดต่อก่อน
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">       
                                            <div class="form-group" ng-class="{ 'has-error' : frmEditRoom.supplier_agent_contact.$invalid}">
                                                <label class="control-label">เบอร์ผู้ติดต่อ :</label>
                                                <input type="text" id="supplier_agent_contact" name="supplier_agent_contact" ng-model="room.supplier_agent_contact" class="form-control">
                                                <div class="help-block" ng-show="frmEditRoom.supplier_agent_contact.$error.required">
                                                    กรุณากรอกเบอร์ผู้ติดต่อก่อน
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> --><!-- /.tab-pane -->

                            <!-- </div> --><!-- /.tab-content -->
                            
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="update($event, frmEditRoom)" class="btn btn-success pull-right">
                                บันทึก
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