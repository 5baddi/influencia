<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>Influencia</title>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons" rel="stylesheet"/>
        <link href="{{ asset('css/app.css') }}?v={{ config('scraper.version') }}" rel="stylesheet"/>
    </head>
    <body>
        <div id="app">
            <App></App>
        </div>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                appId      : '235851987928787',
                xfbml      : true,
                version    : 'v9.0'
                });
                FB.AppEvents.logPageView();
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
