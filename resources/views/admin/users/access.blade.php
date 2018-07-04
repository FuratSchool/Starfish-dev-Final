@extends('layouts.admin')
@section('title')
    Toegang: {{$user->username}} bewerken
@endsection
@section(' styles')
    @parent
@endsection
@section('main')
    @php
        $items =    \App\Models\Access::where('minLoa','<', $user->is_admin+1)->orderBy("entry")->get();
        $chunkSize = 8;
        $chunkSize = $chunkSize % 2 ? $chunkSize+1 : $chunkSize;
        $colNeeded = ceil($items->count()/$chunkSize);
        $colWidth = floor(12/$colNeeded);
        $colWidth = $colWidth < 3 ? 3 : $colWidth;
        $boxSize = 12-$chunkSize;
        $boxSize = $boxSize > 4 ? $boxSize : 4;
        $boxSize++;
        $boxSize = $boxSize > 12 ? 12 : $boxSize;
    @endphp
    <div class="cbox-fluid col-md-12">
        <div class="btitle">Toegang bewerken</div>
        <hr class="bdivider">
        <div class="bcontent">
            <a class="text-white" href="{{route('admin.umgmt.show', $user->id)}}"> << Terug naar profiel</a>
            @if ($errors->has('error'))
                <div class="msg msg-danger msg-danger-text"> <span class="glyphicon glyphicon glyphicon-remove"></span> {!! $errors->first('error') !!}</div>
            @endif
            <form class="form-horizontal " role="form" method="POST" action="{{ route('admin.umgmt.storeAccess', $user->id) }}">
                {{method_field('patch')}}
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label><input type="checkbox" name="all" id="checkall" />Alles selecteren</label>
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('access') ? ' has-error has-feedback' : '' }}">
                        @foreach($items->chunk($chunkSize) as $chunk)
                            <div class="col-md-{{$colWidth}}">
                                @foreach($chunk as $item)
                                    <div class="checkbox">
                                        <label><input type="checkbox"  data-group="accessBox" name="access[]" value="{{$item->id}}" @if($user->hasAccess($item->route, $user->id)) checked @endif >{{$item->entry}}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        @if ($errors->has('access'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                        <strong>{{ $errors->first('access') }}</strong>
                                    </span>
                        @endif
                </div>
                <button type="submit" class="btn btn-new col-md-push-4 col-md-6">Bewerken</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection