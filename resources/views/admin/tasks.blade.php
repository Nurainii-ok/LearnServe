@extends('layouts.admin')

@section('title', 'Task Management')

@section('content')
@php
    // Redirect to the proper tasks index page
    return redirect()->route('admin.tasks');
@endphp
@endsection