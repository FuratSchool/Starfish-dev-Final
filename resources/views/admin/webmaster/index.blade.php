@extends('layouts.admin')
@section('styles')
    @parent

@endsection
@section('title')
    Webmaster
@endsection
@section('main')
    <div class="cbox-fluid">
        <div class="btitle">Batch uploads</div>
        <hr class="bdivider">
        <div class="bcontent">
            <form method="POST" action="{{route("admin.webmaster.batch")}}" id="batchform" role="form" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="batch_file">Bestand:</label>
                    <input id="batch_file" type="file"  name="batch_file" accept="*.xlsx">
                    <small class="help-block">Alleen .xlsx bestanden</small>
                </div>
                <div class="loader loader--style2 center-block" title="1" style="display: none">
                    <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 50 50" style="enable-background:new 0 0 50 50; width: 150px" xml:space="preserve">
  <path fill="#fff" d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z">
      <animateTransform attributeType="xml"
                        attributeName="transform"
                        type="rotate"
                        from="0 25 25"
                        to="360 25 25"
                        dur="0.3s"
                        repeatCount="indefinite"></animateTransform>
  </path>
                    </svg>
                    <small class="help-block">Dit kan even duren</small>
                </div>
                <div class="form-group">
                    <button id="batchsubmit" type="submit" class="btn btn-edit form-control" style="margin-left: 0 !important;">Uploaden</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script type="application/javascript">
        $(document).ready(function () {
            $("#batchsubmit").click(function () {
                $(".loader").show();
            });
        });
    </script>
    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function(){--}}
            {{--$("#batchsubmit").on("click", function(e) {--}}
                {{--e.preventDefault();--}}
                {{--$('progress').show();--}}
                {{--$.ajax({--}}
                    {{--url: '/admin/webmaster/batch',--}}
                    {{--type: 'POST',--}}
                    {{--mimeType: "multipart/form-data",--}}
                    {{--headers: {--}}
                        {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                    {{--},--}}
                    {{--data: new FormData($('#batchform')[0]),--}}
                    {{--cache: false,--}}
                    {{--contentType: false,--}}
                    {{--processData: false,--}}
                    {{--success: function(filename) // A function to be called if request succeeds--}}
                    {{--{--}}
                        {{--alert("success! "+filename+" uplaoded")--}}
                    {{--}--}}
                {{--}).done(function(){--}}
                    {{--console.log("Success: Files sent!");--}}
                {{--}).fail(function(){--}}
                    {{--console.log("An error occurred, the files couldn't be sent!");--}}
                {{--});--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}
@endsection
