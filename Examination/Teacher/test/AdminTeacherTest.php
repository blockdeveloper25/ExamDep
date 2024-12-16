<?php

use PHPUnit\Framework\TestCase;

class AdminTeacherTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        // Mock the database connection
        $this->conn = $this->createMock(PDO::class);
    }

    /**
     * Mocked version of getAllTeachers for testing purposes
     */
    public function getAllTeachers($conn, $role)
    {
        $stmt = $conn->prepare("SELECT * FROM users WHERE role=?");
        $stmt->execute([$role]);
        return $stmt->fetchAll();
    }

    /**
     * Test admin access and teacher data retrieval
     */
    public function testAdminCanViewTeachers()
    {
        // Simulate session data for admin
        $_SESSION['id'] = 1;
        $_SESSION['role'] = 'admin';

        // Mock the getAllTeachers function's return value
        $teachers = [
            [
                'user_id' => 1,
                'employee_number' => '123',
                'fname' => 'John',
                'lname' => 'Doe',
                'username' => 'jdoe'
            ],
            [
                'user_id' => 2,
                'employee_number' => '456',
                'fname' => 'Jane',
                'lname' => 'Smith',
                'username' => 'jsmith'
            ]
        ];

        // Simulate the database call for teachers
        $this->conn->method('prepare')
            ->willReturn($this->getPDOMock($teachers));

        // Call the function to get teachers
        $result = $this->getAllTeachers($this->conn, 'teacher');

        // Assert that the result matches the expected teachers array
        $this->assertCount(2, $result);
        $this->assertEquals('John', $result[0]['fname']);
        $this->assertEquals('Jane', $result[1]['fname']);
    }

    /**
     * Test non-admin access redirects to login
     */
    public function testNonAdminRedirectsToLogin()
    {
        // Simulate session data for a non-admin user
        $_SESSION['id'] = 1;
        $_SESSION['role'] = 'teacher';

        // Start output buffering to capture the header call
        ob_start();
        include "../login.php"; // Simulating a login page with header redirect
        $output = ob_get_clean();

        // Test if the user is redirected
        $this->assertStringContainsString('Location: ../login.php', xdebug_get_headers());
    }

    /**
     * Test empty teacher data
     */
    public function testEmptyTeachersList()
    {
        // Simulate session data for admin
        $_SESSION['id'] = 1;
        $_SESSION['role'] = 'admin';

        // Simulate an empty list of teachers
        $this->conn->method('prepare')
            ->willReturn($this->getPDOMock([]));

        // Call the function to get teachers
        $result = $this->getAllTeachers($this->conn, 'teacher');

        // Assert that the result is empty
        $this->assertEmpty($result);
    }

    /**
     * Create a PDO statement mock to simulate database queries
     */
    protected function getPDOMock($data)
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchAll')->willReturn($data);

        return $stmt;
    }
}
