@component('mail::message')
# {{ config('app.name') }} | Error 

{!! $content !!}

<br/>
{{ Carbon\Carbon::now()->toDateTimeString() }}
<br/>
@endcomponent
