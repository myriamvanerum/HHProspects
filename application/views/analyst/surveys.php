<?php $user = $this->authex->getUserInfo(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        getSurveys();
    });
    
    // Get all surveys for table
    function getSurveys() {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getSurveys",
            data: {},
            async: false,
            success: function (result) {
                $("#surveys").html(result);
            }
        });
    }
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Analyst homepage</h1>
            <h3 class='col-sm-4'>Survey list</h3>
            <h3 class="text-right col-sm-8">
                <button class="btn btn-primary" id="insert"><span class="fa fa-plus"></span> Add a survey</button>
            </h3>
            <div id="surveys"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->