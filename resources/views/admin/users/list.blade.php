@extends('base')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset("css/admin.css") }}"/>
@endsection
@section('main')
    {{-- Fixed modal for deleting users --}}
    <div class="modal fade" id="delete-modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Verwijderen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> U staat op het punt om <strong id="delete-name"></strong> te verwijderen.<br/>
                        weet u dit zeker?
                    </p>
                </div>
                <div class="modal-footer">
                    <form id="form-delete" method="POST" action="">
                        {{ csrf_field() }}
                        <input type="submit" value="Ja" class="delete-confirm btn btn-success"/>
                        <input type="submit" value="Nee" class="btn btn-default" data-dismiss="modal"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session()->has('successMsg'))
        <div class="alert alert-success">
            <h4>{!! session()->get('successMsg') !!}</h4>
        </div>
    @elseif(session()->has('errorMsg'))
        <div class="alert alert-danger">
            <h4>{!! session()->get('errorMsg') !!}</h4>
        </div>
    @endif

    <div class="row">
        <div class="col-xs-6 col-md-8">
            <a href="{{ route('admin.user.add') }}" class="btn btn-success">Nieuw</a>
        </div>
        <div class="col-xs-6 col-md-4 searchbar">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </span>
            </div>
        </div><!-- /input-group -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Gebruikersnaam</th>
                    <th>Email</th>
                    <th>Actief</th>
                    <th>Admin</th>
                    <th>Bewerk</th>
                    <th>Verwijder</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->first_name." ".$user->sur_name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->is_active ? "Ja" : "Nee"}}</td>
                        <td>{{ $user->is_admin ? "Ja" : "Nee"}}</td>
                        <td><a href="{{ route('admin.user.update', ['id' => $user->id]) }}" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                        <td><a data-backdrop="false" data-url="{{ route('admin.user.delete', ['id' => $user->id]) }}" data-name="{{ $user->username }}" class="admin-delete" data-target="#delete-modal" data-toggle="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{--<div class="row">--}}
            {{--<div class="pageNumberNav col-xs-12">--}}
                {{--@include('pagination', ['routeName' => 'admin.users'])--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        $('.table').on('click', '.admin-delete', function(){

            $('#form-delete').attr('action', $(this).data('url'));
            $('#delete-name').text($(this).data('name'));
        });
    </script>
@endsection