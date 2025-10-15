@extends('layouts/default')
@section('title') Documents - Accessory @stop
@section('content')
@include('documents.partials.index_table', [
  'type' => 'accessory',
  'columns' => [
    ['label' => 'Part Number', 'field' => 'accessory_part_number'],
    ['label' => 'Serial Number', 'field' => 'accessory_serial_number'],
    ['label' => 'Condition', 'field' => 'accessory_condition'],
  ]
])
@endsection
