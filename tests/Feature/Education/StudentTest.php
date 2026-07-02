<?php

namespace Tests\Feature\Education;

use App\Models\User;
use App\Models\Education\Program;
use App\Models\Education\Student;
use Tests\TestCase;

class StudentTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_index_returns_view(): void
    {
        $response = $this->actingAs($this->admin)->get('/education/students');

        $response->assertStatus(200);
    }

    public function test_create_returns_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/education/students/create');

        $response->assertStatus(200);
    }

    public function test_store_creates_student(): void
    {
        $program = Program::factory()->create();

        $response = $this->actingAs($this->admin)->post('/education/students', [
            'name'            => 'Test Student',
            'email'           => 'test@edu.com',
            'student_code'    => 'TST-001',
            'semester'        => 3,
            'status'          => 'active',
            'program_id'      => $program->id,
            'enrollment_date' => '2024-01-15',
        ]);

        $response->assertRedirect()->assertSessionHas('success');
        $this->assertDatabaseHas('students', ['email' => 'test@edu.com']);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->post('/education/students', []);

        $response->assertSessionHasErrors(['name', 'email', 'semester', 'status']);
    }

    public function test_show_displays_student(): void
    {
        $student = Student::factory()->create();

        $response = $this->actingAs($this->admin)->get("/education/students/{$student->id}");

        $response->assertStatus(200);
    }

    public function test_update_modifies_student(): void
    {
        $student = Student::factory()->create(['name' => 'Original']);

        $response = $this->actingAs($this->admin)->put("/education/students/{$student->id}", [
            'name'     => 'Updated',
            'email'    => $student->email,
            'semester' => 5,
            'status'   => 'active',
        ]);

        $response->assertRedirect()->assertSessionHas('success');
        $this->assertDatabaseHas('students', ['name' => 'Updated']);
    }

    public function test_destroy_removes_student(): void
    {
        $student = Student::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/education/students/{$student->id}");

        $response->assertRedirect()->assertSessionHas('success');
        $this->assertSoftDeleted($student);
    }

    public function test_teacher_can_access_students(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->get('/education/students');

        $response->assertStatus(200);
    }

    public function test_student_cannot_access_students_crud(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($student)->get('/education/students');

        $response->assertStatus(403);
    }
}
