<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\Lecturer;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CourseEventApiTest extends TestCase
{
    use RefreshDatabase;

    private function lecturerUser(): User
    {
        return User::factory()->create(['is_lecturer' => true]);
    }

    public function test_guest_cannot_create_course(): void
    {
        $lecturer = Lecturer::factory()->create();

        $this->postJson('/api/courses', [
            'lecturer_id' => $lecturer->id,
            'name'        => 'Specter Shield Lite Workshop',
        ])->assertUnauthorized();
    }

    public function test_non_lecturer_cannot_create_course(): void
    {
        Sanctum::actingAs(User::factory()->create(['is_lecturer' => false]));
        $lecturer = Lecturer::factory()->create();

        $this->postJson('/api/courses', [
            'lecturer_id' => $lecturer->id,
            'name'        => 'Specter Shield Lite Workshop',
        ])->assertForbidden();
    }

    public function test_lecturer_can_create_course(): void
    {
        Sanctum::actingAs($user = $this->lecturerUser());
        $lecturer = Lecturer::factory()->create();

        $response = $this->postJson('/api/courses', [
            'lecturer_id' => $lecturer->id,
            'name'        => 'Specter Shield Lite Workshop',
            'description' => 'Hardware-Wallet selbst bauen.',
        ]);

        $response->assertCreated()
            ->assertJsonPath('name', 'Specter Shield Lite Workshop');

        $this->assertDatabaseHas('courses', [
            'name'       => 'Specter Shield Lite Workshop',
            'created_by' => $user->id,
        ]);
    }

    public function test_lecturer_can_create_course_event(): void
    {
        Sanctum::actingAs($user = $this->lecturerUser());
        $course = Course::factory()->create();
        $venue  = Venue::factory()->create();

        $response = $this->postJson('/api/course-events', [
            'course_id' => $course->id,
            'venue_id'  => $venue->id,
            'from'      => '2026-07-01 18:00:00',
            'to'        => '2026-07-01 21:00:00',
            'link'      => 'https://clavastack.com/produkt/specter-shield-lite-workshop',
        ]);

        $response->assertCreated()
            ->assertJsonPath('course_id', $course->id);

        $this->assertDatabaseHas('course_events', [
            'course_id'  => $course->id,
            'venue_id'   => $venue->id,
            'created_by' => $user->id,
        ]);
    }

    public function test_course_event_validation_fails_without_required_fields(): void
    {
        Sanctum::actingAs($this->lecturerUser());

        $this->postJson('/api/course-events', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['course_id', 'venue_id', 'from', 'to', 'link']);
    }

    public function test_index_only_returns_own_course_events(): void
    {
        $other = User::factory()->create(['is_lecturer' => true]);
        $venue = Venue::factory()->create();
        $course = Course::factory()->create();
        CourseEvent::factory()->create([
            'course_id'  => $course->id,
            'venue_id'   => $venue->id,
            'created_by' => $other->id,
        ]);

        Sanctum::actingAs($mine = $this->lecturerUser());
        $ownEvent = CourseEvent::factory()->create([
            'course_id'  => $course->id,
            'venue_id'   => $venue->id,
            'created_by' => $mine->id,
        ]);

        $this->getJson('/api/course-events')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.id', $ownEvent->id);
    }
}
