@extends('index2')
@section('content')
    <style>
        div.fixed-btn {
            position: -webkit-sticky;
            position: sticky;
            top: 50px;
            z-index: 100;

        }
    </style>

    <div class="container">
        <div class="fixed-btn">
            <div class="row p-2">
                <div class="col-12">
                    <a href="{{ route('expense.index') }}" class="btn btn-block btn-primary"><i class="fa fa-arrow-circle-left"
                            aria-hidden="true"></i> Back</a>
                </div>
            </div>
        </div>
        <div class="container">
            <h2>Expense ID - {{ $expense->id }}</h2>
            @foreach ($images as $image)
                <div class="col-12 pt-2">
                    <img src="{{ URL::asset($image) }}" style="width: 100%" />
                </div>
            @endforeach
        </div>

    </div>
@endsection
