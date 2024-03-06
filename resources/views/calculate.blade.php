<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coin Denomination Calculation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/css/app.css" rel="stylesheet">
</head>

<body>
    <form method="post">
        <label>Total</label>
        <input type="text" name="total" value="{{ $total }}">
        @csrf
    </form>

    @if (isset($error))
    <div class="alert alert-danger" role="alert">
        {{ $error->getMessage() }}
    </div>
    @endif

    <table class="table table-striped table-dark mt-5 w-auto">
        <thead>
            <tr>
                <th>Denomination</th>
                <th>Coin Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($denomination_counts as $index => $denomination)
            <tr>
                <td>{{ $denomination['display'] }}</td>
                <td>{{ $denomination['count'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>