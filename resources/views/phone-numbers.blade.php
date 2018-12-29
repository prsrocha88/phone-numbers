<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>Phone Numbers</h1>

            <form class="mt-4">
                <div class="row">
                    <div class="col-3">
                        <select id="country" class="form-control">
                            <option selected disabled>Select Country</option>
                            @foreach (config('app.phone_codes') as $code => $phone)
                                <option value="{{ $code }}">{{ $phone['country'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <select id="state" class="form-control">
                            <option selected disabled>Select Valid or Invalid Phones</option>
                            <option value="OK">Valid Phones</option>
                            <option value="NOK">Invalid Phones</option>
                        </select>
                    </div>
                </div>
            </form>

            <table class="table mt-4">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Country</th>
                    <th scope="col">State</th>
                    <th scope="col">Country Code</th>
                    <th scope="col">Phone num.</th>
                </tr>
                </thead>
                <tbody id="phone_list">
                @foreach ($phones as $phone)
                    <tr>
                        <td scope="row">{{ $phone['country'] }}</td>
                        <td>{{ $phone['state'] }}</td>
                        <td>{{ $phone['code'] }}</td>
                        <td>{{ $phone['num'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <button id="prev" type="button" class="btn btn-dark" @if ($start == 0) disabled @else data-start="{{ $start - 5 }}" @endif>Prev</button>
            <button id="next" type="button" class="btn btn-dark" data-start="{{ $start + 5 }}">Next</button>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
