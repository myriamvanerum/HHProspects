<?php
// table used by Admin to display students
$userTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($userTable);

$this->table->set_heading('First name', 'Last name', 'E-mail', 'User level', 'Edit', 'Delete');
foreach ($users as $user) {
    $this->table->add_row($user->first_name, $user->last_name, $user->email, $user->user_level->name, '<a class="edit btn btn-warning" value="' . $user->id . '" ><span class="fa fa-edit"></span></a>', '<a class="delete btn btn-danger" value="' . $user->id . '" ><span class="fa fa-remove"></span></a>');
}

echo $this->table->generate();
?>