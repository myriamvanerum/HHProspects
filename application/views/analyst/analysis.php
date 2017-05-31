<!--Analyst page to handle analytics-->
<script type="text/javascript">
    $(document).ready(function () {
        getGroups();
        fillGroups();
        getQuestions();
        fillQuestions();
    });

    // Get all groups
    function getGroups() {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getGroups",
            data: {},
            async: false,
            success: function (result) {
                groups = jQuery.parseJSON(result);
            }
        });
    }

    function fillGroups() {
        combobox = document.getElementById("group");
        groups.forEach(function (group) {
            option = document.createElement("option");
            option.text = group.name;
            option.value = group.id;
            combobox.appendChild(option);
        });
    }

    // Get all questions
    function getQuestions() {
        $.ajax({type: "POST",
            url: site_url + "/Analyst/getQuestionsAnalysis",
            data: {},
            async: false,
            success: function (result) {
                questions = jQuery.parseJSON(result);
            }
        });
    }

    function fillQuestions() {
        combobox = document.getElementById("question");
        questions.forEach(function (question) {
            option = document.createElement("option");
            option.text = question.text;
            option.value = question.id;
            combobox.appendChild(option);
        });
    }

    $(document).on('click', '#generate', function () {
        $('#graph').css('opacity', '1.0');
    });
</script>
<div id="page-wrapper">
    <!--This page is not finished. There is not enough data right now to make anything worthwhile, so I made what I imagine the page could look like in the future.-->
    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-header">Analytics</h1>
            <div class="alert alert-info">
                <strong>Info!</strong> This page is not finished. There is not enough data right now to make actual analytics, so I made what I imagine the page could look like in the future.
            </div>
            <div class="form-group">
                <label for="group" class="col-lg-1 col-md-2 col-sm-3 control-label">Group:</label>
                <div class="col-lg-11 col-md-10 col-sm-9">
                    <select id="group" name="group" class="form-control">
                        <option value='0'>All</option>
                    </select>
                    <br>
                </div>
            </div>
            <div class="form-group">
                <label for="question" class="col-lg-1 col-md-2 col-sm-3 control-label">Question:</label>
                <div class="col-lg-11 col-md-10 col-sm-9">
                    <select id="question" name="question" class="form-control">
                    </select>
                    <br>
                </div>
            </div>
            <div class="form-group">
                <label for="graph_type" class="col-lg-1 col-md-2 col-sm-3 control-label">Graph type:</label>
                <div class="col-lg-11 col-md-10 col-sm-9">
                    <select id="graph_type" name="graph_type" class="form-control">
                        <option>Line</option>
                        <option>Area</option>
                        <option>Bar</option>
                        <option>Donut</option>
                    </select>
                    <br>
                </div>
            </div>
            <button class='btn btn-primary' id='generate'>Generate</button>
            <div id='graph' style='opacity:0.0'>
                <h3>How did you hear about Halmstad University?</h3>
                <div id="knowHH"></div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script>
    Morris.Bar({
        element: 'knowHH',
        data: [
            {y: '2014', so: 832, sc: 1426, f: 461, c: 349, o: 614},
            {y: '2015', so: 769, sc: 1674, f: 532, c: 316, o: 675},
            {y: '2016', so: 813, sc: 1732, f: 498, c: 383, o: 703},
            {y: '2017', so: 804, sc: 1634, f: 517, c: 349, o: 672}
        ],
        xkey: 'y',
        ykeys: ['so', 'sc', 'f', 'c', 'o'],
        labels: ['Social media', 'School', 'Friends', 'Commercials', 'Other']
    });
</script>