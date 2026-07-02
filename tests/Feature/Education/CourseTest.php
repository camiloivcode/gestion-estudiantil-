<?php

namespace Tests\Feature\Education;

use App\Models\User;
use App\Models\Education\Course;
use App\Models\Education\Program;
use App\Models\Education\Teacher;
use Tests\TestCase;

class CourseTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_index_returns_view(): void
    {
        Course::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/education/courses');

        $response->assertStatus(200);
    }

    public function test_create_returns_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/education/courses/create');

        $response->assertStatus(200);
    }

    public function test_store_creates_course(): void
    {
        $program = Program::factory()->create();
        $teacher = Teacher::factory()->create();

        $response = $this->actingAs($this->admin)->post('/education/courses', [
            'name'        => 'Test Course',
            'code'        => 'TST-101',
            'teacher_id'  => $teacher->id,
            'program_id'  => $program->id,
            'credits'     => 4,
            'status'      => 'active',
        ]);

        $response->assertRedirect()->assertSessionHas('success');
        $this->assertDatabaseHas('courses', ['code' => 'TST-101']);
    }

    public function test_show_displays_course(): void
    {
        $course = Course::factory()->create();

        $response = $this->actingAs($this->admin)->get("/education/courses/{$course->id}");

        $response->assertStatus(200);
    }

    public function test_update_modifies_course(): void
    {
        $course = Course::factory()->create(['name' => 'Original']);

        $response = $this->actingAs($this->admin)->put("/education/courses/{$course->id}", [
            'name'    => 'Updated Course',
            'credits' => 5,
            'status'  => 'active',
        ]);

        $response->assertRedirect()->assertSessionHas('success');
        $this->assertDatabaseHas('courses', ['name' => 'Updated Course']);
    }

    public function test_destroy_removes_course(): void
    {
        $course = Course::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/education/courses/{$course->id}");

        $response->assertRedirect()->assertSessionHas('success');
    }

    public function test_student_can_view_courses(): void
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)->get('/education/courses');

        $response->assertStatus(200);
    }

    public function test_student_cannot_create_courses(): void
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)->get('/education/courses/create');

        $response->assertStatus(403);
    }
}
