<?php $user = $this->authex->getUserInfo(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        getSurveys();
    });

    // Get a single survey for modal
    function getSurvey($id) {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getSurvey/" + $id,
            async: false,
            success: function (result) {
                survey = jQuery.parseJSON(result);
            }
        });
    }

    // Get all surveys for table
    function getSurveys() {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getSurveys",
            data: {},
            async: false,
            success: function (result) {
                $("#surveys").html(result);
            }
        });
    }

    // View survey
    $(document).on('click', '.view', function () {
        getSurvey($(this).attr('value'));
        fillViewModal();
        $('#modalView').modal('show');
    });

    function fillViewModal() {
        $("#name").val(survey.name);
        $("#group").val(survey.group.name);
        $("#description").val(survey.description);
        $("#comment").val(survey.comment);
        $("#created_on").val(survey.created_on);
        $("#used_on").val(survey.used_on);
        $("#starts_on").val(survey.starts_on);
        $("#ends_on").val(survey.ends_on);
    }
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Analyst homepage</h1>
            <h3 class='col-sm-4'>Survey list</h3>
            <h3 class="text-right col-sm-8">
                <button class="btn btn-primary" id="insert"><span class="fa fa-plus"></span> Add a survey</button>
            </h3>
            <div id="surveys"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- View survey modal-->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalViewLabel">View survey</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="name" class="col-sm-3 control-label">Name:</label>
                        <div class="col-sm-9">
                            <input type="input" class="form-control" id="name" placeholder="Name" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="group" class="col-sm-3 control-label">Group:</label>
                        <div class="col-sm-9">
                            <input type="input" class="form-control" id="group" placeholder="Group" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="description" class="col-sm-3 control-label">Description:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" placeholder="Description" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="comment" class="col-sm-3 control-label">Comment:</label>
                        <div class="col-sm-9">
                            <textarea rows="3" cols="40" id="comment" class="form-control" placeholder="Comment" readonly style="resize:none"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="created_on" class="col-sm-2 control-label">Created on:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="created_on" placeholder="Created on" readonly>
                        </div>
                        <label for="used_on" class="col-sm-2 control-label">Last used on:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="used_on" placeholder="Last used on" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="starts_on" class="col-sm-2 control-label">Starts on:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="starts_on" placeholder="Starts on" readonly>
                        </div>
                        <label for="ends_on" class="col-sm-2 control-label">Ends on:</label>
                        <div class="col-sm-4">
                            <input type="input" class="form-control" id="ends_on" placeholder="Ends on" readonly>
                        </div>
                    </div>
                    <div class="row" id="questions_div">
                        <h4 class="col-sm-12">Questions</h4>
                        <div class="col-sm-12">
                            <ul id="questions" class="list-group"></ul>
                        </div>
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Panel heading</div>

                            <!-- List group -->
                            <ul class="list-group">
                                <li class="list-group-item">Cras justo odio</li>
                                <li class="list-group-item">Dapibus ac facilisis in</li>
                                <li class="list-group-item">Morbi leo risus</li>
                                <li class="list-group-item">Porta ac consectetur ac</li>
                                <li class="list-group-item">Vestibulum at eros</li>
                            </ul>
                        </div>
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