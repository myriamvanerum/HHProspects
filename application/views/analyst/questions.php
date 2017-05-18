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
        }
        else
        {
            $("#answer_options_div").show();
            $("#answer_options").empty();
            $.each(question.answer_options, function(index, value) {
                $("#answer_options").append("<li class='list-group-item'>" + value + "</li>");
            });
        }
    }
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