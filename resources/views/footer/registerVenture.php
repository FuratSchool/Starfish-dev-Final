@extends('layouts.master')
@section('title')
@endsection
@section('styles')
    @parent
@endsection
@section('main')
    <div class="first-section">
        <div class="card homepage-card-Gray">
            <div class="card-body">
                <h4 class="Starfish-Logo-with-text-blue Roboto-light text-center">Contact</h4>
                <p class="Roboto-light text-center">Wil je graag contact met ons opnemen? Vul dan dit formulier in</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNaam">Naam</label>
                            <input type="name" class="form-control" id="inputNaam" placeholder="Naam">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSubject">Subject</label>
                        <input type="text" class="form-control" id="inputSubject" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <label for="message">Bericht:</label>
                        <textarea class="form-control" rows="5" id="message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-lees-meer">Neem contact op</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection