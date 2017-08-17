@extends('admin.default-layout')
<!--  -->
@section('title', 'Admin page')
<!-- Content Start -->
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <!-- Start content -->
    <div class="content container-fluid">
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</div>
@endsection
<!-- Content End -->