<?php
$questionTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($questionTable);

$this->table->set_heading('Question', 'Question type', 'Delete');
foreach ($questions as $question) {
    $this->table->add_row($question->text . "<input class='questionRow' name='questions[]' type='hidden' value='" . $question->id . "'", $question->question_type->name, '<a class="delete btn btn-danger" value="' . $question->id . '" ><span class="fa fa-remove"></span></a>');
}

echo $this->table->generate();
?>

