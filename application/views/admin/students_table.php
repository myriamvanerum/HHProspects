<?php
$studentTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($studentTable);

$this->table->set_heading('First name', 'Last name', 'E-mail', 'Group', 'Country', 'Responsible admin', 'View student');
foreach ($students as $student) {
    $this->table->add_row($student->first_name, $student->last_name, $student->email, $student->group->name, $student->country, $student->admin->first_name . " " . $student->admin->last_name, '<a class="view btn btn-default" value="' . $student->id . '" ><span class="fa fa-search"></span></a>');
}

echo $this->table->generate();
?>

