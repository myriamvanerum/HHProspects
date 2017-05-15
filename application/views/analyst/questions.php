<?php $user = $this->authex->getUserInfo(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        getQuestions();
    });
    
    // Get all surveys for table
    function getQuestions() {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getQuestions",
            data: {},
            async: false,
            success: function (result) {
                $("#questions").html(result);
            }
        });
    }
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Analyst homepage</h1>
            <h3 class='col-sm-4'>Question list</h3>
            <h3 class="text-right col-sm-8">
                <button class="btn btn-primary" id="insert"><span class="fa fa-plus"></span> Add a question</button>
            </h3>
            <div id="questions"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->