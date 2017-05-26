<?php $survey = current($surveys); ?>
<?php $student = $this->authex->getStudentInfo(); ?>
<script type="text/javascript">
    // Submit survey
    $(document).on('click', '#formSubmit', function () {
        
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $survey->name; ?></h1>
            <p>Welcome <?php echo $student->first_name . " " . $student->last_name; ?>!</p>
            <p>Please fill out this survey for Halmstad University Prospects.</p>
            <p>You can change your answers until <?php echo $survey->ends_on; ?>.</p>
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
                <div class="panel panel-default" id="question<?php echo $question->id;?>">
                    <div class="panel-heading"><?php echo $question->text ?></div>
                    <div class="panel-body">
                        <?php
                        switch ($question->question_type->id) {
                            case 1:
                                // Checkbox
                                foreach ($question->answer_options as $answer_option) {
                                    ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="comment<?php echo $question->id; ?>" name="question<?php echo $question->id; ?>" value="<?php echo $answer_option->id; ?>" <?php echo ($answer_option->chosen == TRUE) ? 'checked=""' : '';?>><?php echo $answer_option->answer;?></label>
                                    </div>
                                    <?php
                                }
                                break;
                            case 3:
                            case 5:
                            case 6:
                                // Radio, Yes/No, True/False
                                foreach ($question->answer_options as $answer_option) {
                                    ?>
                                    <div class="radio">
                                        <label><input type="radio" id="comment<?php echo $question->id; ?>" name="question<?php echo $question->id; ?>" value="<?php echo $answer_option->id; ?>" <?php echo ($answer_option->chosen == TRUE) ? 'checked=""' : '';?>><?php echo $answer_option->answer;?></label>
                                    </div>
                                    <?php
                                }
                                break;
                            case 4:
                                // Dropdown
                                ?>
                                <select id="comment<?php echo $question->id; ?>" name="question<?php echo $question->id; ?>" class="form-control">
                                <?php
                                foreach ($question->answer_options as $answer_option) {
                                    ?>
                                    <option value="<?php echo $answer_option->id;?>" <?php echo ($answer_option->chosen == TRUE) ? 'selected=""' : '';?>><?php echo $answer_option->answer;?></option>
                                    <?php
                                }
                                ?>
                                </select>
                                <br>
                                <?php
                                break;
                            case 7:
                                // Slider
                                echo "Sorry, something went wrong. You cannot fill out this question at this time.";
                                break;
                            case 8:
                                // Date
                                ?>
                                <input type="date" class="form-control" id="comment<?php echo $question->id; ?>" name="question<?php echo $question->id; ?>" value="<?php echo date('Y-m-d',strtotime($question->date_answer)); ?>">
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
                        <textarea rows="3" id="comment<?php echo $question->id; ?>" name="comment<?php echo $question->id; ?>" class="form-control" maxlength="2000" placeholder='<?php echo ($question->question_type->id == 2) ? "Please type your answer here" : "If you have any comments, you can type them here.&#10;This is not required.";?> (max. 2000 characters)' style="resize:vertical"><?php echo $question->answer_or_comment;?></textarea>
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