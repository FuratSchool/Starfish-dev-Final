@extends('layouts.master')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}"/>
@endsection
@section('title')
    Zoek: {{$keyword}}
@endsection
@section('main')
    <div class="container-fluid first-section">
        <section class="row " id="wrapper" onload="address_geocoder()">
            <div class="col-md-4">
                <div class="card results-card-Gray ">
                    <div class="card-body">
                        <form method="get" action="#">
                            <div class="form-group">
                                <label for="q"><i>klachten</i></label>
                                <input type="text" class="form-control input-lg" id="q" name="q" list="complaints"
                                       placeholder="Zoeken..." required>
                                <datalist id="complaints">
                                    @php$complaints_list = \App\Models\Complaint::all(); @endphp
                                    @foreach($complaints_list as $complaint_option)
                                        <option value="{{$complaint_option->name}}">
                                    @endforeach
                                </datalist>
                            </div>
                            <button type="submit" class="btn  btn-lees-meer pull-right">Zoek</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8" id="contentfix">
                @if($complaints->count() > 0 )
                    @foreach($complaints->chunk(3) as $row)
                        <div class="row">
                            @foreach($row as $complaint)
                                <div class="col-md-6" data-href="/klacht/{{$complaint->name}}">
                                    <div class="card mb-3">
                                        <div class="row">
                                            <div class="col-md-5 ">
                                                <img alt="{{$complaint->name}}" class="card-img"
                                                     src="{{substr($complaint->complaint_image, 6)}}"
                                                     style="height: 100%">
                                            </div>
                                            <div class="col-md-7  ReceptCard" >
                                                <div class="card-body" style="text-align: center">
                                                    <p class="text-center Starfish-Logo-with-text-blue">{{$complaint->name}}</p>
                                                    <p class="text-center">{{$complaint->description}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    @endforeach


                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            {{ $complaints->links() }}

                        </ul>
                    </nav>
                @else
                    <h2 class="noresultshead text-center">Sorry, geen zoekresultaten</h2>
                @endif
            </div>
        </section>
    </div>

@endsection
@section('scripts')
    @parent
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
    <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
@endsection
