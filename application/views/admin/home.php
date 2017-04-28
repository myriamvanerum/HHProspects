<script type="text/javascript">
    function getStudents() {
        $.ajax({type: "POST",
            url: site_url + "/Admin/getStudents",
            data: {},
            async: false,
            success: function (result) {
                $("#students").html(result);
            }
        });
    }

    $(document).ready(function () {
        getStudents();
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Administrator homepage</h1>
            <p class="text-right">
                <?php echo anchor('Admin/importStudent', '<span class="fa fa-user-plus"></span> Add a student', 'class="btn btn-primary"'); ?>
                <?php echo anchor('Admin/importStudents', '<span class="fa fa-file-excel-o"></span> Import students', 'class="btn btn-primary"'); ?>
            </p>
            <div id="students"></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->