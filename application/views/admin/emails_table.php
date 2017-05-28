<?php
// Table to show all email templates
$emailTable = array('table_open' => '<table class="table table-striped">');
$this->table->set_template($emailTable);

$this->table->set_heading('Template name', 'View', 'Send', 'Edit', 'Delete');
foreach ($email_templates as $email_template) {
    $this->table->add_row($email_template->name, '<a class="view btn btn-default" value="' . $email_template->id . '" ><span class="fa fa-search"></span></a>', '<a class="send btn btn-primary" value="' . $email_template->id . '" ><span class="fa fa-send"></span></a>', '<a class="edit btn btn-warning" value="' . $email_template->id . '" ><span class="fa fa-edit"></span></a>', '<a class="delete btn btn-danger" value="' . $email_template->id . '" ><span class="fa fa-remove"></span></a>');
}

echo $this->table->generate();
?>

