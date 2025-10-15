@extends('layouts/default')
@section('title') Documents - Component @stop
@section('content')
@include('documents.partials.index_table', [
  'type' => 'component',
  'columns' => [
    ['label' => 'Model', 'field' => 'component_model'],
    ['label' => 'Part Number', 'field' => 'component_part_number'],
    ['label' => 'Serial Number', 'field' => 'component_serial_number'],
  ]
])
@endsection
