@extends('layouts.app')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="application/javascript" src={{asset('js/calendarLocal.js')}}></script>

@section('content')
    <div class="col-md-8 col-md-offset-2">
        {!! $calendar->calendar() !!}
        {!! $calendar->script() !!}
    </div>
@endsection