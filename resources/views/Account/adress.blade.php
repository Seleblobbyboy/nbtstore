<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ url('assets/CSS/Profile/profiledata.css') }}">
    <link rel="stylesheet" href="{{ url('assets/CSS/product/shopping.css') }}">

    <title>Document</title>
</head>

<body>


    @extends('layouts.navigatuonuser')
    @section('content-user')
        <h3>ข้อมูลของฉัน</h3>

        @if ($CustomerAddress)
            @foreach ($CustomerAddress as $item)
                <div class="card-method2">
                    <div class="g1">
                        <div class="select-card2">
                            @if (session('address') == $item->AddressID)
                                <a href="{{ url('/cart/address', $item->AddressID) }}" class="select-btn2"><i
                                        class="fas fa-check-square"></i></a>
                            @else
                                <a href="{{ url('/cart/address', $item->AddressID) }}" class="select-btn2"><i
                                        class="far fa-square"></i></a>
                            @endif
                        </div>
                        <div class="card-name2">
                            <p><b>{{ $item->CustomerName }}</b> {{ $item->PhoneNumber }}</p>
                            <small>{{ Str::limit($item->Address, 35, '...') }},{{ $item->PostalCode }},{{ $item->Province }},{{ $item->District }},{{ $item->Subdistrict }}</small>
                        </div>
                    </div>
                    @if ($item->AddressID == optional($item->Orders)->AddressID)
                    <div class="edit">
                    </div>
                    @else
                    <div class="edit">
                        <a href="{{ route('customer.destroy', $item->AddressID) }}"><i class="fas fa-trash-alt"></i></a>
                    </div>
                    @endif
                </div>
            @endforeach
        @endif
    @endsection


</body>

</html>
