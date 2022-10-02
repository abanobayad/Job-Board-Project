@extends('layouts.app')
<header>
    <style>
        body
        {
            transition: 0.3s;

        }
        .listing:hover {
            background-color: rgba(128, 128, 128, 0.219);
        }

        .highlited-list {
            background-color: rgba(255, 255, 0, 0.274);
            transition: 0.3s;
        }

        .highlited-list:hover {
            background-color: rgba(255, 255, 27, 0.521);
            transition: 0.3s;
        }

        .list-link{
            text-decoration: none;
        }
    </style>
</header>


@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <section class="content">
                    <h2>Your Jobs ({{ $listings->count() }})</h2>


                    <div class="">

                        @foreach ($listings as $list)

                                <div
                                    class="row my-4 py-2 listing rounded @if ($list->is_highlighted == 1) highlited-list @endif ">
                                    <div class="col-lg-2 col-md-6 col-xs-12"><img class="img-rounded" style="width: 100%" src="/storage/{{ $list->logo }}"
                                            alt="{{ $list->company }} Logo"></div>
                                    <div class="col-lg-4 col-md-6 col-xs-12">
                                        <div class="flex-justify-center">
                                            <a class="list-link" href="{{route('listing.show' , $list->slug)}}">
                                                <h2>{{ $list->title }}</h2>
                                            </a>
                                            <p>{{ $list->company }} &mdash; <span
                                                    class="text-muted">{{ $list->location }}</span></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-xs-12">

                                        <div class="flex-justify-center">
                                            @foreach ($list->tags()->get() as $tag)
                                                <a class="m-1 btn btn-outline-success
                                                @if (request()->get('tag') == $tag->slug) btn-success text-white @endif "
                                                    href="{{ route('listing.index', ['tag' => $tag->slug]) }}">
                                                    {{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>

                                    </div>
                                    <div class="col-lg-2 col-md-6 col-xs-12">
                                        <div class="row">
                                            <div class="col-12 my-3">{{ $list->created_at->diffForHumans() }}</div>
                                            <div class="col-12 my-3">Clicked  <strong> {{ $list->clicks()->count() }}  </strong> Time(s)</div>
                                        </div>
                                    </div>
                                </div>

                        @endforeach

                    </div>
                </section>
            </div>
        </div>

    </div>
@endsection
