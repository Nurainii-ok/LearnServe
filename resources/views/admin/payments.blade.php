@extends('layouts.admin')

@section('title', 'Payment Management')

@section('content')
@php
    // Redirect to the proper payments index page
    return redirect()->route('admin.payments');
@endphp
@endsection