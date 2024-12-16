<?php

use PHPUnit\Framework\TestCase;

class AdminSettingTest extends TestCase
{
    protected function setUp(): void
    {
        // Start a session to simulate session handling
        session_start();
    }

    /**
     * Test that non-admin users are redirected to the login page
     */public function testNonAdminRedirectsToLogin()
{
    // Simulate a session for a non-admin user
    $_SESSION['id'] = 1;
    $_SESSION['role'] = 'student'; // Non-admin role

    // Start output buffering
    ob_start();

    // Include the settings page
    include "../admin/setting.php";

    // Get the output and clean the buffer
    $output = ob_get_clean();

    // Assert that there is no output when redirecting
    $this->assertEmpty($output, "Output should be empty on redirect.");

    // Check if the redirect header for login page was sent
    $this->assertTrue(headers_sent(), "Headers were not sent.");

    // Check that the appropriate redirect header is present
    $headers = xdebug_get_headers();
    $this->assertStringContainsString('Location: ../login.php', $headers[count($headers) - 1], "Expected redirect header not found.");
}

    /**
     * Test that admin users can access the settings page
     */
    public function testAdminCanAccessSettings()
    {
        // Simulate a session for an admin user
        $_SESSION['id'] = 1;
        $_SESSION['role'] = 'admin'; // Admin role

        // Mock the database connection and settings
        $mockConnection = $this->createMock(PDO::class);
        $mockSetting = [
            'school_name' => 'Test School',
            'slogan' => 'Learning is Fun',
            'about' => 'About Test School',
            'current_year' => '2024',
            'current_semester' => '1st Semester'
        ];

        // Assume getSetting is defined and accessible
        $mockConnection->method('prepare')
            ->willReturn($this->getPDOMock($mockSetting));

        // Mock the setting retrieval
        require_once '../DB_connection.php'; // Include database connection mock
        require_once 'data/setting.php'; // Include the settings logic

        ob_start(); // Start output buffering
        include "../admin/setting.php"; // Include the settings page
        $output = ob_get_clean(); // Get the output and clean the buffer

        // Check if settings page rendered without errors
        $this->assertStringContainsString('Admin - Setting', $output);
        $this->assertStringContainsString('Test School', $output);
        $this->assertStringContainsString('Learning is Fun', $output);
    }

    /**
     * Mock PDOStatement to simulate database queries
     */
    protected function getPDOMock($data)
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetch')->willReturn($data);

        return $stmt;
    }

    protected function tearDown(): void
    {
        // Clear session data after tests
        session_destroy();
    }
}
