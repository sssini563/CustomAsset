@extends('layouts/default')
@section('title') Documents - Consumable @stop
@section('content')
@include('documents.partials.index_table', [
  'type' => 'consumable',
  'columns' => [
    ['label' => 'Batch', 'field' => 'consumable_batch'],
    ['label' => 'Qty', 'field' => 'consumable_qty'],
    ['label' => 'Unit', 'field' => 'consumable_unit'],
  ]
])
@endsection
