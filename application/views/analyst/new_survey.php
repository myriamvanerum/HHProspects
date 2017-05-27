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
    
    // Get all question_types
    function getQuestionTypes() {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getQuestionTypes",
            data: {},
            async: false,
            success: function (result) {
                question_types = jQuery.parseJSON(result);
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
    
    // Insert question
    $(document).on('click', '#newQuestion', function () {
        $('#modalAdd').modal('toggle');
        getQuestionTypes();
        fillInsertModal();
        $('#modalInsert').modal('show');

    });

    function fillInsertModal() {
        $("#insert_title").val('');
        $("#insert_question_type").empty();
        combobox = document.getElementById("insert_question_type");
        question_types.forEach(function (question_type) {
            option = document.createElement("option");
            option.text = question_type.name;
            option.value = question_type.id;
            combobox.appendChild(option);
        });
        $("#insert_description").val('');
        $("#insert_question").val('');
        $("#insert_answer_options").empty();
    }

    $(document).on('click', '#insertSave', function () {
        var answer_options = new Array();

        $("#insert_answer_options li").each(function (index) {
            answer_options.push($(this).text());
        });

        $.ajax({
            type: "POST",
            url: site_url + '/Analyst/insertQuestion',
            data: {
                title: $("#insert_title").val(),
                question_type: $("#insert_question_type").val(),
                description: $("#insert_description").val(),
                question: $("#insert_question").val(),
                answer_options: answer_options
            },
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });
        $('#modalInsert').modal('toggle');
        
        getAddQuestions("");
        $('#modalAdd').modal('show');
    });

    // Insert answer_option
    $(document).on('click', '#insertAnswerOption', function () {
        $("#insert_answer_option_name").val('');
        $('#modalInsertAnswerOption').modal('show');

    });

    $(document).on('click', '#insertAnswerOptionSave', function () {
        $("#insert_answer_options").append("<li class='list-group-item'>" + $("#insert_answer_option_name").val() + "</li>");
        $('#modalInsertAnswerOption').modal('toggle');
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
            <select id="group" name="group" class="form-control"></select>
        </div>
    </div>
    <div class="row form-group">
        <label for="description" class="col-sm-2 control-label">Description:</label>
        <div class="col-sm-10">
            <textarea rows="3" cols="40" id="description" name="description" class="form-control" placeholder="Description" style="resize:none"></textarea>
        </div>
    </div>
    <div class="row form-group">
        <label for="comment" class="col-sm-2 control-label">Comment:</label>
        <div class="col-sm-10">
            <textarea rows="3" cols="40" id="comment" name="comment" class="form-control" placeholder="Comment" style="resize:none"></textarea>
        </div>
    </div>
    <div class="row form-group">
        <label for="starts_on" class="col-sm-2 control-label">Starts on:</label>
        <div class="col-sm-4">
            <input type="date" class="form-control" id="starts_on" name="starts_on" placeholder="Starts on" required>
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

<!-- insert question modal-->
<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="modalInsertLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalInsertLabel">Add question</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="insert_title" class="col-sm-3 control-label">Title:</label>
                        <div class="col-sm-9">
                            <input type="input" class="form-control" id="insert_title" placeholder="Title" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_question_type" class="col-sm-3 control-label">Question type:</label>
                        <div class="col-sm-9">
                            <select name="question_type" id="insert_question_type" class="form-control"></select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_description" class="col-sm-3 control-label">Description:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="insert_description" placeholder="Description" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="insert_question" class="col-sm-3 control-label">Question:</label>
                        <div class="col-sm-9">
                            <textarea rows="3" cols="40" id="insert_question" class="form-control" placeholder="Question" required style="resize:none"></textarea>
                        </div>
                    </div>
                    <div class="row form-group" id="insert_answer_options_div">
                        <h4 class="col-sm-4">Answer options</h4>
                        <h4 class="text-right col-sm-8">
                            <span class="btn btn-primary" id="insertAnswerOption"><span class="fa fa-plus"></span> Add an answer option</span>
                        </h4>
                        <div class="col-sm-12">
                            <ul id="insert_answer_options" class="list-group"></ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"  id="insertSave">Send</button>
            </div>
        </div>
    </div>
</div>

<!-- insert answer_option modal-->
<div class="modal fade" id="modalInsertAnswerOption" tabindex="-1" role="dialog" aria-labelledby="modalInsertAnswerOptionLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalInsertAnswerOptionLabel">Add answer option</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="insert_answer_option_name" class="col-sm-3 control-label">Name:</label>
                        <div class="col-sm-9">
                            <input type="input" class="form-control" id="insert_answer_option_name" placeholder="Title" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"  id="insertAnswerOptionSave">Save</button>
            </div>
        </div>
    </div>
</div>
