<?php
$surveyTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($surveyTable);

$this->table->set_heading('Survey name', 'Active', 'Created on', 'Group', 'Last used', '# Questions', 'View', 'Edit', 'Delete');
foreach ($surveys as $survey) {
    $this->table->add_row($survey->name, ($survey->active ? '<span class="fa fa-check"></span>' : '<span class="fa fa-remove"></span>'), $survey->created_on, $survey->group->name, $survey->used_on, '', '<a class="view btn btn-default" value="' . $survey->id . '" ><span class="fa fa-search"></span></a>', '<a class="edit btn btn-warning" value="' . $survey->id . '" ><span class="fa fa-edit"></span></a>', '<a class="delete btn btn-danger" value="' . $survey->id . '" ><span class="fa fa-remove"></span></a>');
}

echo $this->table->generate();
?>

