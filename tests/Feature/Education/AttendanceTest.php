<?php

namespace Tests\Feature\Education;

use App\Models\User;
use App\Models\Education\Attendance;
use App\Models\Education\Course;
use App\Models\Education\Student;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_index_returns_view(): void
    {
        Attendance::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/education/attendance');

        $response->assertStatus(200);
    }

    public function test_create_returns_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/education/attendance/create');

        $response->assertStatus(200);
    }

    public function test_store_creates_attendance(): void
    {
        $student = Student::factory()->create();
        $course  = Course::factory()->create();

        $response = $this->actingAs($this->admin)->post('/education/attendance', [
            'student_id' => $student->id,
            'course_id'  => $course->id,
            'date'       => '2024-03-01',
            'status'     => 'present',
        ]);

        $response->assertRedirect()->assertSessionHas('success');
        $this->assertDatabaseHas('attendances', [
            'student_id' => $student->id,
            'course_id'  => $course->id,
            'date'       => '2024-03-01',
        ]);
    }

    public function test_bulk_store_creates_multiple_records(): void
    {
        $course  = Course::factory()->create();
        $student = Student::factory()->create();

        $response = $this->actingAs($this->admin)->post('/education/attendance/bulk', [
            'course_id' => $course->id,
            'date'      => '2024-03-01',
            'records'   => [
                ['student_id' => $student->id, 'status' => 'present'],
            ],
        ]);

        $response->assertRedirect()->assertSessionHas('success');
    }

    public function test_update_modifies_attendance(): void
    {
        $attendance = Attendance::factory()->create(['status' => 'present']);

        $response = $this->actingAs($this->admin)->put("/education/attendance/{$attendance->id}", [
            'status' => 'absent',
        ]);

        $response->assertRedirect()->assertSessionHas('success');
        $this->assertDatabaseHas('attendances', [
            'id'     => $attendance->id,
            'status' => 'absent',
        ]);
    }
}
