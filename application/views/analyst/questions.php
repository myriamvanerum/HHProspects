<?php $user = $this->authex->getUserInfo(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        getQuestions();
    });

    // Get a single question for modal
    function getQuestion($id) {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getQuestion/" + $id,
            async: false,
            success: function (result) {
                question = jQuery.parseJSON(result);
            }
        });
    }

    // Is this question used in any surveys?
    function isQuestionUsedInSurvey($id) {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/isQuestionUsedInSurvey/" + $id,
            async: false,
            success: function (result) {
                questionUsed = jQuery.parseJSON(result);
            }
        });
    }

    // Get all questions for table
    function getQuestions() {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getQuestions",
            data: {},
            async: false,
            success: function (result) {
                $("#questions").html(result);
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

    // View question
    $(document).on('click', '.view', function () {
        getQuestion($(this).attr('value'));
        fillViewModal();
        $('#modalView').modal('show');
    });

    function fillViewModal() {
        $("#title").val(question.title);
        $("#question_type").val(question.question_type.name);
        $("#description").val(question.description);
        $("#question").val(question.text);
        if ((question.answer_options).length === 0)
        {
            $("#answer_options_div").hide();
        } else
        {
            $("#answer_options_div").show();
            $("#answer_options").empty();
            $.each(question.answer_options, function (index, value) {
                $("#answer_options").append("<li class='list-group-item'>" + value + "</li>");
            });
        }
    }

    // Insert question
    $(document).on('click', '#insert', function () {
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

        getQuestions();
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

    // Delete question
    $(document).on('click', '.delete', function () {
        getQuestion($(this).attr('value'));
        isQuestionUsedInSurvey($(this).attr('value'));
        fillDeleteModal();
        $('#modalDelete').modal('show');
    });

    function fillDeleteModal() {
        if (questionUsed === true)
        {
            // Question caanot be deleted
            $("#modalDeleteLabel").html("Can\'t delete this question");
            $("#deleteText").html("The question <strong>\"" + question.text + "\"</strong> cannot be deleted because a survey still uses this question.");
            $("#deleteOK").hide();
            $("#deleteFail").show();
        } else {
            // Question OK to delete
            $("#modalDeleteLabel").html("Delete question");
            $("#deleteText").html("Are you sure you want to remove the question <strong>\"" + question.text + "\"</strong>?");
            $("#deleteSave").attr('value', question.id);
            $("#deleteOK").show();
            $("#deleteFail").hide();
        }
    }

    $(document).on('click', '#deleteSave', function () {
        $.ajax({
            type: "POST",
            url: site_url + '/Analyst/deleteQuestion/' + $(this).prop('value'),
            data: {},
            async: false,
            success: function (data) {
                console.log("success:", data);
            }
        });

        getQuestions();
    });


</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Analyst homepage</h1>
            <h3 class='col-sm-4'>Question list</h3>
            <h3 class="text-right col-sm-8">
                <button class="btn btn-primary" id="insert"><span class="fa fa-plus"></span> Add a question</button>
            </h3>
            <div id="questions"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- View question modal-->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalViewLabel">View question</h4> 
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row form-group">
                        <label for="title" class="col-sm-3 control-label">Title:</label>
                        <div class="col-sm-9">
                            <input type="input" class="form-control" id="title" placeholder="Title" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="question_type" class="col-sm-3 control-label">Question type:</label>
                        <div class="col-sm-9">
                            <input type="input" class="form-control" id="question_type" placeholder="Question type" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="description" class="col-sm-3 control-label">Description:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" placeholder="Description" readonly>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="question" class="col-sm-3 control-label">Question:</label>
                        <div class="col-sm-9">
                            <textarea rows="3" cols="40" id="question" class="form-control" placeholder="Question" readonly style="resize:none"></textarea>
                        </div>
                    </div>
                    <div class="row form-group" id="answer_options_div">
                        <h4 class="col-sm-12">Answer options</h4>
                        <div class="col-sm-12">
                            <ul id="answer_options" class="list-group"></ul>
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

<!-- Delete question modal-->
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