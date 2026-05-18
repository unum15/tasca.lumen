# Tasca Lumen API

## Stack
- **Framework**: Laravel Lumen 8 (PHP 7.4+)
- **Database**: MySQL (via Eloquent ORM)
- **Auth**: Middleware-based (`auth` middleware on all protected routes)

## Project Structure
```
app/                    # Models (flat namespace App\)
app/Http/Controllers/   # Controllers
database/migrations/    # Laravel migrations
routes/web.php          # All route definitions
```

## Conventions

### Models
- Extend `Illuminate\Database\Eloquent\Model`
- Use `HasFactory` trait when a factory is needed
- `$fillable` array lists all writable fields
- Relationships named with underscores: `asset_type()`, `asset_brand()`

### Controllers
- Extend `App\Http\Controllers\Controller`
- Constructor always calls `$this->middleware('auth')`
- Five standard methods: `index`, `create`, `read`, `update`, `delete`
- Validation defined in `$model_validation` (types/rules) and `$model_validation_required` (required fields)
- `validateModel($request)` / `validateModel($request, true)` handles validation + field filtering
- `validateIncludes($request->input('includes'))` filters eager-load relationships via `$model_includes`
- `create` returns `201` with `Location` header; `delete` returns `204`
- All responses wrapped: `['data' => $item]`

### Routes (routes/web.php)
Pattern for a resource named `example_thing`:
```php
$router->get('/example_things', ['uses' => 'ExampleThingController@index', 'as' => 'example_thing.index']);
$router->post('/example_thing', ['uses' => 'ExampleThingController@create', 'as' => 'example_thing.create']);
$router->get('/example_thing/{id:[0-9]+}', ['uses' => 'ExampleThingController@read', 'as' => 'example_thing.read']);
$router->patch('/example_thing/{id:[0-9]+}', ['uses' => 'ExampleThingController@update', 'as' => 'example_thing.update']);
$router->delete('/example_thing/{id:[0-9]+}', ['uses' => 'ExampleThingController@delete', 'as' => 'example_thing.delete']);
```

### Migrations
- Use `$table->bigIncrements('id')`
- Timestamps: `$table->timestamp('created_at')->useCurrent()` and `updated_at` separately (not `timestamps()`)
- Foreign keys use `bigInteger` (not `unsignedBigInteger`) and are defined inside the same `Schema::create` callback
