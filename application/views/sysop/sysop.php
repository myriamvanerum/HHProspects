<!--Homepage for the SYSOP-->
<script type="text/javascript">
    $(document).ready(function () {
        getUsers();
    });
    
    // Get all users
    function getUsers() {
        $.ajax({type: "POST",
            url: site_url + "/Sysop/getUsers",
            data: {},
            async: false,
            success: function (result) {
                $("#users").html(result);
            }
        });
    }
    
    // Get a single user for modal
    function getUser($id) {
        $.ajax({type: "POST",
            url: site_url + "/Sysop/getUser/" + $id,
            async: false,
            success: function (result) {
                user = jQuery.parseJSON(result);
            }
        });
    }
    
    // Is this question used in any surveys?
    function isUserResponsibleAdmin($id) {
        $.ajax({type: "POST",
            url: site_url + "/Sysop/isUserResponsibleAdmin/" + $id,
            async: false,
            success: function (result) {
                userResponsible = jQuery.parseJSON(result);
            }
        });
    }
    
    $(document).on('click', '#insert', function () {
        alert("This functionality is still under development. It will be available at a later date.");
    });

    $(document).on('click', '.edit', function () {
        alert("This functionality is still under development. It will be available at a later date.");
    });
    
    // Delete user
    $(document).on('click', '.delete', function () {
        getUser($(this).attr('value'));
        isUserResponsibleAdmin($(this).attr('value'));
        fillDeleteModal();
        $('#modalDelete').modal('show');
    });

    function fillDeleteModal() {
        if (userResponsible === true)
        {
            // User cannot be deleted
            $("#modalDeleteLabel").html("Can\'t delete this user");
            $("#deleteText").html("The user <strong>\"" + user.first_name + " " + user.last_name + "\"</strong> cannot be deleted because one or more students still have him listed as the responsible administrator.");
            $("#deleteOK").hide();
            $("#deleteFail").show();
        } else {
            // Question OK to delete
            $("#modalDeleteLabel").html("Delete user");
            $("#deleteText").html("Are you sure you want to remove the user <strong>\"" + user.first_name + " " + user.last_name + "\"</strong>?");
            $("#deleteSave").attr('value', user.id);
            $("#deleteOK").show();
            $("#deleteFail").hide();
        }
    }

    $(document).on('click', '#deleteSave', function () {
        $.ajax({
            type: "POST",
            url: site_url + '/Sysop/deleteUser/' + $(this).prop('value'),
            data: {},
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });

        getUsers();
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">SYSOP Homepage</h1>
             <h3 class='col-sm-4'>User list</h3>
            <h3 class="text-right col-sm-8">
                <button class="btn btn-primary" id="insert"><span class="fa fa-user-plus"></span> Add a user</button>
            </h3>
            <div id="users"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- Delete user modal-->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalDeleteLabel"></h4> 
            </div>
            <div class="modal-body">
                <p id="deleteText"></p>
            </div>
            <div class="modal-footer">
                <div id="deleteOK">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" data-dismiss="modal" id="deleteSave" value="">Delete</button>
                </div>
                <div id="deleteFail">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>