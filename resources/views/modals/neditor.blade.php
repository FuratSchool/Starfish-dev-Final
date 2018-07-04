<div id="storyViewer" class="modal fade bs-example-modal-lg viewer" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
                <h4 class="modal-title"><b>{{$modalTitle}}</b></h4>
            </div>
            <div class="modal-body">
                <div class="row" id="storyFields">
                    <div class="col-md-12">
                        <div id="storyInput" class="form-control" lang="nl">{!! $modalBody !!}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-destroy" data-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>