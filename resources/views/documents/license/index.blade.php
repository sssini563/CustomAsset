@extends('layouts/default')
@section('title') Documents - License @stop
@section('content')
@include('documents.partials.index_table', [
  'type' => 'license',
  'columns' => [
    ['label' => 'License Key', 'field' => 'license_key'],
    ['label' => 'Seats', 'field' => 'license_seats'],
    ['label' => 'Vendor', 'field' => 'license_vendor'],
  ]
])
@endsection
