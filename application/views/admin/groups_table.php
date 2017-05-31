<?php
// Table to show all email templates
$groupTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($groupTable);

$this->table->set_heading('Group name', 'Edit', 'Delete');
foreach ($groups as $group) {
    $this->table->add_row($group->name, '<a class="edit btn btn-warning" value="' . $group->id . '" ><span class="fa fa-edit"></span></a>', '<a class="delete btn btn-danger" value="' . $group->id . '" ><span class="fa fa-remove"></span></a>');
}

echo $this->table->generate();
?>

