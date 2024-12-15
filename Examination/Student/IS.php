<?php
//gettings tables
$tables = getAllTableNames($conn);
$sem1 = ['IS1101', 'IS1102', 'IS1103', 'IS1104', 'IS1105', 'IS1106', 'IS1107', 'IS1108', 'IS1109', 'IS1110', 'IS1111', 'IS-EGP-1101'];
$sem2 = ['IS2101', 'IS2102', 'IS2103', 'IS2104', 'IS2105', 'IS2106', 'IS2107', 'IS2108', 'IS2109', 'IS2110', 'IS2111', 'IS2112', 'IS-EGP-1201'];
$sem3 = ['IS3101', 'IS3102', 'IS3103', 'IS3104', 'IS3105', 'IS3106', 'IS3107', 'IS3108', 'IS3109', 'IS-EAP-2101'];
$sem4 = ['IS4101', 'IS4102', 'IS4103', 'IS4104', 'IS4105', 'IS4106', 'IS4107', 'IS4108', 'IS4109', 'IS4110', 'IS-EAP-2201'];
$sem5 = ['IS5101', 'IS5102', 'IS5103', 'IS5104', 'IS5105', 'IS5106', 'IS5107', 'IS5108', 'IS5109', 'IS-EBP-3101', 'IS5110', 'IS5111', 'IS5112', 'IS5113', 'IS5114'];
$sem6 = ['IS6101'];
$sem7 = ['IS7101', 'IS7102', 'IS7103', 'IS7104', 'IS7105', 'IS7106', 'IS7107', 'IS7108', 'IS7109', 'IS7110', 'IS7111', 'IS7112'];
$sem8 = ['IS8101', 'IS8102', 'IS8103', 'IS8104', 'IS8105', 'IS8106', 'IS8107', 'IS8108', 'IS8109', 'IS8110', 'IS8111'];

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
