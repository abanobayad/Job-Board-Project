@extends('layouts.app')

<head>
    <style>
        .list-card
        {
            background-color: transparent;
        }
    </style>
</head>

@section('content')
    <div class="container">

        <div class="row">

            <div class="col-lg-9 col-md-12">
                <h3>Job Title</h3>

                <div class="flex-justify-center">
                    @foreach ($listing->tags()->get() as $tag)
                        <a class="m-1 btn btn-outline-success
                        @if (request()->get('tag') == $tag->slug) btn-success text-white @endif
                    "
                            href="">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>

                <p>
                    {!! $listing->content !!}
                </p>


            </div>

            <div class="col-lg-3 col-md-12">
                <div class="card" style="background-color: transparent ; border:none">
                    <img class="card-img-top" style="border:none"  src="/storage/{{$listing->logo}}" alt="{{ $listing->company }} Logo">
                    <div class="card-body list-card">
                        <p class="card-text"> <span class="fw-bold">Location : </span> {{ $listing->location }}</p>
                        <p class="card-text"> <span class="fw-bold">Company : </span> {{ $listing->company }}</p>
                        <a href="{{route('listing.apply' , $listing->slug)}}" class="btn btn-lg btn-outline-warning col-12">APPLY NOW</a>
                    </div>

                </div>
            </div>
        </div>


    </div>
@endsection
