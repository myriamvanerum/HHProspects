<script type="text/javascript">
    // Get all groups
    function getGroups() {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getGroups",
            data: {},
            async: false,
            success: function (result) {
                groups = jQuery.parseJSON(result);
            }
        });
    }

    $(document).ready(function () {
        getGroups();
        fillGroups();
    });

    function fillGroups() {
        combobox = document.getElementById("group");
        groups.forEach(function (group) {
            option = document.createElement("option");
            option.text = group.name;
            option.value = group.id;
            combobox.appendChild(option);
        });
    }

    // Add questions
    $(document).on('click', '#addQuestion', function () {
        getAddQuestions("");
        $('#modalAdd').modal('show');
    });

    function getAddQuestions(searchString) {
        var questionIds = new Array();
        
        // don't show questions that have already been added
        $("#questions .questionRow").each(function () {
            questionIds.push($(this).attr('value'));
        });
        
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getAddQuestions",
            data: {
                searchString: searchString,
                questionIds: questionIds
                },
            async: false,
            success: function (result) {
                $("#add_questions").html(result);
            }
        });

    }

    $(function () {
        $('#searchQuestion').keyup(function () {
            getAddQuestions($(this).val());
        });
    });

    $(document).on('click', '#addSave', function () {
        var questionIds = new Array();

        // see which questions the user want to add
        $("#add_questions input:checked").each(function () {
            questionIds.push($(this).attr('id'));
        });
        
        // see which questions were already added
        $("#questions .questionRow").each(function () {
            questionIds.push($(this).attr('value'));
        });
        
        showSurveyQuestions(questionIds);

        $('#modalAdd').modal('toggle');
    });
    
    function showSurveyQuestions(questionIds) {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/showAddedQuestions",
            data: {questionIds: questionIds},
            async: false,
            success: function (result) {
                $("#questions").html(result);
            }
        });
    }
    
    // Delete question from survey
    $(document).on('click', '.delete', function () {
        var questionIds = new Array();
        
        // see which questions were already added
        $("#questions .questionRow").each(function () {
            questionIds.push($(this).attr('value'));
        });
        
        // remove the question that was selected
        questionIds.splice( $.inArray($(this).attr('value'), questionIds), 1);
        
        showSurveyQuestions(questionIds);
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">New survey</h1>
        </div>
    </div>
    <?php
    $attributes = array('name' => 'newSurveyForm');
    echo form_open('Analyst/insertSurvey', $attributes);
    ?>
    <div class="row form-group">
        <label for="name" class="col-sm-2 control-label">Name:</label>
        <div class="col-sm-10">
            <input type="input" class="form-control" id="name" name="name" placeholder="Name" required>
        </div>
    </div>
    <div class="row form-group">
        <label for="group" class="col-sm-2 control-label">Group:</label>
        <div class="col-sm-10">
            <select name="group" id="group" name="group" class="form-control"></select>
        </div>
    </div>
    <div class="row form-group">
        <label for="description" class="col-sm-2 control-label">Description:</label>
        <div class="col-sm-10">
            <textarea rows="3" cols="40" id="description" name="description" class="form-control" placeholder="Description" required style="resize:none"></textarea>
        </div>
    </div>
    <div class="row form-group">
        <label for="comment" class="col-sm-2 control-label">Comment:</label>
        <div class="col-sm-10">
            <textarea rows="3" cols="40" id="comment" name="comment" class="form-control" placeholder="Comment" required style="resize:none"></textarea>
        </div>
    </div>
    <div class="row form-group">
        <label for="starts_on" class="col-sm-2 control-label">Starts on:</label>
        <div class="col-sm-4">
            <input type="date" class="form-control" id="starts_on" name="starts_on" placeholder="Starts on" required >
        </div>
        <label for="ends_on" class="col-sm-2 control-label">Ends on:</label>
        <div class="col-sm-4">
            <input type="date" class="form-control" id="ends_on" name="ends_on" placeholder="Ends on" required>
        </div>
    </div>
    <div class="row" id="questions_div">
        <h4 class="col-sm-12">Questions <a class="btn btn-primary pull-right" id="addQuestion"><span class="fa fa-plus"></span> Add questions</a></h4>
        <div class="col-sm-12" id="questions">
            You haven't added any questions to this survey yet.<br><br>
        </div>
    </div>
    <?php
    echo form_submit('formSubmit', 'Submit', "class='btn btn-primary'");
    echo anchor('Analyst', 'Cancel', 'class="btn btn-default"');
    echo form_close();
    ?>
</div>

<!-- View survey modal-->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalAddLabel">Add questions</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal row">
                    <div class="col-sm-9">
                        <input type="input" class="form-control" id="searchQuestion" placeholder="Search for a specific question">
                    </div>
                    <div class="col-sm-3">
                        <a class="btn btn-primary pull-right" id="newQuestion"><span class="fa fa-plus"></span> Add a new question</a>
                    </div>
                    <div class="col-sm-12" id="add_questions">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"  id="addSave">Send</button>
            </div>
        </div>
    </div>
</div>
