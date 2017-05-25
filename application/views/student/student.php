<?php $survey = current($surveys); ?>
<?php $student = $this->authex->getStudentInfo(); ?>
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
            $attributes = array('name' => 'surveyForm');
            echo form_open('Student/sendSurvey', $attributes);
            foreach ($survey->questions as $question) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $question->text ?></div>
                    <div class="panel-body">
                        <?php
                        switch ($question->question_type->id) {
                            case 1:
                                // Checkbox
                                foreach ($question->answer_options as $answer_option) {
                                    ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="question<?php echo $question->id; ?>" value="<?php echo $answer_option->id; ?>"><?php echo $answer_option->answer;?></label>
                                    </div>
                                    <?php
                                }
                                break;
                            case 2:
                                // Text
                                ?>
                                <textarea rows="3" name="question<?php echo $question->id; ?>" class="form-control" placeholder="Please type your answer here" style="resize:vertical"></textarea>
                                <?php
                                break;
                            case 3:
                                // Radio
                                foreach ($question->answer_options as $answer_option) {
                                    ?>
                                    <div class="radio">
                                        <label><input type="radio" name="question<?php echo $question->id; ?>" value="<?php echo $answer_option->id; ?>"><?php echo $answer_option->answer;?></label>
                                    </div>
                                    <?php
                                }
                                break;
                            case 4:
                                // Dropdown
                                ?>
                                <select name="question<?php echo $question->id; ?>" class="form-control">
                                <?php
                                foreach ($question->answer_options as $answer_option) {
                                    echo '<option value="' . $answer_option->id . '">' . $answer_option->answer . '</option>';
                                }
                                ?>
                                </select>
                                <?php
                                break;
                            case 5:
                                // Yes/No
                                ?>
                                <div class = "radio">
                                    <label><input type="radio" name="question<?php echo $question->id; ?>" value="1">Yes</label>
                                </div>
                                <div class = "radio">
                                    <label><input type="radio" name="question<?php echo $question->id; ?>" value="2">No</label>
                                </div>
                                <?php
                                break;
                            case 6:
                                // True/False
                                ?>
                                <div class = "radio">
                                    <label><input type="radio" name="question<?php echo $question->id; ?>" value="10">True</label>
                                </div>
                                <div class = "radio">
                                    <label><input type="radio" name="question<?php echo $question->id; ?>" value="11">False</label>
                                </div>
                                <?php
                                break;
                            case 7:
                                // Slider
                                echo "Sorry, something went wrong. You cannot fill out this question at this time.";
                                break;
                            case 8:
                                // Date
                                ?>
                                <input type="date" class="form-control" name="question<?php echo $question->id; ?>">
                                <?php
                                break;
                            default:
                                // Question type doesn't exist
                                echo "Sorry, something went wrong. You cannot fill out this question at this time.";
                                break;
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            echo form_submit('formSubmit', 'Submit', "class='btn btn-primary'");
            echo form_close();
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->