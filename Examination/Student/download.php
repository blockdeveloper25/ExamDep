<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (
        isset($_SESSION['id']) &&
        isset($_SESSION['role'])
) {


        if ($_SESSION['role'] == 'student') {
                include "../DB_connection.php";
                include "data/student.php";
                include "data/table.php";
                include "data/examform.php";

                $student_id = $_SESSION['id'];

                $student = getStudentById($student_id, $conn);
                $conf = $student['confirmation'];
                $mess = getNotification($conn, $conf);
                $reg_no = $student['username'];
                $course = $student['course'];
                $name = $student['fname'];
                $batch = (int) $student['batch'];

                error_reporting(E_ALL);
                ini_set('display_errors', 1);

                ob_start();
                require('fpdf181/fpdf.php'); // Adjust path as needed




                class PDF extends FPDF
                {

                        // Page header
                        function Header()
                        {
                                // Logo
                                $this->Image('../logo.png', 43, 8, 15); // Path to logo image file, x position, y position, width in mm.
                                // Arial bold 15
                                $this->SetFont('times', 'B', 15);
                                // Move to the right
                                $this->Cell(40);
                                // Title
                                $this->Cell(110, 10, 'Sabaragamuwa University of Sri Lanka', 0, 1, 'C');
                                // Line break
                                $this->Ln(10);
                        }

                        // Page footer
                        function Footer()
                        {
                                // Position at 1.5 cm from bottom
                                $this->SetY(-15);
                                // Arial italic 8
                                $this->SetFont('times', 'I', 8);
                                // Page number
                                $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
                                // Signature line for Department Head
                                $this->SetY(-30);
                                $this->Cell(90, 10, 'Department Head Signature:', 0, 0, 'L');
                                // Signature line for Faculty Head
                                $this->SetX(-150);
                                $this->Cell(90, 10, 'Faculty Head Signature:', 0, 0, 'R');
                        }

                        // Table body

                }

                // Instanciation of inherited class
                $pdf = new PDF();
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetFont('times', 'B', 13);
                $pdf->Cell(40, 10, 'Name:', 0, 0, 'L');
                $pdf->Cell(40, 10, $name, 0, 1, 'L');
                $pdf->Cell(40, 10, 'Register No', 0, 0, 'L');

                $pdf->Cell(40, 10, $reg_no, 0, 1, 'L');
                $pdf->Cell(40, 10, 'Course', 0, 0, 'L');
                $pdf->Cell(40, 10, $course, 0, 1, 'L');
                $pdf->Cell(40, 10, 'Academic Year', 0, 0, 'L');
                $pdf->Cell(40, 10, $batch . '/' . ($batch + 1), 0, 1, 'L');
                $pdf->Ln(10);
                if ($course == 'SE') {

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
                        $i = 0;
                        foreach ($Semesters as $semester) {

                                $pdf->SetFont('times', 'B', 15);
                                $pdf->Cell(40, 10, 'Semester' . ($i + 1), 0, 1, 'L');
                                if (!empty($semester)) {
                                        $pdf->SetFont('times', 'B', 10);
                                        $pdf->Cell(40, 10, 'Subject Code', 1, 0, 'C');
                                        $pdf->Cell(40, 10, 'Grade', 1, 1, 'C');
                                        foreach ($semester as $table) {
                                                $marks = getMarksByRegNo($table, $reg_no, $conn);


                                                $pdf->Cell(40, 10, $table, 1, 0, 'C');
                                                $pdf->Cell(40, 10, gradeCalc($marks), 1, 1, 'C');
                                        }
                                        $i++;
                                } else {

                                        $pdf->Cell(80, 10, 'No Records Found', 1, 1, 'C');

                                        $i++;
                                }
                                $pdf->Ln(10);
                        }
                } elseif ($course == 'IS') {
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
                        $i = 0;
                        foreach ($Semesters as $semester) {

                                $pdf->SetFont('times', 'B', 15);
                                $pdf->Cell(40, 10, 'Semester' . ($i + 1), 0, 1, 'L');
                                if (!empty($semester)) {

                                        foreach ($semester as $table) {
                                                $marks = getMarksByRegNo($table, $reg_no, $conn);
                                                $pdf->SetFont('times', 'B', 10);
                                                $pdf->Cell(40, 10, 'Subject Code', 1, 0, 'C');
                                                $pdf->Cell(40, 10, 'Grade', 1, 1, 'C');
                                                $pdf->Cell(40, 10, $table, 1, 0, 'C');
                                                $pdf->Cell(40, 10, gradeCalc($marks), 1, 1, 'C');
                                                $pdf->Ln(10);
                                                $i++;
                                        }
                                } else {
                                        $pdf->SetFont('times', 'B', 10);
                                        $pdf->Cell(40, 10, 'Subject Code', 1, 0, 'C');
                                        $pdf->Cell(40, 10, 'Grade', 1, 1, 'C');
                                        $pdf->Cell(80, 10, 'No Marks Added', 1, 1, 'C');
                                        $pdf->Ln(10);
                                        $i++;
                                }
                        }
                }
                $pdf->Output();
                ob_end_flush();
        } else {
                header("Location: ../login.php");
                exit;
        }
} else {
        header("Location: ../login.php");
        exit;
}
