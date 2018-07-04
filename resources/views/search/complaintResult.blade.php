@extends('layouts.master')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}"/>
@endsection
@section('title')
    Zoek: {{$keyword}}
@endsection
@section('main')
    <div class="col-md-12">
        {!! Breadcrumbs::render('searchComplaint', $keyword) !!}
    </div>
    <div class="col-md-12" id="wrapper" onload="address_geocoder()">
        <div class="col-md-3 bg-light"  >
            <div class="col-md-12" id="contentfix">
                <form method="get" action="#">
                    <div class="form-group">
                        <label for="q"><i>klachten</i></label>
                        <input type="text" class="form-control input-lg" id="q" name="q" list="complaints" placeholder="Zoeken..." required>
                        <datalist id="complaints">
                            @php$complaints_list = \App\Models\Complaint::all(); @endphp
                            @foreach($complaints_list as $complaint_option)
                                <option value="{{$complaint_option->name}}">
                            @endforeach
                        </datalist>
                    </div>
                    <button type="submit" class="btn  btn-search pull-right">Zoek</button>
                </form>
            </div>
        </div>
        <div class="col-md-9" id="contentfix">
            @include('layouts.errors')
            <div class="row">
                <div class="col-md-12">
                    @if($complaints->count() > 0 )
                        @foreach($complaints->chunk(3) as $row)
                            <div class="row">
                                @foreach($row as $complaint)
                                    <div class="col-md-4 spec" data-href="/klacht/{{$complaint->name}}" >
                                        <div class="box">
                                        <div class="col-md-4">
                                            <img alt="{{$complaint->name}}" src="{{urldecode(asset('images/avatars/complaints/'.$complaint->complaint_image)) }}" class="spec_image">
                                        </div>
                                        <div class="col-md-8 " id="specinfo">
                                            <h2 class="text-center"><b>{{$complaint->name}}</b></h2>
                                            <p class="text-center">{{$complaint->description}}</p>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                            <div class="text-center">
                                {!! $complaints->appends(request()->input())->links() !!}
                            </div>
                    @else
                        <h2 class="noresultshead text-center">Sorry,  geen zoekresultaten</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
    <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
@endsection
