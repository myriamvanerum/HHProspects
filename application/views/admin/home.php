<?php $user = $this->authex->getUserInfo(); ?>
<script type="text/javascript">
    // Get a single student for modal
    function getStudent($id) {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getStudent/" + $id,
            async: false,
            success: function (result) {
                student = jQuery.parseJSON(result);
            }
        });
    }

    // Get all students for table
    function getStudents() {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getStudents",
            data: {},
            async: false,
            success: function (result) {
                $("#students").html(result);
            }
        });
    }

    // Get all admins
    function getAdmins() {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getAdmins",
            data: {},
            async: false,
            success: function (result) {
                admins = jQuery.parseJSON(result);
            }
        });
    }
    
    // Get all groups
    function getGroups() {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getGroups",
            data: {},
            async: false,
            success: function (result) {
                groups = jQuery.parseJSON(result);
            }
        });
    }

    $(document).ready(function () {
        getStudents();
    });

    // View student
    $(document).on('click', '.view', function () {
        getStudent($(this).attr('value'));
        fillViewModal();
        $('#modalView').modal('show');
    });

    function fillViewModal() {
        $("#first_name").val(student.first_name);
        $("#last_name").val(student.last_name);
        $("#email").val(student.email);
        $("#person_number").val(student.person_number);
        $("#country").val(student.country);
        $("#admin").val(student.admin.first_name + " " + student.admin.last_name);
        $("#zip_code").val(student.zip_code);
        $("#language").val(student.language);
        $("#instruction_language").val(student.instruction_language);
        $("#application_number").val(student.application_number);
        $("#group").val(student.group.name);
    }

    // Insert student
    $(document).on('click', '#insert', function () {
        getAdmins();
        getGroups();
        fillInsertModal();
        $('#modalInsert').modal('show');

    });

    function fillInsertModal() {
        $("#insert_first_name").val('');
        $("#insert_last_name").val('');
        $("#insert_email").val('');
        $("#insert_person_number").val('');
        $("#insert_country").val('');
        $("#insert_admin").empty();
        combobox = document.getElementById("insert_admin");
        admins.forEach(function (admin) {
            option = document.createElement("option");
            option.text = admin.first_name + ' ' + admin.last_name;
            option.value = admin.id;
            combobox.appendChild(option);
        });
        $("#insert_admin").val(<?php echo $user->id; ?>);
        $("#insert_zip_code").val('');
        $("#insert_language").val('');
        $("#insert_instruction_language").val('');
        $("#insert_application_number").val('');
        $("#insert_group").empty();
        combobox = document.getElementById("insert_group");
        groups.forEach(function (group) {
            option = document.createElement("option");
            option.text = group.name;
            option.value = group.id;
            combobox.appendChild(option);
        });
    }

    $(document).on('click', '#insertSave', function () {
        $.ajax({
            type: "POST",
            url: site_url + '/Admin/insertStudent',
            data: {
                first_name: $("#insert_first_name").val(),
                last_name: $("#insert_last_name").val(),
                email: $("#insert_email").val(),
                person_number: $("#insert_person_number").val(),
                country: $("#insert_country").val(),
                admin_id: $("#insert_admin").val(),
                zip_code: $("#insert_zip_code").val(),
                language: $("#insert_language").val(),
                instruction_language: $("#insert_instruction_language").val(),
                application_number: $("#insert_application_number").val(),
                group_id: $("#insert_group").val()
            },
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });
        $('#modalInsert').modal('toggle');

        getStudents();

    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Administrator homepage</h1>
            <p class="text-right">
                <button class="btn btn-primary" id="insert"><span class="fa fa-user-plus"></span> Add a student</button>
                <?php echo anchor('Admin/importStudents', '<span class="fa fa-file-excel-o"></span> Import students', 'class="btn btn-primary"'); ?>
            </p>
            <div id="students"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- View student modal-->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalViewLabel">View student</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="first_name" class="col-sm-2 control-label">First name:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="first_name" placeholder="First name" readonly>
                        </div>
                        <label for="last_name" class="col-sm-2 control-label">Last name:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="last_name" placeholder="Last name" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="email" class="col-sm-2 control-label">E-mail:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="email" placeholder="E-mail" readonly>
                        </div>
                        <label for="admin" class="col-sm-2 control-label">Administrator:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="admin" placeholder="Responsible administrator" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="country" class="col-sm-2 control-label">Country:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="country" placeholder="Country" readonly>
                        </div>
                        <label for="zip_code" class="col-sm-2 control-label">ZIP Code:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="zip_code" placeholder="ZIP Code" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="person_number" class="col-sm-2 control-label">Person number:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="person_number" placeholder="Person number" readonly>
                        </div>
                        <label for="application_number" class="col-sm-2 control-label">Application number:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="application_number" placeholder="Application number" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="language" class="col-sm-2 control-label">Language:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="language" placeholder="Language" readonly>
                        </div>
                        <label for="instruction_language" class="col-sm-2 control-label">Instruction language:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="instruction_language" placeholder="Instruction language" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="group" class="col-sm-2 control-label">Group:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="group" placeholder="Group" readonly>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Insert student modal-->
<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="modalInsertLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalInsertLabel">Add new student</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="insert_first_name" class="col-sm-2 control-label">First name:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="insert_first_name" placeholder="First name" required>
                        </div>
                        <label for="insert_last_name" class="col-sm-2 control-label">Last name:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="insert_last_name" placeholder="Last name" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_email" class="col-sm-2 control-label">E-mail:</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="insert_email" placeholder="E-mail" required>
                        </div>
                        <label for="insert_admin" class="col-sm-2 control-label">Administrator:</label>
                        <div class="col-sm-4">
                            <select name="insert_admin" id="insert_admin" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_country" class="col-sm-2 control-label">Country:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="insert_country" placeholder="Country" required>
                        </div>
                        <label for="insert_zip_code" class="col-sm-2 control-label">ZIP Code:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="insert_zip_code" placeholder="ZIP Code" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_person_number" class="col-sm-2 control-label">Person number:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="insert_person_number" placeholder="Person number" pattern="[0-9]{6}-[0-9]{4}" required>
                        </div>
                        <label for="insert_application_number" class="col-sm-2 control-label">Application number:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="insert_application_number" placeholder="Application number" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_language" class="col-sm-2 control-label">Language:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="insert_language" placeholder="Language" required>
                        </div>
                        <label for="insert_instruction_language" class="col-sm-2 control-label">Instruction language:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="insert_instruction_language" placeholder="Instruction language" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_group" class="col-sm-2 control-label">Group:</label>
                        <div class="col-sm-4">
                            <select name="insert_group" id="insert_group" class="form-control">
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