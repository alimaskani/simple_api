<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        ul,li{
            list-style:  none;
        }
    </style>
</head>
<body>

<div>

    <ul>
            <li>{{$users -> name}}</li>
            <li>{{$users -> address}}</li>
            <li>{{$result -> name}}</li>
    </ul>

</div>

</body>
</html>
