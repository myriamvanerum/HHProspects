<?php
$questionTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($questionTable);

$this->table->set_heading('Add', 'Question', 'Question type');
foreach ($questions as $question) {
    $this->table->add_row('<input type="checkbox" id="' . $question->id . '">', $question->text, $question->question_type->name);
}

echo $this->table->generate();
?>

