<?php
$surveyTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($surveyTable);

$this->table->set_heading('Survey name', 'Group', 'Starts on', 'Ends on', '#&nbsp;Questions', 'Active', 'View', 'Copy', 'Edit', 'Delete');
foreach ($surveys as $survey) {
    $this->table->add_row($survey->name, $survey->group->name, $survey->starts_on, $survey->ends_on, $survey->question_count, '<a class="toggleActive btn btn-default" value="' . $survey->id . '" >' . ($survey->active ? '<span class="fa fa-toggle-on"></span>' : '<span class="fa fa-toggle-off"></span>') . '</a>', '<a class="view btn btn-default" value="' . $survey->id . '" ><span class="fa fa-search"></span></a>', '<a class="copy btn btn-success" value="' . $survey->id . '" ><span class="fa fa-copy"></span></a>', '<a class="edit btn btn-warning" value="' . $survey->id . '" ><span class="fa fa-edit"></span></a>', '<a class="delete btn btn-danger" value="' . $survey->id . '" ><span class="fa fa-remove"></span></a>');
}

echo $this->table->generate();
?>

