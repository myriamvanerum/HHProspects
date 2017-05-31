<?php
// table used by Admin to display students
$studentTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($studentTable);

$this->table->set_heading('First name', 'Last name', 'E-mail', 'Group', 'Country', 'Responsible admin', 'Active', 'View', 'Edit', 'Delete');
foreach ($students as $student) {
    $this->table->add_row($student->first_name, $student->last_name, $student->email, $student->group->name, $student->country, $student->admin->first_name . " " . $student->admin->last_name, '<a class="toggleActive btn btn-default" value="' . $student->id . '" >' . ($student->active ? '<span class="fa fa-toggle-on"></span>' : '<span class="fa fa-toggle-off"></span>') . '</a>', '<a class="view btn btn-default" value="' . $student->id . '" ><span class="fa fa-search"></span></a>', '<a class="edit btn btn-warning" value="' . $student->id . '" ><span class="fa fa-edit"></span></a>', '<a class="delete btn btn-danger" value="' . $student->id . '" ><span class="fa fa-remove"></span></a>');
}

echo $this->table->generate();
?>

