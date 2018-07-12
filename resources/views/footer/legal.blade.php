@extends('layouts.master')
@section('title')
@endsection
@section('styles')
    @parent
@endsection
@section('main')
    <section class="first-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="list-group">
                            <a href="{{route('legal')}}" class="list-group-item list-group-item-action active">
                                Legal
                            </a>
                            <a href="{{route('faqs')}}" class="list-group-item list-group-item-action">Faqs</a>
                            <a href="{{route('helpcentre')}}" class="list-group-item list-group-item-action">Partner Help Centre</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title Starfish-Logo-with-text-blue">Legal</h5>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @parent
@endsection