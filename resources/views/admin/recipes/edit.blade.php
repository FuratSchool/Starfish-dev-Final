@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    {{"Bewerken: {$recipe->name}"}}
@endsection
@section('main')
    <div class="container ">
        <div class="card ">
            <div class="card-header"><h5>Nieuw Recept</h5></div>
            <div class="card-body">
                <form class="form-horizontal " role="form" method="POST"
                      action="{{ route('admin.recipes.update', $recipe) }}"
                      enctype="multipart/form-data" id="newrecipePrimary">
                    {{method_field("PATCH")}}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                                <label for="name" class="col-md-2 control-label">Naam</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{$recipe->name}}"
                                           placeholder="Naam" autofocus>
                                    <p class="help-block">Bijv: haaruitval</p>
                                    @if ($errors->has('name'))
                                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                        <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('ingredients') ? ' has-error has-feedback' : '' }}">
                                <label for="ingredients" class="col-md-2 control-label">Ingredienten</label>
                                <div class="col-md-8">
                                <textarea id="ingredients" class="form-control" name="ingredients"
                                          rows="5">{{$recipe->ingredients}}</textarea>
                                    <p class="help-block">...</p>
                                    @if ($errors->has('ingredients'))
                                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                        <span class="help-block">
                                                <strong>{{ $errors->first('ingredients') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('preperation') ? ' has-error has-feedback' : '' }}">
                                <label for="preperation" class="col-md-2 control-label">Bereiding</label>
                                <div class="col-md-8">
                                <textarea id="preperation" class="form-control" name="preperation"
                                          rows="5">{{$recipe->preperation}}</textarea>
                                    <p class="help-block">...</p>
                                    @if ($errors->has('preperation'))
                                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                        <span class="help-block">
                                                <strong>{{ $errors->first('preperation') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('factoid') ? ' has-error has-feedback' : '' }}">
                                <label for="factoid" class="col-md-2 control-label">Weetjes</label>
                                <div class="col-md-8">
                                <textarea id="factoid" class="form-control" name="factoid"
                                          rows="5">{{$recipe->factoid}}</textarea>
                                    <p class="help-block">...</p>
                                    @if ($errors->has('factoid'))
                                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                        <span class="help-block">
                                                <strong>{{ $errors->first('factoid') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('primary_image') ? ' has-error has-feedback' : '' }}">
                                <label for="primary_image" class="col-md-2 control-label">recept afbeelding</label>
                                <div class="col-md-8">
                                    <a href="{{substr($recipe->primary_image, 6)}}" target="_blank"
                                       style="text-decoration: underline">Huidige afbeelding</a>
                                    <input type="hidden" name="primary_image_cropped" id="primary_image_cropped"
                                           value="">
                                    <input type="hidden" name="primary_image_filename" id="primary_image_filename"
                                           value="{{old('primary_image')}}">
                                    <input id="primary_image" type="file" name="primary_image" accept="image/*">
                                    <span class="help-block">Ondersteunde bestandstype: PNG, JPEG, GIF</span>
                                    @if ($errors->has('primary_image'))
                                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                        <span class="help-block">
                                        <strong>{{ $errors->first('primary_image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-new col-auto pull-right">Maak aan</button>
                </form>
            </div>
        </div>
    </div>
    @include('modals.editor')
    @include('modals.cropper')@endsection
@section('scripts')
    @parent

@endsection
