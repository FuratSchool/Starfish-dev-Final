@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    {{$therapy->name}}
@endsection
@section('main')
    <div class="col-md-6">
        @if (\Session::has('success'))
            <div class="msg msg-success msg-success-background">
                <span class="glyphicon glyphicon glyphicon-ok"></span> {!! \Session::get('success') !!}<i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $('#msg').remove()"></i>
            </div>
        @endif
    </div>
    <div class="col-md-6"></div>
    <div class="cbox-fluid col-md-3" id="specData">
        <div class="btitle">Gegevens</div>
        <hr class="bdivider">
        <div class="bcontent">
            <dl>
                <dt>Naam:</dt> <dd>{{$therapy->name}}</dd>
                <dt>Beschrijving:</dt> <dd>{{$therapy->description}}</dd>
                <dt>Korte Beschrijving:</dt> <dd>{{$therapy->short_description}}</dd>

            </dl>
            @if( auth()->user()->hasAccess('admin.therapies.edit'))
                <div class="text-center">
                    <form class="col-md-12" method="GET" action="{{route('admin.therapies.edit', $therapy->id)}}">
                        <div class="form-group text-center">
                            <input type="submit" class="form-control btn btn-edit" value="Bewerken"/>
                        </div>
                    </form>
                    @if(Auth::user()->hasAccess('admin.therapies.destroy'))
                        <form class="col-md-12" method="POST" action="{{route('admin.therapies.destroy', $therapy->id)}}" onsubmit="return confirm('Weet je zeker dat je {{$therapy->name}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <div class="form-group text-center">
                                <input  type="submit" class="form-control btn btn-destroy" value="Verwijderen" />
                            </div>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
@endsection
