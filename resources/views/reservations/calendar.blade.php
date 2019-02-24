@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ตารางใช้ห้องประชุม
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">ตารางใช้ห้องประชุม</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="reservationCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><i class="fa fa-calendar-check-o"></i> ตารางใช้ห้องประชุม</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <!-- AngularJS Fullcalendar -->
                        <div id="calendar" style="margin: 20px 0px 20px 0px;" ng-init="initCalendar()"></div>

                        <!-- JQuery Fullcalendar -->
                        <!-- <div id="calendar" style="margin: 20px 0px 20px 0px;"></div>
                        
                        <script> 
                            $(document).ready(function() { 
                                $('#calendar').fullCalendar({
                                    "header": {
                                        "left": "prev,next today",
                                        "center": "title",
                                        "right": "month,agendaWeek,agendaDay"
                                    },
                                    "eventLimit": true,
                                    "firstDay": 1,
                                    "events": [{
                                        "id": 0,
                                        "title": "Event one",
                                        "allDay": true,
                                        "start": "2017-01-02T09:00:00+00:00",
                                        "end": "2017-01-06T08:00:00+00:00"
                                    }]
                                });
                            }); 
                        </script> -->

                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">

                    </div>

                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

@endsection
