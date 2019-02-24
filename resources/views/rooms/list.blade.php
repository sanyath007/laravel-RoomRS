@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            รายการห้องประชุม
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">รายการห้องประชุม</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="roomCtrl">

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
                                    <label>ค้นหาห้องประชุม</label>
                                    <input type="text" id="searchKey" ng-keyup="getData($event)" class="form-control">
                                </div><!-- /.form group -->
                            </div>

                        </div><!-- /.box-body -->
                  
                        <div class="box-footer">
                            <a href="{{ url('/room/add') }}" class="btn btn-primary"> เพิ่มห้องประชุม</a>
                        </div>
                    </form>
                </div><!-- /.box -->

                <div class="box">

                    <div class="box-header">
                        <h3 class="box-title">รายการห้องประชุม</h3>
                    </div>

                    <div class="box-body">

                        @foreach($rooms as $room)

                            <div class="col-md-4">
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
                                        <img class="img-responsive pad" src="{{ asset('uploads/rooms/' .$room->room_id. '/thumbnail.jpg') }}" style="width: 250px; height: 141px;" alt="Photo">

                                        <p style="min-height: 75px;">
                                            ที่ตั้ง {{ $room->room_locate }}<br>
                                            ขนาดห้อง {{ $room->room_size }} ความจุ {{ $room->room_capacity }} คน
                                        </p>

                                        <!-- Pull Left Button -->
                                        <a href="{{ url('reserve/add') }}" class="btn btn-default btn-xs">
                                            <i class="fa fa-send-o"></i> จองห้อง
                                        </a>
                                        <a href="{{ url('room/detail/'.$room->room_id) }}" class="btn btn-default btn-xs">
                                            <i class="fa fa-search"></i> รายละเอียด
                                        </a>

                                        <!-- Pull Right Button -->
                                        <a href="{{ url('room/delete/'.$room->room_id) }}" class="btn btn-danger btn-xs pull-right">
                                            <i class="fa fa-trash"></i> ลบ 
                                        </a>
                                        <a href="{{ url('room/edit/'.$room->room_id) }}" class="btn btn-warning btn-xs pull-right" style="margin-right: 4px;">
                                            <i class="fa fa-edit"></i> แก้ไข
                                        </a>
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
                            </div><!-- /.col-md-4 -->

                        @endforeach

                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            @if($rooms->currentPage() !== 1)
                                <li>
                                    <a href="{{ $rooms->url($rooms->url(1)) }}" aria-label="First">
                                        <span aria-hidden="true">First</span>
                                    </a>
                                </li>
                            @endif

                            <li class="{{ ($rooms->currentPage() === 1) ? 'disabled' : '' }}">
                                <a href="{{ $rooms->url($rooms->currentPage() - 1) }}" aria-label="Prev">
                                    <span aria-hidden="true">Prev</span>
                                </a>
                            </li>
                            
                            @for($i=$rooms->currentPage(); $i < $rooms->currentPage() + 10; $i++)
                                @if ($rooms->currentPage() <= $rooms->lastPage() && ($rooms->lastPage() - $rooms->currentPage()) > 10)
                                    <li class="{{ ($rooms->currentPage() === $i) ? 'active' : '' }}">
                                        <a href="{{ $rooms->url($i) }}">
                                            {{ $i }}
                                        </a>
                                    </li> 
                                @else
                                    @if ($i <= $rooms->lastPage())
                                        <li class="{{ ($rooms->currentPage() === $i) ? 'active' : '' }}">
                                            <a href="{{ $rooms->url($i) }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endfor
                            
                            @if ($rooms->currentPage() < $rooms->lastPage() && ($rooms->lastPage() - $rooms->currentPage()) > 10)
                                <li>
                                    <a href="{{ $rooms->url($rooms->currentPage() + 10) }}">
                                        ...
                                    </a>
                                </li>
                            @endif
                            
                            <li class="{{ ($rooms->currentPage() === $rooms->lastPage()) ? 'disabled' : '' }}">
                                <a href="{{ $rooms->url($rooms->currentPage() + 1) }}" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>

                            @if($rooms->currentPage() !== $rooms->lastPage())
                                <li>
                                    <a href="{{ $rooms->url($rooms->lastPage()) }}" aria-label="Last">
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