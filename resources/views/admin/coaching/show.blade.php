@extends('layouts.admin')
@section('styles')
    @parent
@endsection

@section('main')
    <div class="col-md-12">
        @if (\Session::has('success'))
            <div class="msg msg-success msg-success-background">
                <span class="glyphicon glyphicon glyphicon-ok"></span> {!! \Session::get('success') !!}<i
                        class="fa fa-close" style="float: right" aria-hidden="true"
                        onclick="return $('#msg').remove()"></i>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-header bg-primary">
            <h2 class="card-title">Naam: {{$coaching->name}}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Korte Beschrijving: {{$coaching->description}}</h4>
                    <h5>Beschrijving: {{$coaching->short_description}}</h5>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-row">
                <div class="col-md-6">
                    @if( auth()->user()->hasAccess('admin.coaching.edit'))
                        <div class="text-center">
                            <form method="GET" action="{{route('admin.coaching.edit', $coaching->id)}}">
                                <div class="form-group text-center">
                                    <input type="submit" class="form-control btn btn-primary text-white" value="Bewerken"/>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    @if(Auth::user()->hasAccess('admin.coaching.destroy'))
                        <form class="col-md-12" method="POST" action="{{route('admin.wellness.destroy', $coaching->id)}}"
                              onsubmit="return confirm('Weet je zeker dat je {{$coaching->name}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <div class="form-group text-center">
                                <input type="submit" class="form-control btn btn-destroy" value="Verwijderen"/>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
