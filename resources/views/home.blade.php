@extends('base')
@section('title', 'Home')
@section('home_url', route('landing'))
@section('main')
    @if(session()->has('error'))
        <div class="alert alert-info">
            <h4>{{ session()->get('msg') }}</h4>
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <h2>Welkom!</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec diam quis lectus aliquet mattis tristique vel dui. In arcu ante, placerat nec vehicula nec, viverra vel lacus. Vestibulum sit amet nulla luctus elit dictum porta. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed suscipit eget arcu nec dapibus. Vestibulum in eros at nibh fermentum aliquet. Proin fringilla porta elementum. Suspendisse feugiat sed augue eget mollis. Sed a felis congue, dapibus magna eu, mollis libero.
            </p>
            <p>
                Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur ultrices auctor hendrerit. Aenean sodales justo id porttitor fermentum. Nulla facilisi. Vivamus hendrerit justo fermentum nulla mattis, in sodales tellus rutrum. Suspendisse sit amet commodo urna. Sed hendrerit blandit porttitor. Phasellus euismod ornare quam ut consectetur. Mauris sapien lorem, scelerisque nec rutrum eu, suscipit sit amet sem. Etiam tempus sit amet libero fermentum mollis. Ut et scelerisque nibh. Morbi molestie viverra nulla vulputate ultricies. Praesent volutpat sed leo posuere mollis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </p>
            <p>
                In elementum sodales odio quis laoreet. Cras in tempor elit, quis tempor orci. Nulla at scelerisque lectus. Nullam vel lectus vel orci euismod euismod. Ut consectetur ante magna, sed lacinia tortor varius sit amet. Integer sagittis vehicula odio quis semper. Aenean libero lorem, pellentesque eget mattis at, cursus vel eros. Vestibulum laoreet, lectus vel porttitor pulvinar, nisi nibh semper dolor, sed suscipit enim sapien sit amet est. Cras porttitor venenatis sapien, porttitor elementum mi tincidunt id. Donec vel mollis risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque metus enim, vestibulum sit amet facilisis nec, sollicitudin et justo. Phasellus dapibus semper erat, ut varius enim pretium eu.
            </p>
            <p>
                Mauris convallis efficitur nulla sit amet gravida. Nullam vitae libero vitae massa ultrices aliquet. Donec dignissim odio vel tincidunt dictum. Duis in vestibulum erat. Donec commodo vel augue ac fringilla. Mauris nec arcu dui. Phasellus vel rutrum magna. Curabitur quis eros faucibus, hendrerit ipsum ac, pulvinar orci. Cras iaculis volutpat libero ac aliquet. Aenean lorem nibh, aliquam eget faucibus vel, gravida vel eros. Cras erat sem, tincidunt ut sodales vitae, posuere id justo. In faucibus sem quis metus hendrerit, vitae tincidunt odio euismod.
            </p>
            <p>
                Aliquam scelerisque lacus ac venenatis vestibulum. Curabitur aliquet diam ut euismod sagittis. Fusce vel ex quam. Phasellus sollicitudin, enim vitae ultricies molestie, diam lorem lacinia lectus, ac volutpat eros ante in sem. Mauris libero dolor, suscipit in eleifend nec, bibendum aliquam odio. Duis venenatis nibh a urna suscipit dapibus. Ut sodales tellus vitae orci porttitor, a efficitur felis feugiat. Donec in lacus a felis lobortis dignissim. Fusce dictum vestibulum nulla aliquet sagittis. Sed ac mi quam. Integer tincidunt turpis lobortis mauris tempor, quis viverra nulla porttitor. Cras egestas, ex a aliquam lacinia, velit urna faucibus justo, a varius neque mauris a diam.
            </p>
        </div>
        <div class="hidden-xs hidden-sm col-md-4">
            <img class="fullwidth" src="{{ asset('/images/logo.png') }}"/>
        </div>
    </div>
@endsection