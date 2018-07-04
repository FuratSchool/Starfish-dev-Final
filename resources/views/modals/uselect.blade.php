<style>
    .header-fixed {
        width: 100%
    }

    .header-fixed > thead,
    .header-fixed > tbody,
    .header-fixed > thead > tr,
    .header-fixed > tbody > tr,
    .header-fixed > thead > tr > th,
    .header-fixed > tbody > tr > td {
        display: block;
    }

    .header-fixed > tbody > tr:after,
    .header-fixed > thead > tr:after {
        content: ' ';
        display: block;
        visibility: hidden;
        clear: both;
    }

    .header-fixed > tbody {
        overflow-y: auto;
        height: 500px;
    }

    .header-fixed > tbody > tr > td,
    .header-fixed > thead > tr > th {
        width: calc(100%/6);
        float: left;
    }
</style>
<div id="selectUsers" class="modal fade" tabindex="-1" role="dialog"  data-keyboard="true" >
    <div class="modal-dialog modal-xl" role="document" style="max-height: 100%">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Leden kiezen</h2>
            </div>
            <div class="modal-body">
                <div class="row" id="storyFields">
                    <div class="col-md-12">
                            <table class="table header-fixed">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="toggleAll" title="Alle gebruikers"/></th>
                                        <th>Gebruikersnaam</th>
                                        <th>Voornaam</th>
                                        <th>Achternaam</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                    </tr>
                                </thead>
                                <tbody style="overflow-y: scroll !important;">
                                    @foreach($users as $user)
                                        <tr @if($user->id % 2 == 0) style="background: #414648" @endif>
                                            <td><input type="checkbox" data-group="members" name="members[]" title="Selecteren" value="{{$user->id}}" @if(isset($group))@if($user->inGroup($group)) checked @endif @endif></td>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->first_name}}</td>
                                            <td>{{$user->sur_name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>@if($user->is_admin == 1)
                                                    Standaard
                                                @elseif($user->is_admin == 2)
                                                    Mod
                                                @elseif($user->is_admin == 3)
                                                    Admin
                                                @elseif($user->is_admin == 4)
                                                    Webmaster
                                                @endif</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-new" id="contentSave" data-dismiss="modal">Opslaan</button>
            </div>
        </div>
    </div>
</div>