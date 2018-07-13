@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    {{"Bewerken: {$article->name}"}}
@endsection
@section('main')
    <div class="col-md-6 cbox-fluid">
        <div class="btitle">Klacht bewerken</div>
        <hr class="bdivider">
        <div class="bcontent">
            <form class="form-horizontal " role="form" method="POST"
                  action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data"
                  id="newarticle">
                {{method_field("PATCH")}}
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                            <label for="name" class="col-md-2 control-label">Naam</label>
                            <div class="col-md-8">
                                <input id="name" type="text" pattern="^[a-zA-Z\s\-]+$" class="form-control" name="name"
                                       value="{{$article->name}}" placeholder="Naam" autofocus>
                                <p class="help-block">Bijv: Mandy Van Oosten</p>
                                @if ($errors->has('name'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error has-feedback' : '' }}">
                            <label for="description" class="col-md-2 control-label">Beschrijving</label>
                            <div class="col-md-8">
                                <textarea id="description" class="form-control" name="description"
                                          rows="10">{{$article->description}}</textarea>
                                <p class="help-block">...</p>
                                @if ($errors->has('description'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('short_description') ? ' has-error has-feedback' : '' }}">
                            <label for="short_description" class="col-md-2 control-label">Korte beschrijving</label>
                            <div class="col-md-8">
                                <input id="short_description" type="text" class="form-control" name="short_description"
                                       value="{{$article->short_description}}" placeholder="Korte Beschrijving"
                                       autofocus>
                                <p class="help-block">Geef in 1 a 2 zinnen weer wat deze klacht is</p>
                                @if ($errors->has('short_description'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('short_description') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('article_image') ? ' has-error has-feedback' : '' }}">
                            <label for="article_image" class="col-md-2 control-label" style="hyphens: auto">Artikel-afbeelding</label>
                            <div class="col-md-8">
                                <a href="{{substr($article->article_image, 6)}}" target="_blank"
                                   style="color: white; text-decoration: underline">Huidige afbeelding</a>
                                <input type="hidden" name="article_image_cropped" id="article_image_cropped"
                                       value="">
                                <input type="hidden" name="article_image_filename" id="article_image_filename">
                                <input id="article_image" type="file" name="article_image" accept="image/*">
                                <span class="help-block">Ondersteunde bestandstype: PNG, JPEG, GIF</span>
                                @if ($errors->has('article_image'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('article_image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-new col-offset-md-4 col-md-4">Bewerken</button>
            </form>
        </div>
    </div>
    @include('modals.editor')
    @include('modals.cropper')
@endsection
@section('scripts')
    @parent

@endsection
