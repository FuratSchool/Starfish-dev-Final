@extends('layouts.admin')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/BudEdit.css')}}"/>

@endsection
@section('title')
    Bewerken: {{$group->name}}
@endsection
@section('main')
    <div class="col-md-12">
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.groups.index')}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Terug" />
                </div>
            </form>
        </div>
    </div>
    <div class="cbox">
        <div class="btitle">Bewerken</div>
        <hr class="bdivider">
        <div class="bcontent">
            <form class="form-horizontal " role="form" method="POST" id="newGroup" action="{{ route('admin.groups.store') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                    <label for="name" class="col-md-4 control-label">Naam: </label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name"  value="{{$group->name}}" autofocus>
                        @if ($errors->has('name'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('members') ? ' has-error has-feedback' : '' }}">
                    <label for="members" class="col-md-4 control-label">Leden (<span id="memberCount">0</span>) :</label>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-edit" data-toggle="modal" data-target="#selectUsers">Kiezen</button><br>
                        @if ($errors->has('name'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                @include('modals.uselect')
                <button type="submit" class="btn btn-new col-md-push-4 col-md-6">Opslaan</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $('.modal').on('show.bs.modal', function () {
                $('.modal .modal-body').css('overflow-y', 'auto');
                $('.modal .modal-body').css('max-height', $(window).height() * 0.7);
            });
            $('.modal').on('hide.bs.modal', function () {
                var x = $('input[data-group="members"]:checkbox:checked').length;
                $("#memberCount").text(x);
            });
            var toggler = $("#toggleAll:checkbox");
            $(toggler).change(function () {
                if( $(this).prop("checked") ) {
                    $('input:checkbox').prop('checked', true);
                } else {
                    $('input:checkbox').prop('checked', false);
                }
            });

            $('input[data-group="members"]:checkbox').change(function () {
                if($(this).prop('checked'))
                    if ( $(toggler).prop('checked')  ) {
                        $(toggler).prop('checked', false);
                    }
                if($('input[data-group="members"]:checkbox:checked').length === $('input[data-group="members"]:checkbox').length) {
                    $(toggler).prop('checked', true);
                }
            });
            $('input:checkbox').ready(function () {
                if($('input[data-group="members"]:checkbox:checked').length === $('input[data-group="members"]:checkbox').length) {
                    $(toggler).prop('checked', true);
                }
            });
        });
    </script>
@endsection
