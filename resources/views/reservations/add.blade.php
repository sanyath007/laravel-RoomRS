@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            จองใช้ห้อง
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">จองใช้ห้อง</li>
        </ol>
    </section>

        <!-- Main content -->
    <section class="content" ng-controller="reservationCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><i class="fa fa-cart-plus"></i> จองใช้ห้อง</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <form   id="reservation-form" 
                                class="form-horizontal" 
                                action="{{ url('/reserve/store') }}" 
                                method="post" 
                                role="form">
                            <input type="hidden" id="reserve_user" class="form-control" name="reserve_user" value="{{ Auth::user()->person_id }}">
                            <input type="hidden" id="reserve_status" class="form-control" name="reserve_status" value="1">
                            {{ csrf_field() }}      
                
                            <div class="row">
                                <div class="col-md-7">                       

                                    <div class="form-group reserve_sdate">
                                        <label class="control-label col-sm-3" for="reserve_sdate">วันที่เริ่ม</label>
                                        <div class="col-sm-9">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="reserve_sdate" name="reserve_sdate">
                                            </div>
                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>

                                    <div class="form-group reserve_edate">
                                        <label class="control-label col-sm-3" for="reserve_edate">ถึงวันที่</label>
                                        <div class="col-sm-9">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="reserve_edate" name="reserve_edate">
                                            </div>
                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-5">
                                    <div class="form-group reserve_stime">
                                        <label class="control-label col-sm-3" for="reserve_stime">เวลาเริ่ม</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="text" id="reserve_stime" class="form-control timepicker" name="reserve_stime">
                                                <span class="input-group-addon picker"><i class="fa fa-clock-o"></i></span>
                                            </div>

                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>

                                    <div class="form-group reserve_etime">
                                        <label class="control-label col-sm-3" for="reserve_etime">ถึงเวลา</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="text" id="reserve_etime" class="form-control timepicker" name="reserve_etime">
                                                <span class="input-group-addon picker"><i class="fa fa-clock-o"></i></span>
                                            </div>

                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>

                                </div><!--/.col -->
                            </div><!--/.row -->
                            
                            <div class="row">        
                                <div class="col-md-7">
                                    
                                    <div class="form-group col-sm-offset-2">
                                        <label class="control-label col-sm-3" for="reserve_faction">กลุ่มภารกิจ</label>
                                        <div class="col-sm-9">
                                            <select id="reserve_faction" class="form-control" name="reserve_faction">
                                                <option value="">--- กรุณาเลือก ---</option>
                                                <option value="1">กลุ่มภารกิจด้านอำนวยการ</option>
                                                <option value="2">กลุ่มภารกิจด้านบริการทุติยภูมิและตติยภูมิ</option>
                                                <option value="3">กลุ่มภารกิจด้านบริการปฐมภูมิ</option>
                                                <option value="7">กลุ่มภารกิจด้านพัฒนาระบบบริการและสนับสนุนบริการสุขภาพ</option>
                                                <option value="5">กลุ่มภารกิจด้านการพยาบาล</option>
                                            </select>                        
                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group reserve_depart required">
                                        <label class="control-label col-sm-3" for="reserve_depart">หน่วยงานผู้จอง</label>
                                        <div class="col-sm-9">
                                            <select id="reserve_depart" class="form-control" name="reserve_depart">
                                                <option value="">--- กรุณาเลือก ---</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->depart_id }}">{{ $department->depart_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>  

                                    <div class="form-group reserve_tel required">
                                        <label class="control-label col-sm-3" for="reserve_tel">เบอร์ติดต่อภายใน</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="reserve_tel" class="form-control" name="reserve_tel">
                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>   

                                    <div class="form-group reserve_room required">
                                        <label class="control-label col-sm-3" for="reserve_room">ห้องประชุม</label>
                                        <div class="col-sm-9">
                                            <select id="reserve_room" 
                                                    class="form-control" 
                                                    name="reserve_room"
                                                    ng-model="reserve_room"
                                                    ng-change="changeRoomImg()">
                                                <option value="">--- กรุณาเลือก ---</option>
                                                @foreach($rooms as $room)
                                                    <option value="{{ $room->room_id }}">{{ $room->room_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>  

                                    <div class="form-group reserve_activity_type required">
                                        <label class="control-label col-sm-3" for="reserve_activity_type">ประเภทกิจกรรม</label>
                                        <div class="col-sm-9">
                                            <select id="reserve_activity_type" class="form-control" name="reserve_activity_type">
                                                <option value="">--- กรุณาเลือก ---</option>
                                                @foreach($activities as $activity)
                                                    <option value="{{ $activity->activity_type_id }}">{{ $activity->activity_type_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>

                                    <div class="form-group reserve_topic required">
                                        <label class="control-label col-sm-3" for="reserve_topic">หัวข้อ</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="reserve_topic" class="form-control" name="reserve_topic">
                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>                                

                                    <div class="form-group reserve_att_num required">
                                        <label class="control-label col-sm-3" for="reserve_att_num">จำนวนผู้เข้าร่วม</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="reserve_att_num" class="form-control" name="reserve_att_num" value="0">

                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>
                                                        
                                    <div class="form-group reserve_layout required">
                                        <label class="control-label col-sm-3" for="reserve_layout">การจัดห้อง</label>
                                        <div class="col-sm-9">
                                            <select id="reserve_layout" 
                                                    class="form-control" 
                                                    name="reserve_layout"
                                                    ng-model="reserve_layout"
                                                    ng-change="changeLayoutImg()">
                                                <option value="">--กรุณาเลือก--</option>
                                                @foreach($layouts as $layout)
                                                    <option value="{{ $layout->reserve_layout_id }}">{{ $layout->reserve_layout_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    
                                    <div class="row">
                                        <div class="col-md-10">
                                            <a href="#" id="img_room" class="thumbnail">
                                                <img src="{{ asset('/uploads/rooms/1/thumbnail.jpg') }}" alt="1/thumbnail.jpg">
                                            </a>                        
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-10">
                                            <a href="#" id="img_layout" class="thumbnail">
                                                <img src="{{ asset('/uploads/layouts/U.jpg') }}" alt="Banquet">
                                            </a>                        
                                        </div>
                                    </div>

                                </div><!--/.col -->
                            </div><!--/.row -->

                            <div class="row">
                                <div class="col-md-7">
                                    
                                    <div class="form-group reserve_comment">
                                        <label class="control-label col-sm-3" for="reserve_comment">รายละเอียดอื่นๆ</label>
                                        <div class="col-sm-9">
                                            <textarea id="reserve_comment" class="form-control" name="reserve_comment" rows="6"></textarea>

                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>         

                                    <div class="form-group reserve_remark">
                                        <label class="control-label col-sm-3" for="reserve_remark">หมายเหตุ</label>
                                        <div class="col-sm-9">
                                            <textarea id="reserve_remark" class="form-control" name="reserve_remark" rows="6"></textarea>

                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>      

                                    <div class="form-group reserve_budget">
                                        <label class="control-label col-sm-3" for="reserve_budget">งบประมาณ</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="reserve_budget" class="form-control" name="reserve_budget" value="0">

                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>                
                                                    
                                    <div class="form-group reserve_pay_rate">
                                        <label class="control-label col-sm-3" for="reserve_pay_rate">อัตราค่าห้องประชุม</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="reserve_pay_rate" class="form-control" name="reserve_pay_rate" value="0">

                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>                
                                    
                                    <div class="form-group reserve_pay_price">
                                        <label class="control-label col-sm-3" for="reserve_pay_price">รวมค่าห้องประชุม</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="reserve_pay_price" class="form-control" name="reserve_pay_price" value="0">

                                            <div class="help-block help-block-error "></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-10">

                                            <div class="panel panel-default">
                                                <div class="panel-body">

                                                    <div class="form-group reserve_equipment required">
                                                        <label class="control-label col-sm-3" for="reserve_equipment">อุปกรณ์</label>
                                                        <div class="col-sm-9">
                                                            <input type="hidden" id="reserve_equipment" name="reserve_equipment" value="">

                                                            <div id="reserve_equipment">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="reserve_equipment[]" value="1" ng-click="changeCheckboxValue()"> ไมโครโฟน
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="reserve_equipment[]" value="2" ng-click="changeCheckboxValue()"> คอมพิวเตอร์
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="reserve_equipment[]" value="3" ng-click="changeCheckboxValue()"> Projector
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="reserve_equipment[]" value="4" ng-click="changeCheckboxValue()"> Visualizer
                                                                    </label>
                                                                </div>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="reserve_equipment[]" value="9" checked="checked" ng-click="changeCheckboxValue()"> ไม่ใช้
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="help-block help-block-error "></div>
                                                        </div>
                                                    </div>                            
                                                </div>

                                            </div><!-- /.panel -->

                                        </div>
                                    </div>
                                    
                                </div><!--/.col -->
                            </div><!--/.row -->

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="col-xs-5 col-sm-3 col-md-3"></div>
                                        <div class="col-xs-7 col-sm-9 col-md-9">
                                            <button type="submit" class="btn btn-success">บันทึก</button>                        
                                        </div>
                                    </div>
                                </div>
                            </div><!--/.row -->

                        </form>
        
                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">

                    </div>

                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            $('#reserve_sdate').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });

            $('#reserve_edate').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });

            //Timepicker
            $('#reserve_stime').timepicker({
                template: false,
                showInputs: false,
                minuteStep: 5,
                showMeridian: false
            }).timepicker('setTime', '13:00 AM');

            $('#reserve_etime').timepicker({
                template: false,
                showInputs: false,
                minuteStep: 5,
                showMeridian: false
            }).timepicker('setTime', '13:00 AM');
        });
    </script>

@endsection