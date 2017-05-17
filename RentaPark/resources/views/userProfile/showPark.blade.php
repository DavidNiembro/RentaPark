@extends('layouts.app')

@section('content')
{!! $Park->parNumber !!}
{!! $Park->parAddress !!}
{!! $Park->parPostCode !!}
{!! $Park->ParCity !!}
{!! $Park->parPrice !!}
{!! $Park->parCouvert !!}
@endsection