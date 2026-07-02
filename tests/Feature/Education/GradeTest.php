<?php

namespace Tests\Feature\Education;

use App\Models\User;
use App\Models\Education\Course;
use App\Models\Education\Grade;
use App\Models\Education\Student;
use Tests\TestCase;

class GradeTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_index_returns_view(): void
    {
        Grade::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/education/grades');

        $response->assertStatus(200);
    }

    public function test_create_returns_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/education/grades/create');

        $response->assertStatus(200);
    }

    public function test_store_creates_grade(): void
    {
        $student = Student::factory()->create();
        $course  = Course::factory()->create();

        $response = $this->actingAs($this->admin)->post('/education/grades', [
            'student_id' => $student->id,
            'course_id'  => $course->id,
            'period'     => '2024-1',
            'grade_1'    => 8.5,
            'grade_2'    => 9.0,
        ]);

        $response->assertRedirect()->assertSessionHas('success');
        $this->assertDatabaseHas('grades', [
            'student_id' => $student->id,
            'course_id'  => $course->id,
            'period'     => '2024-1',
        ]);
    }

    public function test_bulk_store_creates_multiple_grades(): void
    {
        $course  = Course::factory()->create();
        $student = Student::factory()->create();

        $response = $this->actingAs($this->admin)->post('/education/grades/bulk', [
            'course_id' => $course->id,
            'period'    => '2024-2',
            'grades'    => [
                ['student_id' => $student->id, 'grade_1' => 7.0, 'grade_2' => 8.0],
            ],
        ]);

        $response->assertRedirect()->assertSessionHas('success');
    }

    public function test_student_cannot_manage_grades(): void
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)->get('/education/grades/create');

        $response->assertStatus(403);
    }
}
