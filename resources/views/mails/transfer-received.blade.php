<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    Hi,
    <br>
    You received a transfer from {{ $transfer->from_email }}
    <br>
    Title: {{ $transfer->title }}
    <br>
    Click the link to download the files: <a href="{{ route('download', ['hash' => $transfer->hash]) }}">{{ route('download', ['hash' => $transfer->hash]) }}</a>.
</body>
</html>
