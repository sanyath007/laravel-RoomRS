@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายละเอียดห้องประชุม
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">รายละเอียดห้องประชุม</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="creditorCtrl" ng-init="getData()">

        <div class="row">
            <div class="col-md-12">

                <!-- Box Comment -->
                <div class="box box-widget">

                    <div class="box-header with-border">
                        <div class="user-block">
                            <img class="img-circle" src="{{ asset('img/user2-160x160.jpg') }}" alt="User Image">
                            <span class="username"><a href="#">{{ $room->room_name }}</a></span>
                            <span class="description">Shared publicly - 7:30 PM Today</span>
                        </div><!-- /.user-block -->

                        <!-- <div class="box-tools">
                            <button type="button" 
                                    class="btn btn-box-tool" 
                                    data-toggle="tooltip" 
                                    title="Mark as read">
                                <i class="fa fa-circle-o"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div> --><!-- /.box-tools -->

                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <img class="img-responsive pad" src="{{ asset('uploads/rooms/' .$room->room_id. '/thumbnail.jpg') }}" alt="Photo">

                        <p>
                            ที่ตั้ง {{ $room->room_locate }}<br>
                            ขนาดห้อง {{ $room->room_size }} ความจุ {{ $room->room_capacity }} คน
                        </p>

                        <a href="{{ url('reserve/new') }}" class="btn btn-default btn-xs">
                            <i class="fa fa-send-o"></i> จองห้อง
                        </a>
                        <!-- <a href="{{ url('room/detail/'.$room->room_id) }}" class="btn btn-default btn-xs">
                            <i class="fa fa-search"></i> รายละเอียด
                        </a> -->
                        <!-- <span class="pull-right text-muted">127 likes - 3 comments</span> -->
                    </div><!-- /.box-body -->

                    <div class="box-footer box-comments">
                        <!-- <div class="box-comment">
                            <img class="img-circle img-sm" 
                                 src="{{ asset('img/user2-160x160.jpg') }}" 
                                 alt="User Image">

                            <div class="comment-text">
                                <span class="username">
                                    Maria Gonzales
                                    <span class="text-muted pull-right">8:03 PM Today</span>
                                </span>

                                It is a long established fact that a reader will be distracted
                                by the readable content of a page when looking at its layout.
                            </div>
                        </div> --><!-- /.box-comment -->

                        <!-- <div class="box-comment">
                            <img class="img-circle img-sm" 
                                 src="{{ asset('img/user2-160x160.jpg') }}" 
                                 alt="User Image">

                            <div class="comment-text">
                                <span class="username">
                                    Luna Stark
                                    <span class="text-muted pull-right">8:03 PM Today</span>
                                </span>

                                It is a long established fact that a reader will be distracted
                                by the readable content of a page when looking at its layout.
                            </div>
                        </div> --><!-- /.box-comment -->
                    </div>
                </div><!-- Box Comment -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

@endsection