@extends('layouts.admin')
@section('title', "Dashboard")
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading"><h5 class="card-title">Welkom</h5>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <p><i class="fa fa-caret-right" aria-hidden="true"></i>Welkom bij het admin paneel van starfish
                        </p>
                        <p><i class="fa fa-caret-right" aria-hidden="true"></i>Aan de linker kant zie je de voor jouw
                            beschikbare functies</p>
                        <p><i class="fa fa-caret-right" aria-hidden="true"></i>Je kunt altijd op de knop<i
                                    class="fa fa-home " aria-hidden="true"></i>klikken om weer op dit scherm te komen
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading"><h5 class="card-title">Berichten:</h5>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <p><i class="fa fa-caret-right" aria-hidden="true"></i>Dit een een bericht</p>
                        <p><i class="fa fa-caret-right" aria-hidden="true"></i>Dit is ook een bericht</p>
                        <p><i class="fa fa-caret-right" aria-hidden="true"></i>Je raad het al, dit ook</p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading"><h5 class="card-title">Berichten:</h5>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <p><i class="fa fa-caret-right" aria-hidden="true"></i>Je wachtwoord kan je veranderen kan via
                            de instellingen, deze vind je door op je gebruikersnaam te klikken</p>
                        <p><i class="fa fa-caret-right" aria-hidden="true"></i>Mocht je een probleem hebben met de site
                            klik dan op <i class="fa fa-question-circle " aria-hidden="true"></i></p>
                        <p><i class="fa fa-caret-right" aria-hidden="true"></i>Voor meer info over een onderdeel ga dan
                            met je muis over <i class="fa phpdebugbar-fa-info-circle" aria-hidden="true"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection