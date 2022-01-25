@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/quill.bubble.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/quill.snow.css')); ?>">
<link rel="stylesheet" type="text/css" href={{ asset('assets/styles/css/custom_style.css') }}>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/dropzone.min.css')); ?>">

<meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    
    <style>
  /* Popover */
  .popover {
    border: 1px solid red !important;
    background-color: #dad6dd!important; 
    color : #fff !important; 
  }
  .popover-title {
    background-color: #73AD21 !important;
    color: #FFFFFF !important;
    font-size: 28px;
    text-align: center;
}

.popover-danger {
    background-color: red !important;
    border-color: red !important;
    color: white !important;
}

.popover.right>.arrow {
    top: 50% !important;
    left: -11px !important;
    margin-top: -11px !important;
    border-right-color: #999 !important;
    border-right-color: rgba(0,0,0,.25) !important;
    border-left-width: 0 !important;
}

.popover:after {
  text-align: center;
    border: solid 10px transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-bottom-color: red;
    top: 101%;
    left: 45%;
    margin-top: -1px;
    /* margin: 0 auto; */
    transform: rotate(
179deg);
}

.swal2-file, .swal2-input, .swal2-textarea {
    box-sizing: border-box;
    width: 100%;
    transition: border-color .3s,box-shadow .3s;
    border: 1px solid #d9d9d9;
    border-radius: 0.1875em;
    background: inherit;
    box-shadow: inset 0 1px 1px rgb(0 0 0 / 6%);
    color: inherit;
    font-size: 1.125em;
    width: -webkit-fill-available !important;
}

.swal2-input {
    height: 2.625em;
    padding: 0 0.75em;
    width: -webkit-fill-available;
}

  </style>



@endsection
@section('main-content')
<div class="breadcrumb">
   <h1> Les visites </h1>

</div>

<div id="calendar"></div>


@endsection
@section('page-js')


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" ></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/fr.min.js'></script>

<script src="{{ asset('js/script_calendar.js') }}"></script>


@endsection

