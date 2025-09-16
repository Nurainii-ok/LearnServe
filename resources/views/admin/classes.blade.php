@extends('layouts.admin')

@section('title', 'Class Management')

@section('content')
@php
    // Redirect to the proper classes index page
    return redirect()->route('admin.classes');
@endphp
@endsection