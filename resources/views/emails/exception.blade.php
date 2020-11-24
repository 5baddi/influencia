@component('mail::message')
# {{ config('app.name') }} | Error 

{!! $content !!}

<br/>
{{ Carbon\Carbon::createFromTimestamp($timestamp)->toDateTimeString() }}
<br/>
@endcomponent
