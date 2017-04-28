<?php
$studentTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($studentTable);

$this->table->set_heading('First name', 'Last name', 'E-mail', 'Person number', 'Country', 'Responsible admin');
foreach ($students as $student) {
    $this->table->add_row($student->first_name, $student->last_name, $student->email, $student->person_number, $student->country, $student->admin->first_name . " " . $student->admin->last_name );
}

echo $this->table->generate();
?>

