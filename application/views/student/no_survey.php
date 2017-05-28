<!--Student page if there is no survey at this time-->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php $student = $this->authex->getStudentInfo();?>
            <h1 class="page-header">Hi <?php echo $student->first_name . " " . $student->last_name;?></h1>
            <p>There are no surveys for you to fill out at this time.</p>
            <p>When a new survey starts, you will receive an e-mail.</p>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    
    
</div>
<!-- /#page-wrapper -->