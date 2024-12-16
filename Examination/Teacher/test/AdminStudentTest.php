<?php

use PHPUnit\Framework\TestCase;

class StudentManagementTest extends TestCase
{
    protected function setUp(): void
    {
        // Start session for testing
        session_start();
    }

    protected function tearDown(): void
    {
        // Clear session data after tests
        $_SESSION = [];
        session_destroy();
    }

    public function testAdminAccessDisplaysStudents()
    {
        // Simulate a session for an admin user
        $_SESSION['id'] = 1;
        $_SESSION['role'] = 'admin';

        // Mock database connection and student retrieval
        $mockConnection = $this->createMock(PDO::class);
        $mockStudents = [
            ['user_id' => 1, 'fname' => 'John', 'username' => 'johnny', 'course' => 'Math'],
            ['user_id' => 2, 'fname' => 'Jane', 'username' => 'jane_doe', 'course' => 'Science'],
        ];

        // Mock the getAllStudents function
        $this->mockGetAllStudents($mockConnection, $mockStudents);

        // Start output buffering to capture HTML output
        ob_start();
        include "../admin/student.php"; // Adjust path as necessary
        $output = ob_get_clean();

        // Check that students are displayed correctly
        $this->assertStringContainsString('John', $output);
        $this->assertStringContainsString('jane_doe', $output);
    }

    public function testNonAdminRedirectsToLogin()
    {
        // Simulate a session for a non-admin user
        $_SESSION['id'] = 1;
        $_SESSION['role'] = 'student'; // Non-admin role

        // Start output buffering
        ob_start();
        include "../admin/student.php"; // Adjust path as necessary
        $output = ob_get_clean();

        // Assert that output is empty and header for redirection is sent
        $this->assertEmpty($output);
        $this->assertTrue(headers_sent(), "Headers were not sent for redirect.");
        $this->assertStringContainsString('Location: ../login.php', xdebug_get_headers()[0]);
    }

    public function testEmptyStudentListDisplaysMessage()
    {
        // Simulate a session for an admin user
        $_SESSION['id'] = 1;
        $_SESSION['role'] = 'admin';

        // Mock database connection and empty student retrieval
        $mockConnection = $this->createMock(PDO::class);
        $this->mockGetAllStudents($mockConnection, []); // No students

        // Start output buffering to capture HTML output
        ob_start();
        include "../admin/student.php"; // Adjust path as necessary
        $output = ob_get_clean();

        // Check that the empty message is displayed
        $this->assertStringContainsString('Empty!', $output);
    }

    // Mock the getAllStudents function for testing
    private function mockGetAllStudents($mockConnection, $students)
    {
        // Create a mock for the getAllStudents function to return predefined students
        $mockConnection->method('prepare')->willReturn($this->getPDOMock($students));
        
        // Ensure that your code can access this mocked connection correctly.
        // Here, you'd need to inject this mockConnection into the code that calls getAllStudents.
        require_once '../DB_connection.php'; // Include the DB connection mock if necessary
    }

    // Mock PDOStatement to simulate database queries
    private function getPDOMock($data)
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn($data);
        return $stmt;
    }
}
