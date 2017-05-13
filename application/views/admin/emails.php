<?php $user = $this->authex->getUserInfo(); ?>
<script type="text/javascript">
    // Get a single template for modal
    function getEmailTemplate($id) {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getEmailTemplate/" + $id,
            async: false,
            success: function (result) {
                email = jQuery.parseJSON(result);
            }
        });
    }

    // Get all email_templates for table
    function getEmailTemplates() {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getEmailTemplates",
            data: {},
            async: false,
            success: function (result) {
                $("#emails").html(result);
            }
        });
    }

    // Get all groups
    function getGroups() {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getGroupsJSON",
            data: {},
            async: false,
            success: function (result) {
                groups = jQuery.parseJSON(result);
            }
        });
    }

    $(document).ready(function () {
        getEmailTemplates();
    });

    // View email_template
    $(document).on('click', '.view', function () {
        getEmailTemplate($(this).attr('value'));
        fillViewModal();
        $('#modalView').modal('show');
    });

    function fillViewModal() {
        $("#name").val(email.name);
        $("#subject").val(email.subject);
        $("#mail_content").val(email.content);
    }

    // Insert email_template
    $(document).on('click', '#insert', function () {
        fillInsertModal();
        $('#modalInsert').modal('show');

    });

    function fillInsertModal() {
        $("#insert_name").val('');
        $("#insert_mail_content").val('');
    }

    $(document).on('click', '#insertSave', function () {
        $.ajax({
            type: "POST",
            url: site_url + '/Admin/insertEmailTemplate',
            data: {
                name: $("#insert_name").val(),
                subject: $("#insert_subject").val(),
                content: $("#insert_mail_content").val()
            },
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });
        $('#modalInsert').modal('toggle');

        getEmailTemplates();

    });

    // Send email
    $(document).on('click', '.send', function () {
        getEmailTemplate($(this).attr('value'));
        getGroups();
        fillSendModal();
        $('#modalSend').modal('show');

    });

    function fillSendModal() {
        $("#send_name").val(email.name);
        $("#send_subject").val(email.subject);
        $("#send_mail_content").val(email.content);
        $("#send_group").empty();
        combobox = document.getElementById("send_group");
        groups.forEach(function (group) {
            option = document.createElement("option");
            option.text = group.name;
            option.value = group.id;
            combobox.appendChild(option);
        });
        
        $("#emailSend").attr('value', email.id);
    }

    $(document).on('click', '#emailSend', function () {
        $.ajax({
            type: "POST",
            url: site_url + '/Admin/sendEmail/' + $(this).prop('value'),
            data: {
                group_id: $("#send_group").val()
            },
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });
        $('#modalSend').modal('toggle');
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Administrator homepage</h1>
            <h3 class='col-sm-6'>E-mail templates</h3>
            <h3 class="text-right col-sm-6">
                <button class="btn btn-primary" id="insert"><span class="fa fa-plus"></span> Add a template</button>
            </h3>
            <div id="emails"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- View email_template modal-->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalViewLabel">View email template</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="name" class="col-sm-3 control-label">Template name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" placeholder="Template name" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="subject" class="col-sm-3 control-label">Subject:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="subject" placeholder="Subject" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <textarea rows="20" cols="40" id="mail_content" class="form-control" placeholder="Content" readonly style="resize:vertical"></textarea>
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

<!-- Insert email_template modal-->
<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="modalInsertLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalInsertLabel">Add new e-mail template</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="insert_name" class="col-sm-3 control-label">Template name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="insert_name" placeholder="Template name" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_subject" class="col-sm-3 control-label">Subject:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="insert_subject" placeholder="Subject" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <textarea rows="20" cols="40" id="insert_mail_content" class="form-control" placeholder="Content" style="resize:vertical"></textarea>
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

<!-- Send email modal-->
<div class="modal fade" id="modalSend" tabindex="-1" role="dialog" aria-labelledby="modalSendLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalSendLabel">Send e-mail</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="send_group" class="col-sm-3 control-label">Group:</label>
                        <div class="col-sm-9">
                            <select name="send_group" id="send_group" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="send_name" class="col-sm-3 control-label">Template name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="send_name" placeholder="Template name" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="send_subject" class="col-sm-3 control-label">Subject:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="send_subject" placeholder="Subject" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <textarea rows="20" cols="40" id="send_mail_content" class="form-control" placeholder="Content" readonly style="resize:vertical"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"  id="emailSend">Send</button>
            </div>
        </div>
    </div>
</div>