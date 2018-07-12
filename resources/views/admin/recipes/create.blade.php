@extends('layouts.admin')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/cropper.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/BudEdit.css')}}"/>
@endsection
@section('title')
    Nieuwe Recept
@endsection
@section('main')
    <div class="container ">
        <div class="card ">
            <div class="card-header"><h5>Nieuw Recept</h5></div>
            <div class="card-body">
                <form class="form-horizontal " role="form" method="POST" action="{{ route('admin.recipes.store') }}"
                      enctype="multipart/form-data" id="newrecipePrimary">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                                <label for="name" class="col-md-2 control-label">Naam</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{old('name')}}"
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
                                          rows="5">{{old('ingredients')}}</textarea>
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
                                          rows="5">{{old('preperation')}}</textarea>
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
                                          rows="5">{{old('factoid')}}</textarea>
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
                                <label for="primary_image" class="col-md-2 control-label">Artikel afbeelding</label>
                                <div class="col-md-8">
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
    @include('modals.cropper')
@endsection
@section('scripts')
    @parent
    <script type="text/javascript" src="{{asset('js/BudEdit.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/recipe_primary_image.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/recipe_secondary_image.js')}}"></script>
    <script src="{{asset('js/cropper.min.js')}}"></script>
@endsection

