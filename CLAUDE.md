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
- Relationships named with underscores: `asset_type()`, `asset_set_size_type()`

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
Pattern for a resource named `asset_set`:
```php
$router->get('/asset_sets', ['uses' => 'AssetSetController@index', 'as' => 'asset_set.index']);
$router->post('/asset_set', ['uses' => 'AssetSetController@create', 'as' => 'asset_set.create']);
$router->get('/asset_set/{id:[0-9]+}', ['uses' => 'AssetSetController@read', 'as' => 'asset_set.read']);
$router->patch('/asset_set/{id:[0-9]+}', ['uses' => 'AssetSetController@update', 'as' => 'asset_set.update']);
$router->delete('/asset_set/{id:[0-9]+}', ['uses' => 'AssetSetController@delete', 'as' => 'asset_set.delete']);
```

### Migrations
- Use `$table->bigIncrements('id')`
- Timestamps: `$table->timestamp('created_at')->useCurrent()` and `updated_at` separately (not `timestamps()`)
- Foreign keys use `bigInteger` (not `unsignedBigInteger`) and are defined inside the same `Schema::create` callback

## Active Branch: feature/112-sets
Adding `asset_set_size_types` and `asset_sets` tables/resources. Migrations already exist. Missing: models, controllers, routes.
