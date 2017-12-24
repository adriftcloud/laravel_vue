<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

</head>

<body>
    <div id="root">
    </div>
</body>

<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<script src="/js/tinymce/tinymce.min.js"></script>
<script src="/js/tinymce/langs/zh_TW.js"></script>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

</html>
