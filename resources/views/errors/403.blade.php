@extends('layouts.base')

@php
$metaTitle = '403 Forbidden';
$metaDesc = __('Нет доступа.')
@endphp


@section('content')

@include('errors.template', compact('metaTitle', 'metaDesc'))

@endsection
