@extends('layouts.admin')

@section('title', 'Tutor Management')

@section('content')
@php
    // Redirect to the proper tutors index page
    return redirect()->route('admin.tutors');
@endphp
@endsection