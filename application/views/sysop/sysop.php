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
    
    // Get all user levels
    function getUserLevels() {
        $.ajax({type: "POST",
            url: site_url + "/Sysop/getUserLevels",
            data: {},
            async: false,
            success: function (result) {
                userLevels = jQuery.parseJSON(result);
            }
        });
    }
    
    // Insert user
    $(document).on('click', '#insert', function () {
        getUserLevels();
        fillInsertModal();
        $('#modalInsert').modal('show');

    });

    function fillInsertModal() {
        $("#insert_first_name").val('');
        $("#insert_last_name").val('');
        $("#insert_email").val('');
        $("#insert_user_level").empty();
        combobox = document.getElementById("insert_user_level");
        userLevels.forEach(function (userLevel) {
            option = document.createElement("option");
            option.text = userLevel.name;
            option.value = userLevel.id;
            combobox.appendChild(option);
        });
    }

    $(document).on('click', '#insertSave', function () {
        $.ajax({
            type: "POST",
            url: site_url + '/Sysop/insertUser',
            data: {
                first_name: $("#insert_first_name").val(),
                last_name: $("#insert_last_name").val(),
                email: $("#insert_email").val(),
                level: $("#insert_user_level").val()
            },
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });
        $('#modalInsert').modal('toggle');

        getUsers();

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

<!-- Insert user modal-->
<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="modalInsertLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalInsertLabel">Add new user</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="insert_first_name" class="col-sm-2 control-label">First name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="insert_first_name" placeholder="First name" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_last_name" class="col-sm-2 control-label">Last name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="insert_last_name" placeholder="Last name" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_email" class="col-sm-2 control-label">E-mail:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="insert_email" placeholder="E-mail" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_admin" class="col-sm-2 control-label">User level:</label>
                        <div class="col-sm-10">
                            <select name="insert_user_level" id="insert_user_level" class="form-control">
                            </select>
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