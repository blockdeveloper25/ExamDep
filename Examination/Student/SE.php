<?php
//gettings tables
$tables = getAllTableNames($conn);
$sem1 = ['SE1101', 'SE1102', 'SE1103', 'SE1104', 'SE1105', 'SE1106', 'SE1107', 'SE1108', 'SE1109', 'SE-EGP-1101'];
$sem2 = ['SE2101', 'SE2102', 'SE2103', 'SE2104', 'SE2105', 'SE2106', 'SE2107', 'SE2108', 'SE2109', 'SE-EGP-1201'];
$sem3 = ['SE3101', 'SE3102', 'SE3103', 'SE3104', 'SE3105', 'SE3106', 'SE3107', 'SE-EAP-2101'];
$sem4 = ['SE4101', 'SE4102', 'SE4103', 'SE4104', 'SE4105', 'SE4106', 'SE4107', 'SE4108', 'SE4109', 'SE4110', 'SE-EAP-2201'];
$sem5 = ['SE5101', 'SE5102', 'SE5103', 'SE5104', 'SE5105', 'SE-EBP-3101', 'SE5106', 'SE5107', 'SE5108', 'SE5109', 'SE5110'];
$sem6 = ['SE6101', 'SE6102', 'SE6103', 'SE6104', 'SE6105', 'SE6106', 'SE6107', 'SE6108', 'SE6109', 'SE6110', 'SE6111', 'SE6112', 'SE6113'];
$sem7 = ['SE7101'];
$sem8 = ['SE8101', 'SE8102', 'SE8103', 'SE8104', 'SE8105', 'SE8106', 'SE8107', 'SE8108', 'SE8109', 'SE8110', 'SE8111'];
//Finding the Added marks Arrays
$added_sem1 = array_intersect($tables, $sem1);
$added_sem2 = array_intersect($tables, $sem2);
$added_sem3 = array_intersect($tables, $sem3);
$added_sem4 = array_intersect($tables, $sem4);
$added_sem5 = array_intersect($tables, $sem5);
$added_sem6 = array_intersect($tables, $sem6);
$added_sem7 = array_intersect($tables, $sem7);
$added_sem8 = array_intersect($tables, $sem8);

$Semesters = [$added_sem1, $added_sem2, $added_sem3, $added_sem4, $added_sem5, $added_sem6, $added_sem7, $added_sem8];

echo '<div class="mx-auto" style="width:70%">';
$i = 0;
foreach ($Semesters as $semester) {
    echo '<h3 >Semester ' . ($i + 1) . '</h3>';
    echo '<table class="table table-bordered mx-auto" style="margin-bottom:20px">';
    echo '<thead class="thead-dark"><tr><th>Subject Code</th><th>Marks</th></tr></thead>';

    echo '<tbody>';
    if (!empty($semester)) {
        foreach ($semester as $table) {
            $marks = getMarksByRegNo($table, $reg_no, $conn);


            // Loop through results and create a table row for each

            echo '<tr>';
            echo '<td>' . htmlspecialchars($table) . '</td>';
            echo '<td>' . htmlspecialchars(gradeCalc($marks)) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td>' . htmlspecialchars('No Marks added') .  '</td>';
        echo '<td>' . htmlspecialchars('No Marks added') . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
    $i++;
   
}
echo '</div>';
