<!--Admin page to manage groups-->
<?php $user = $this->authex->getUserInfo(); ?>
<script type="text/javascript">
    // Get a single group for modal
    function getGroup($id) {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getGroup/" + $id,
            async: false,
            success: function (result) {
                group = jQuery.parseJSON(result);
            }
        });
    }

    // Get all groups for table
    function getGroups() {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getGroups",
            data: {},
            async: false,
            success: function (result) {
                $("#groups").html(result);
            }
        });
    }

    $(document).ready(function () {
        getGroups();
    });

    // Insert group
    $(document).on('click', '#insert', function () {
        fillInsertGroupModal();
        $('#modalInsert').modal('show');

    });

    function fillInsertGroupModal() {
        $("#insert_name").val('');
    }

    $(document).on('click', '#insertSave', function () {
        $.ajax({
            type: "POST",
            url: site_url + '/Admin/insertGroup',
            data: {
                name: $("#insert_name").val()
            },
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });
        $('#modalInsert').modal('toggle');

        getGroups();

    });

    // Edit group
    $(document).on('click', '.edit', function () {
        getGroup($(this).attr('value'));
        fillEditModal();
        $('#modalEdit').modal('show');
    });

    function fillEditModal() {
        $("#edit_name").val(group.name);
        $("#editSave").attr('value', group.id);
    }

    $(document).on('click', '#editSave', function () {
        $.ajax({
            type: "POST",
            url: site_url + '/Admin/updateGroup/' + $(this).prop('value'),
            data: {
                name: $("#edit_name").val()
            },
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });
        $('#modalEdit').modal('toggle');

        getGroups();
    });

    // Delete group
    $(document).on('click', '.delete', function () {
        getGroup($(this).attr('value'));
        fillDeleteModal();
        $('#modalDelete').modal('show');
    });

    function fillDeleteModal() {
        $("#deleteText").html("Are you sure you want to remove <strong>\"" + group.name + "\"</strong>?");
        $("#deleteSave").attr('value', group.id);
    }

    $(document).on('click', '#deleteSave', function () {
        $.ajax({
            type: "POST",
            url: site_url + '/Admin/deleteGroup/' + $(this).prop('value'),
            data: {},
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });

        getGroups();
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Administrator page</h1>
            <h3 class='col-sm-6'>Groups</h3>
            <h3 class="text-right col-sm-6">
                <button class="btn btn-primary" id="insert"><span class="fa fa-plus"></span> Add a group</button>
            </h3>
            <div id="groups"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- Insert group modal-->
<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="modalInsertLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalInsertLabel">Add a new group</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="insert_name" class="col-sm-3 control-label">Group name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="insert_name" placeholder="Group name" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"  id="insertSave">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit group modal-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalEditLabel">Edit group</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="edit_name" class="col-sm-3 control-label">Group name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_name" placeholder="Group name" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"  id="editSave">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete group modal-->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalDeleteLabel">Delete group</h4> 
            </div>
            <div class="modal-body">
                <p id="deleteText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger" data-dismiss="modal" id="deleteSave" value="">Delete</button>
            </div>
        </div>
    </div>
</div>