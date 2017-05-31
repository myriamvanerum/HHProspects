<!--Student page-->
<?php $survey = current($surveys); ?>
<?php $student = $this->authex->getStudentInfo(); ?>
<script type="text/javascript">
    // Submit survey
    $(document).on('click', '#formSubmit', function () {
        var questions = new Array();
        var chosen_answers = new Array();
        chosen_answers = [0];

        // loop through all the questions in this survey
        $(".panel-body").each(function (index) {
            var question = new Object();
            question.id = $(this).attr('id');
            question.answer_or_comment = $(this).find("#comment" + question.id).val();
            
            if ($(this).find("#date_answer" + question.id).val() != null) {
                question.date_answer = $(this).find("#date_answer" + question.id).val();
            } else {
                question.date_answer = null;
            }

            // loop through all the possible answer_options for this question, and see if they are selected or not 
            $(this).find(".answer" + question.id).each(function (index) {
                if ($(this).is(":checked") || $(this).is(":selected"))
                {
                    chosen_answers.push($(this).val());
                }
            });
            
            question.chosen_answers = chosen_answers;
            chosen_answers = [0];

            questions.push(question);
        });

        // save the results to the database
        $.ajax({
            type: "POST",
            url: site_url + '/Student/sendSurvey',
            data: {
                questions: questions
            },
            async: false,
            success: function (data) {
                window.location.replace("<?php echo site_url('Student'); ?>");
            },
            error: function(data){
                console.log("error:", data);
            }
        });
    });
    
    // Clear radio buttons
    $(document).on('click', '.clear', function () {
        $(this).parent().find('input').attr('checked',false);
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $survey->name; ?></h1>
            <p>Welcome <?php echo $student->first_name . " " . $student->last_name; ?>!</p>
            <p>Please fill out this survey for Halmstad University Prospects.</p>
            <p>You can change your answers until <?php echo date('d F Y', strtotime($survey->ends_on)) . " at " . date('H:i:s', strtotime($survey->ends_on)); ?>.</p>
            <?php
            if ($success === 1) {
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong>Success!</strong> Your answers were saved. You can now log out.
                        </div>
                    </div>
                </div>
                <?php
            }
            foreach ($survey->questions as $question) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $question->text ?></div>
                    <div class="panel-body" id="<?php echo $question->id; ?>">
                        <?php
                        switch ($question->question_type->id) {
                            case 1:
                                // Checkbox
                                foreach ($question->answer_options as $answer_option) {
                                    ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" class="answer<?php echo $question->id; ?>" name="question<?php echo $question->id; ?>" value="<?php echo $answer_option->id; ?>" <?php echo ($answer_option->chosen == TRUE) ? 'checked=""' : ''; ?>><?php echo $answer_option->answer; ?></label>
                                    </div>
                                    <?php
                                }
                                break;
                            case 2:
                                // Text
                                break;
                            case 3:
                            case 5:
                            case 6:
                                // Radio, Yes/No, True/False
                                foreach ($question->answer_options as $answer_option) {
                                    ?>
                                    <div class="radio">
                                        <label><input type="radio" class="answer<?php echo $question->id; ?>" name="question<?php echo $question->id; ?>" value="<?php echo $answer_option->id; ?>" <?php echo ($answer_option->chosen == TRUE) ? 'checked=""' : ''; ?>><?php echo $answer_option->answer; ?></label>
                                    </div>
                                    <?php
                                }
                                ?>
                                <button class='btn btn-default clear'>Clear</button>
                                <br><br>
                                <?php
                                break;
                            case 4:
                                // Dropdown
                                ?>
                                <select class="form-control" name="question<?php echo $question->id; ?>">
                                    <?php
                                    foreach ($question->answer_options as $answer_option) {
                                        ?>
                                        <option class='answer<?php echo $question->id; ?>' value="<?php echo $answer_option->id; ?>" <?php echo ($answer_option->chosen == TRUE) ? 'selected=""' : ''; ?>><?php echo $answer_option->answer; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <br>
                                <?php
                                break;
                            case 7:
                                // Date
                                ?>
                                <input type="date" class="form-control" id="date_answer<?php echo $question->id; ?>" name="question<?php echo $question->id; ?>" value="<?php echo ($question->date_answer != null) ? date('Y-m-d', strtotime($question->date_answer)) : "";?>">
                                <br>
                                <?php
                                break;
                            default:
                                // Question type doesn't exist
                                echo "Sorry, something went wrong. You cannot fill out this question at this time.";
                                break;
                        }

                        // Add a comment field or a text answer field
                        ?>
                        <textarea rows="3" id="comment<?php echo $question->id; ?>" name="comment<?php echo $question->id; ?>" class="form-control" maxlength="2000" placeholder='<?php echo ($question->question_type->id == 2) ? "Please type your answer here" : "If you have any comments, you can type them here.&#10;This is not required."; ?> (max. 2000 characters)' style="resize:vertical"><?php echo $question->answer_or_comment; ?></textarea>
                    </div>
                </div>
                <?php
            }
            ?>
            <button id="formSubmit" class="btn btn-primary">Submit</button>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->