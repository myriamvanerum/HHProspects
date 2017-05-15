<?php
$questionTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($questionTable);

$this->table->set_heading('Title', 'Active', 'Question type', 'View', 'Edit', 'Delete');
foreach ($questions as $question) {
    $this->table->add_row($question->title, ($question->active ? '<span class="fa fa-check"></span>' : '<span class="fa fa-remove"></span>'), $question->question_type->name, '<a class="view btn btn-default" value="' . $question->id . '" ><span class="fa fa-search"></span></a>', '<a class="edit btn btn-warning" value="' . $question->id . '" ><span class="fa fa-edit"></span></a>', '<a class="delete btn btn-danger" value="' . $question->id . '" ><span class="fa fa-remove"></span></a>');
}

echo $this->table->generate();
?>

