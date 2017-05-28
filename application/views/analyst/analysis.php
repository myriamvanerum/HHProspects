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
</script>
<div id="page-wrapper">
    <!--This page is not finished. There is not enough data right now to make anything worthwhile, so I made what I imagine the page could look like in the future.-->
    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-header">Analysis</h1>
            <div class="alert alert-info">
                <strong>Info!</strong> This page is not finished. There is not enough data right now to make anything worthwhile, so I made what I imagine the page could look like in the future.
            </div>
            <div class="form-group">
                <label for="group" class="col-lg-1 col-md-2 col-sm-3 control-label">Group:</label>
                <div class="col-lg-11 col-md-10 col-sm-9">
                    <select id="group" name="group" class="form-control">
                        <option value='0'>All</option>
                        <option disabled>──────────────────────────────────────</option>
                    </select>
                    <br>
                </div>
            </div>
            <div class="form-group">
                <label for="question" class="col-lg-1 col-md-2 col-sm-3 control-label">Question:</label>
                <div class="col-lg-11 col-md-10 col-sm-9">
                    <select id="question" name="question" class="form-control">
                        <option value='0'>All</option>
                        <option disabled>──────────────────────────────────────</option>
                    </select>
                    <br>
                </div>
            </div>
            <div class='col-lg-9'>
                <h3>Prospecting students per year</h3>
                <div id="studentsPerYear"></div>
            </div>
            <div class='col-lg-3'>
                <h3>Percentage of students that graduate</h3>
                <div id="percentageGraduate"></div>
            </div>
            <div class='col-lg-6'>
                <h3>How students got to know Halmstad University</h3>
                <div id="knowHH"></div>
            </div>
            <div class='col-lg-6'>
                <h3>Which countries have the most students?</h3>
                <div id="countries"></div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script>
    Morris.Area({
        // ID of the element in which to draw the chart.
        element: 'studentsPerYear',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
            {y: '2006', it: 240, ai: 74, at: 226, itf: 182, bm: 179, bu: 451},
            {y: '2007', it: 268, ai: 76, at: 187, itf: 176, bm: 221, bu: 529},
            {y: '2008', it: 284, ai: 90, at: 269, itf: 194, bm: 243, bu: 473},
            {y: '2009', it: 297, ai: 114, at: 316, itf: 149, bm: 276, bu: 435},
            {y: '2010', it: 332, ai: 128, at: 348, itf: 154, bm: 259, bu: 394},
            {y: '2011', it: 359, ai: 146, at: 374, itf: 165, bm: 243, bu: 387},
            {y: '2012', it: 348, ai: 145, at: 392, itf: 183, bm: 261, bu: 327},
            {y: '2013', it: 363, ai: 167, at: 405, itf: 172, bm: 292, bu: 319},
            {y: '2014', it: 371, ai: 183, at: 382, itf: 169, bm: 306, bu: 346},
            {y: '2015', it: 385, ai: 207, at: 394, itf: 183, bm: 294, bu: 338},
            {y: '2016', it: 407, ai: 246, at: 406, itf: 201, bm: 281, bu: 362},
        ],
        xkey: 'y',
        ykeys: ['it', 'ai', 'at', 'itf', 'bm', 'bu'],
        labels: ['Information Technology', 'Artificial Intelligence', 'Automative Technologies', 'IT Forensics', 'Biomechanics', 'Business']
    });

    Morris.Donut({
        element: 'percentageGraduate',
        data: [
            {label: "Graduating", value: 62},
            {label: "Not graduating", value: 38}
        ],
        formatter: function (value, data) {
            return value + '%';
        }
    });

    Morris.Bar({
        element: 'knowHH',
        data: [
            {y: '2014', so: 832, sc: 1426, f: 461, c: 349, o: 614},
            {y: '2015', so: 769, sc: 1674, f: 532, c: 316, o: 675},
            {y: '2016', so: 813, sc: 1732, f: 498, c: 383, o: 703}
        ],
        xkey: 'y',
        ykeys: ['so', 'sc', 'f', 'c', 'o'],
        labels: ['Social media', 'School', 'Friends', 'Commercials', 'Other']
    });

    Morris.Donut({
        element: 'countries',
        data: [
            {label: "Germany", value: 734},
            {label: "France", value: 826},
            {label: "Spain", value: 629},
            {label: "Belgium", value: 371},
            {label: "China", value: 547}
        ],
    });
</script>