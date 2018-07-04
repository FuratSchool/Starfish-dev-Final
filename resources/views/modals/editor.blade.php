<div id="storyEditor" class="modal fade bs-example-modal-lg editor" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b> </b></h4>
            </div>
            <div class="modal-body">
                <div class="modal-toolbar">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-action btn-lg" id="heading1" style="font-family: 'Times New Roman',serif; font-weight: 700">H1</button>
                            <button type="button" class="btn btn-action btn-lg" id="heading2" style="font-family: 'Times New Roman',serif; font-weight: 700">H2</button>
                            <button type="button" class="btn btn-action btn-lg" id="heading3" style="font-family: 'Times New Roman',serif; font-weight: 700">H3</button>
                            <button type="button" class="btn btn-action btn-lg" id="heading4" style="font-family: 'Times New Roman',serif; font-weight: 700">H4</button>
                            <button type="button" class="btn btn-action btn-lg" id="heading5" style="font-family: 'Times New Roman',serif; font-weight: 700">H5</button>
                            <button type="button" class="btn btn-action btn-lg" id="heading6" style="font-family: 'Times New Roman',serif; font-weight: 700">H6</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-action btn-lg" id="styleBold"><i class="fa fa-bold" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-action btn-lg" id="styleItalic"><i class="fa fa-italic" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-action btn-lg" id="styleUnderlined"><i class="fa fa-underline" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-action btn-lg" id="styleStrikethrough"><i class="fa fa-strikethrough" aria-hidden="true"></i></button>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="insertParagraph" class="btn btn-action btn-lg" type="button"><i class="fa fa-paragraph" aria-hidden="true"></i></button>
                            <button id="insertLine" class="btn btn-action btn-lg" type="button"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-action btn-lg" id="textLeft"><i class="fa fa-align-left" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-action btn-lg" id="textCenter"><i class="fa fa-align-center" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-action btn-lg" id="textRight"><i class="fa fa-align-right" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-action btn-lg" id="textJustify"><i class="fa fa-align-justify" aria-hidden="true"></i></button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-action btn-lg" id="listOrdered"><i class="fa fa-list-ol" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-action btn-lg" id="listUnordered"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-action btn-lg" id="listIndent"><i class="fa fa-indent" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-action btn-lg" id="listOutdent"><i class="fa fa-outdent" aria-hidden="true"></i></button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-action btn-lg" id="createLink"><i class="fa fa-link" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row" id="storyFields">
                    <div class="col-md-12">
                        <div contenteditable="true" id="storyInput" class="form-control" lang="nl"></div>
                        <p class="text-right"><span id="charWarning"></span><span id="charCount">2000</span> / 2000</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-destroy" id="clearContent">Wissen</button>
                <button type="button" class="btn btn-new" id="contentSave">Opslaan</button>
            </div>
        </div>
    </div>
</div>