@extends('layouts.admin')
@section('styles')
    @parent

@endsection
@section('title')
    Groepen
@endsection
@section('main')
    <div class="col-md-12">
        <div class="col-md-2">
            <form method="GET" action="{{url()->previous()}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Terug " />
                </div>
            </form>
        </div>
        @if(auth()->user()->is_admin > 1)
            <div class="col-md-2">
                <form method="GET" action="{{route('admin.groups.create')}}">
                    <div class="form-group">
                        <input type="submit" class="btn btn-new form-control" value="Nieuwe groep" />
                    </div>
                </form>
            </div>
            @endif
    </div>
    @if (\Session::has('success'))
        <div class="col-md-4" id="msg">
            <div class="msg msg-success msg-success-background text-black">
                <span class="glyphicon glyphicon glyphicon-ok"></span>
                {!! \Session::get('success') !!}
                <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $('#msg').remove()"></i>
            </div>
        </div>
    @endif
    <table class="table table-striped table-bordered usertable grouptable" id="table1">
        <thead>
            <tr>
                <th class="text-center" colspan="10">Jouw Groepen</th>
            </tr>
            <tr>
                <th>Naam</th>
                <th>Leden</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usergroups as $group)
                @if(auth()->user()->inGroup($group))
                    <tr>
                        <th><a href="{{route('admin.groups.show', $group)}}">{{$group->name}}</a></th>
                        <th>{{$group->users_count}}</th>
                    </tr>
                @endif
            @endforeach
            @if($usergroups->total() > 10)
                @for($i = 0 ; $i < 10 - count($usergroups); $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                    </tr>
                @endfor
            @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="10">
                {{$usergroups->appends($_GET)->links()}}
            </td>
        </tr>
        </tfoot>
    </table>
    @if(auth()->user()->is_admin > 1)
    <table class="table table-striped table-bordered usertable grouptable" id="table1" >
        <thead>
        <tr>
            <th class="text-center" colspan="10">Groepen</th>
        </tr>
        <tr>
            <th>
                Naam
            </th>
            <th>
                Leden
            </th>
            <th>Bewerken</th>
            <th>Verwijderen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td><a href="{{route('admin.groups.show', $group)}}">{{$group->name}}</a></td>
                <td>{{$group->users_count}}</td>
                <td>
                    <form method="GET" action="{{route('admin.groups.edit', $group)}}">
                        <input type="submit" class="btn btn-edit" value="Bewerken" />
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{route('admin.groups.destroy', $group)}}" onsubmit="return confirm('Weet je zeker dat je {{$group->name}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                        {{method_field('delete')}}
                        {{csrf_field()}}
                        <input type="submit" class="btn btn-destroy" value="Verwijderen"/>
                    </form>
                </td>
            </tr>
        @endforeach
        @if($groups->total() > 10)
            @for($i = 0 ; $i < 10 - count($groups); $i++)
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="10">
                {{$groups->appends($_GET)->links()}}
            </td>
        </tr>
        </tfoot>
    </table>
    @endif
@endsection
@section('scripts')
    @parent
@endsection
