@extends('layouts.admin')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/cropper.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/BudEdit.css')}}"/>
    <script defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTMGtzFUNyyV3YICxx0aGCag3eryHThEc"></script>
    <script type="text/javascript">
        Object.defineProperty(window, "console", {
            value: console,
            writable: false,
            configurable: false
        });

        var i = 0;
        function showWarningAndThrow() {
            if (!i) {
                setTimeout(function () {
                    console.log("%cWarning message", "font: 2em sans-serif; color: yellow; background-color: red;");
                }, 1);
                i = 1;
            }
            throw "Console is disabled";
        }

        var l, n = {
            set: function (o) {
                l = o;
            },
            get: function () {
                showWarningAndThrow();
                return l;
            }
        };
        Object.defineProperty(console, "_commandLineAPI", n);
        Object.defineProperty(console, "__commandLineAPI", n);
    </script>
@endsection
@section('title')
    {{"Bewerken: {$specialist->name}"}}
@endsection
@section('main')
    <div class="col-md-12 cbox-fluid">
        <div class="btitle">Specialist bewerken</div>
        <hr class="bdivider">
        <div class="bcontent">
            <form class="form-horizontal " role="form" method="POST" action="{{ route('admin.specialists.update', $specialist) }}" enctype="multipart/form-data" id="newspec">
                {{method_field("PATCH")}}
                {{ csrf_field() }}
                <div class="row">
                    <h2 style="padding: 10px"><b>Persoonlijke informatie</b></h2>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error has-feedback' : '' }}">
                            <label for="name" class="col-md-2 control-label">Naam</label>
                            <div class="col-md-8">
                                <input id="name" type="text" pattern="^[a-zA-Z\s\-]+$" class="form-control" name="name"  value="{{$specialist->name}}" placeholder="Naam" autofocus>
                                <p class="help-block">Bijv: Mandy Van Oosten</p>
                                @if ($errors->has('name'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('occupation') ? ' has-error has-feedback' : '' }}">
                            <label for="occupation" class="col-md-2 control-label">Beroep</label>
                            <div class="col-md-8">
                                <input id="occupation" type="text" class="form-control" name="occupation"  value="{{$specialist->occupation}}" placeholder="Beroep" >
                                <p class="help-block">Bijv: Accupuncturist</p>
                                @if ($errors->has('occupation'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('occupation') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="lat" id="lat" value="{{$specialist->map_lat}}">
                        <input type="hidden" name="lng" id="lng" value="{{$specialist->map_lng}}">
                        <input type="hidden" name="region" id="region" value="{{$specialist->region}}">
                        <input type="hidden" name="country" id="country" value="{{$specialist->country}}">
                        <div class="form-group{{ $errors->has('address') ? ' has-error has-feedback' : '' }}">
                            <label for="address" class="col-md-2 control-label">Adres</label>
                            <div class="col-md-8">
                                <input id="address" type="text" pattern="^([a-zA-Z0-9]+[\s])+(([^\d](?!\d{1,4}[a-z]))?([\d]{1,4})([^\d]{1,2})?)$" class="form-control" name="address"  value="{{$specialist->address}}" placeholder="Adres" >
                                <p class="help-block">Bijv: Albedastraat 15</p>
                                @if ($errors->has('address'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error has-feedback' : '' }}">
                            <label for="city" class="col-md-2 control-label">Stad/Plaats</label>
                            <div class="col-md-8">
                                <input id="city" type="text" pattern="^[a-zA-Z\s\-]+$" class="form-control" name="city"  value="{{$specialist->city}}" placeholder="Stad/Plaats">
                                <p class="help-block">Bijv: Amsterdam</p>
                                @if ($errors->has('city'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('postal_code') ? ' has-error has-feedback' : '' }}">
                            <label for="postal_code" class="col-md-2 control-label">Postcode</label>
                            <div class="col-md-8">
                                <input id="postal_code" type="text" pattern="^(\d){4}[\s]?([A-Z/a-z]){2}$" class="form-control" name="postal_code"  value="{{$specialist->postal_code}}" placeholder="Postcode">
                                <p class="help-block">Bijv: 1234AB of 1234 AB</p>
                                @if ($errors->has('postal_code'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('postal_code') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Regio</label>
                            <output id="regionOut" class="col-md-8 text-italic text-white">Wordt automatisch ingevuld</output>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Land</label>
                            <output id="countryOut" class="col-md-8 text-italic text-white">Wordt automatisch ingevuld</output>
                        </div>
                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error has-feedback' : '' }}">
                            <label for="phone_number" class="col-md-2 control-label">Telefoon</label>
                            <div class="col-md-8">
                                <input id="phone_number" type="tel" pattern="^(([(]?(0)[0-9]{2}[0-9]?[)]?([-]|[\s])?[1-9][0-9]{5})|((\+31|31|0|0031)([\s]|[-])?(\()?[0]?[0-9]{2,3}(\))?([\s]|[-])?[0-9]{6}))$" class="form-control" name="phone_number"  value="{{$specialist->phone_number}}" placeholder="Telefoonnummer"/>
                                <p class="help-block">Bijv: 020-123456 of 020123456</p>
                                @if ($errors->has('phone_number'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error has-feedback' : '' }}">
                            <label for="mobile_phone" class="col-md-2 control-label">Mobiel</label>
                            <div class="col-md-8">
                                <input id="mobile_phone" type="tel" pattern="^(((0|\+31|31|0031)?[\s]?6){1}([\s]|[-])?[1-9][0-9]{7})$" class="form-control" name="mobile_phone"  value="{{$specialist->mobile_phone}}" placeholder="Mobielnummer" />
                                <p class="help-block">Bijv: 06-12345678 of 0612345678</p>
                                @if ($errors->has('mobile_phone'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('is_anonymous') ? ' has-error has-feedback' : '' }}">
                            <label for="is_anonymous" class="col-md-2 control-label">Betaald</label>
                            <div class="col-md-8">
                                <label class="radio-inline"><input id="is_anonymous" type="radio"  name="is_anonymous"  value="0"  checked >Niet betaald</label>
                                <label class="radio-inline"><input id="not_anonymous" type="radio"  name="is_anonymous"  value="1" @if($specialist->is_anonymous) checked @endif>Betaald</label>
                                @if ($errors->has('is_anonymous'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('is_anonymous') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12" id="gmap" style="height: 250px;">
                        </div>
                    </div>
                </div>
                <div class="row" id="payfields" style="display: none">
                    <div class="col-md-12">
                        <hr>
                        <h2 style="padding: 10px"><b>Extra informatie</b></h2>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('url_name') ? ' has-error has-feedback' : '' }}">
                            <label for="url_name" class="col-md-2 control-label">URL Naam</label>
                            <div class="col-md-8">
                                <input id="url_name" type="text" pattern="^[a-zA-Z0-9\-]+$" class="form-control" name="url_name"  value="{{$specialist->url_name}}" placeholder="URL-Naam">
                                <p class="help-block">Dit is de URL die in de adresbalk wordt getoond</p>
                                <p class="help-block">Het is aan te raden om de voorgestelde URL te gebruiken</p>
                                @if ($errors->has('url_name'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                                <strong>{{ $errors->first('url_name') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('profile_image') ? ' has-error has-feedback' : '' }}">
                            <label for="profile_image" class="col-md-2 control-label" style="hyphens: auto">Profiel-afbeelding</label>
                            <div class="col-md-8">
                                <a href="{{substr($specialist->profile_image, 6)}}" target="_blank" style="color: white; text-decoration: underline">Huidige afbeelding</a>
                                <input type="hidden" name="profile_image_cropped" id="profile_image_cropped" value="">
                                <input type="hidden" name="profile_image_filename" id="profile_image_filename">
                                <input id="profile_image" type="file"  name="profile_image"   accept="image/*">
                                <span class="help-block">Ondersteunde bestandstype: PNG, JPEG, GIF</span>
                                @if ($errors->has('profile_image'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('profile_image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('company') ? ' has-error has-feedback' : '' }}">
                            <label for="company" class="col-md-2 control-label">Bedrijf</label>
                            <div class="col-md-8">
                                <input id="company" type="text" class="form-control" name="company"  value="{{$specialist->company}}" placeholder="Bedrijf">
                                <p class="help-block">Gebruik de volledige naam van het bedrijf, dit vergroot de vindbaarheid</p>
                                @if ($errors->has('company'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                            <strong>{{ $errors->first('company') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('story') ? ' has-error has-feedback' : '' }}">
                            <label for="story" class="col-md-2 control-label">Verhaal</label>
                            <div class="col-md-8">
                                <input type="hidden" name="story" id="story" value="{{$specialist->story}}" tmp="{{$specialist->story}}" data-display="Verhaal">
                                <button type="button" class="btn btn-edit" data-toggle="modal" data-target="#storyEditor" data-inputTarget="#story">
                                    Editor openen
                                </button>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('mission') ? ' has-error has-feedback' : '' }}">
                            <label for="mission" class="col-md-2 control-label">Missie/Leader</label>
                            <div class="col-md-8">
                                <textarea id="mission" class="form-control" name="mission" >{{$specialist->mission}}</textarea>
                                <p class="help-block">Geef in 2 a 3 zinnen het doel van deze specialist weer</p>
                                @if ($errors->has('mission'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                            <strong>{{ $errors->first('mission') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('url') ? ' has-error has-feedback' : '' }}">
                            <label for="url" class="col-md-2 control-label">Website</label>
                            <div class="col-md-8">
                                <input id="url" type="text" pattern="([--:\w?@%&+~#=]*\.[a-z]{2,4}\/{0,2})((?:[?&](?:\w+)=(?:\w+))+|[--:\w?@%&+~#=]+)?" class="form-control" name="url"  value="{{$specialist->url}}" placeholder="URL"/>
                                <p class="help-block">Gebruik de volledige URL</p>
                                <p class="help-block">Bijv: https://www.starfish.nl</p>
                                @if ($errors->has('url'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error has-feedback' : '' }}">
                            <label for="email" class="col-md-2 control-label">E-Mail</label>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email"  value="{{$specialist->email}}" placeholder="E-Mail" />
                                <p class="help-block">Bijv: piet@example.com</p>
                                @if ($errors->has('email'))
                                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h2 style="padding: 10px"><b>Afbeeldingen</b></h2>
                    </div>
                    <div class="col-md-6">
                        @for($x = 1;  $x <= 5; $x++)
                            <div class="form-group{{$errors->has('image'.$x) ? 'has-error has-feedback' : ''}}">
                                <label for="image{{$x}}" class="col-md-3 control-label">Afbeelding {{$x}}</label>
                                <div class="col-md-7">
                                    <input id="image{{$x}}"  name="images[image{{$x}}][file]" type="file" accept="image/*">
                                    <input id="image{{$x}}caption"  name="images[image{{$x}}][caption]" type="text" class="form-control" style="margin-top: 10px" placeholder="Beschrijving afbeelding {{$x}}">
                                    @if ($errors->has('image'.$x))
                                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                        <span class="help-block">
                                        <strong>{{ $errors->first('image'.$x) }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h2 style="padding: 10px"><b>Diverse</b></h2>
                    </div>
                    <div class="col-md-6">
                        @for($x = 1;  $x <= 5; $x++)
                            <div class="form-group{{$errors->has('diverse'.$x) ? 'has-error has-feedback' : ''}}">
                                <h4 class="col-md-2 text-bold">Diverse {{$x}}</h4>

                                <div class="col-md-10">
                                    <div class="col-md-12">
                                        <label for="diverse{{$x}}name" class="col-md-2 control-label">Naam: </label>
                                        <input class=" form-control" id="diverse{{$x}}name"  name="diverses[diverse{{$x}}][name]" type="text" placeholder="Naam Diverse {{$x}}">
                                        <span class="help-block" style="margin-left: calc(100%/12*2)">Naam voor de link</span>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="diverse{{$x}}target" class="col-md-2 control-label">Locatie: </label>
                                        <input id="diverse{{$x}}target"  name="diverses[diverse{{$x}}][target]" type="file">
                                        <div class="col-md-12">
                                            <span class="help-block" style="margin-left: calc(100%/12*2)"><i>Bijna</i> alle formaten worden geaccepteerd</span>
                                        </div>
                                    </div>
                                    @if ($errors->has('diverse'.$x))
                                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                        <span class="help-block">
                                        <strong>{{ $errors->first('diverse'.$x) }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h2 style="padding: 10px"><b>Werkgebieden</b></h2>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-9 col-md-offset-1 alert alert-warning alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Let op:</strong> Zorg dat er geen dubbele werkgebieden staan!
                        </div>
                        @php $x = 1; @endphp
                        @foreach($specialist->specialisms as $curSpecialism)
                            <div class="form-group{{$errors->has('specialisms.'.$x.'.name') ? 'has-error has-feedback' : ''}}">
                                <label for="specialism{{$x}}" class="col-md-3 control-label">Werkgebied {{$x}}</label>
                                <div class="col-md-7">
                                    <select id="specialism{{$x}}" name="specialisms[{{$x}}][name]" class="form-control">
                                        @if($x > 1)
                                            <option value="" selected>Geen {{$x}}de werkgebied</option>
                                        @endif
                                        @foreach($specialisms as $specialism)
                                            <option value="{{$specialism->name}}" @if($specialism->name == $curSpecialism->name) selected @endif>{{$specialism->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('specialisms.'.$x.'.name'))
                                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                        <span class="help-block">
                                        <strong>{{ $errors->first('specialisms.'.$x.'.name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @php $x++ @endphp
                        @endforeach
                        @while($x <= 5)
                            <div class="form-group{{$errors->has('specialisms.'.$x.'.name') ? 'has-error has-feedback' : ''}}">
                                <label for="specialism{{$x}}" class="col-md-3 control-label">Werkgebied {{$x}}</label>
                                <div class="col-md-7">
                                    <select id="specialism{{$x}}" name="specialisms[{{$x}}][name]" class="form-control">
                                        @if($x > 1)
                                            <option value="" selected>Geen {{$x}}de werkgebied</option>
                                        @endif
                                        @foreach($specialisms as $specialism)
                                            <option value="{{$specialism->name}}">{{$specialism->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('specialisms.'.$x.'.name'))
                                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                        <span class="help-block">
                                        <strong>{{ $errors->first('specialisms.'.$x.'.name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @php($x++)
                        @endwhile
                        <div class="col-md-9 col-md-offset-1 alert alert-warning">
                            <strong>Staat er een werkgebied niet bij?</strong>
                            Voeg deze toe via <a href="{{route("admin.specialisms.index")}}" class="alert-link">Werkgebieden</a>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-new col-offset-md-4 col-md-4">Registreren</button>
            </form>
        </div>
    </div>
    @include('modals.editor')
    @include('modals.cropper')
@endsection
@section('scripts')
    @parent
    <script type="text/javascript" src="{{asset('js/BudEdit.js')}}" ></script>
    <script type="text/javascript" src="{{asset('js/specImage.js')}}" ></script>
    <script src="{{asset('js/cropper.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[type="radio"]:checked').trigger("click");
            $('#postal_code').trigger("blur");
        })
    </script>
@endsection
