<?php

use App\Contact;
use App\Permission;
use App\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    protected ?TestResponse $lastResponse = null;

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }

    protected function createTestResponse($response)
    {
        $testResponse = parent::createTestResponse($response);
        $this->lastResponse = $testResponse;
        return $testResponse;
    }

    public function setUp(): void
    {
        parent::setUp();

        TestResponse::macro('seeStatusCode', function (int $code) {
            return $this->assertStatus($code);
        });

        TestResponse::macro('seeJson', function (array $data) {
            $content = $this->json();
            $found = static function ($haystack, $needle) use (&$found) {
                if (!is_array($haystack)) {
                    return false;
                }
                $match = true;
                foreach ($needle as $key => $value) {
                    if (!array_key_exists($key, $haystack) || $haystack[$key] != $value) {
                        $match = false;
                        break;
                    }
                }
                if ($match) {
                    return true;
                }
                foreach ($haystack as $child) {
                    if ($found($child, $needle)) {
                        return true;
                    }
                }
                return false;
            };
            Assert::assertTrue(
                $found($content, $data),
                "Unable to find JSON:\n" . json_encode($data, JSON_PRETTY_PRINT) .
                "\nwithin response JSON:\n" . $this->getContent()
            );
            return $this;
        });

        TestResponse::macro('seeJsonEquals', function (array $data) {
            $actual = json_encode(Illuminate\Support\Arr::sortRecursive(
                (array) $this->json()
            ));
            Assert::assertEquals(
                json_encode(Illuminate\Support\Arr::sortRecursive($data)),
                $actual
            );
            return $this;
        });

        TestResponse::macro('dontSeeJson', function (array $data) {
            return $this->assertJsonMissing($data);
        });

        TestResponse::macro('assertNotNull', function ($value, string $message = '') {
            Assert::assertNotNull($value, $message);
            return $this;
        });
    }

    public function seeJson(array $data)
    {
        Assert::assertNotNull($this->lastResponse, 'No response available');
        $this->lastResponse->seeJson($data);
        return $this;
    }

    public function seeStatusCode(int $code)
    {
        Assert::assertNotNull($this->lastResponse, 'No response available');
        $this->lastResponse->assertStatus($code);
        return $this;
    }

    public function notSeeInDatabase(string $table, array $data)
    {
        $this->assertDatabaseMissing($table, $data);
        return $this;
    }

    public function seeInDatabase(string $table, array $data)
    {
        // Normalize ISO 8601 timestamps to Y-m-d H:i:s for DB comparison
        $normalized = array_map(function ($value) {
            if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $value)) {
                return \Carbon\Carbon::parse($value)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s');
            }
            return $value;
        }, $data);
        $this->assertDatabaseHas($table, $normalized);
        return $this;
    }

    public function getAdminUser()
    {
        $user = Contact::where('login', 'admin@example.com')->first();
        if (empty($user)) {
            $user = Contact::factory(['login' => 'admin@example.com'])->create();
        }

        $admin = Role::firstOrCreate(['name' => 'admin'], ['display_name' => 'Admin']);

        foreach (['edit-settings', 'edit-clients', 'edit-crews', 'view-clients'] as $permName) {
            $perm = Permission::firstOrCreate(['name' => $permName], ['display_name' => $permName]);
            if (!$admin->permissions()->where('name', $permName)->exists()) {
                $admin->permissions()->attach($perm);
            }
        }

        if (!$user->roles()->where('name', 'admin')->exists()) {
            $user->roles()->attach($admin);
        }

        return $user;
    }
}
