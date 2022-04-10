@extends('layouts.app')

@section('title','Welcome to DaPAYROLL management system')

@push('css')
    {{-- Extra page wise style sheets --}}
@endpush

@section('page_heading','Welcome')

@section('breadcrumbs')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Welcome</li>
    </ol>
@endsection

@section('content')
    <p>Welcome</p>
@endsection

@push('js')
    {{--Extra page wise scripts--}}
@endpush
