<?php
// Table to show all questions
$questionTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($questionTable);

$this->table->set_heading('Title', 'Question type', 'Active', 'View', 'Copy', 'Edit', 'Delete');
foreach ($questions as $question) {
    $this->table->add_row($question->title, $question->question_type->name, '<a class="toggleActive btn btn-default" value="' . $question->id . '" >' . ($question->active ? '<span class="fa fa-toggle-on"></span>' : '<span class="fa fa-toggle-off"></span>') . '</a>', '<a class="view btn btn-default" value="' . $question->id . '" ><span class="fa fa-search"></span></a>', '<a class="copy btn btn-success" value="' . $question->id . '" ><span class="fa fa-copy"></span></a>', '<a class="edit btn btn-warning" value="' . $question->id . '" ><span class="fa fa-edit"></span></a>', '<a class="delete btn btn-danger" value="' . $question->id . '" ><span class="fa fa-remove"></span></a>');
}

echo $this->table->generate();
?>

