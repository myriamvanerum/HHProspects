<?php $survey = current($surveys);?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo $survey->name;?></h1>
            <p>You can change your answers until <?php echo $survey->ends_on;?></p>
            <?php 
//            foreach ($survey->questions as $question) {
//                echo "<p>" . $question->text . "</p>";
//            }
            ?>
            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->