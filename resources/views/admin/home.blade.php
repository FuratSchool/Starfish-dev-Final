@extends('layouts.admin')
@section('title', "Dashboard")
@section('main')
    <div class="cbox">
        <div class="btitle">Welkom!</div>
        <hr class="bdivider">
        <div class="bcontent">
            <p><i class="fa fa-caret-right" aria-hidden="true"></i>Welkom bij het admin paneel van starfish</p>
            <p><i class="fa fa-caret-right" aria-hidden="true"></i>Aan de linker kant zie je de voor jouw beschikbare functies</p>
            <p><i class="fa fa-caret-right" aria-hidden="true"></i>Je kunt altijd op de knop<i class="fa fa-home " aria-hidden="true"></i>klikken om weer op dit scherm te komen</p>
        </div>
    </div>
    <div class="cbox">
        <div class="btitle">Tips: <i class="fa fa-info-circle" aria-hidden="true" title= "Dit is een voorbeeld van een tooltip"></i></div>
        <hr class="bdivider">
        <div class="bcontent">
            <p><i class="fa fa-caret-right" aria-hidden="true"></i>Je wachtwoord kan je veranderen kan via de instellingen, deze vind je door op je gebruikersnaam te klikken</p>
            <p><i class="fa fa-caret-right" aria-hidden="true"></i>Mocht je een probleem hebben met de site klik dan op <i class="fa fa-question-circle " aria-hidden="true"></i></p>
            <p><i class="fa fa-caret-right" aria-hidden="true"></i>Voor meer info over een onderdeel  ga dan met je muis over <i class="fa phpdebugbar-fa-info-circle" aria-hidden="true"></i></p>
        </div>
    </div>
    <div class="cbox">
        <div class="btitle">Berichten:</div>
        <hr class="bdivider">
        <div class="bcontent">
            <p><i class="fa fa-caret-right" aria-hidden="true"></i>Dit een een bericht</p>
            <p><i class="fa fa-caret-right" aria-hidden="true"></i>Dit is ook een bericht</p>
            <p><i class="fa fa-caret-right" aria-hidden="true"></i>Je raad het al, dit ook</p>
        </div>
    </div>
@endsection