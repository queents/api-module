
Route::get('{{ lcfirst($model) }}/index', [Modules\{{ $module }}\Http\Controllers\Api\{{ $model }}ApiController::class,'index'])->name('{{ lcfirst($model) }}.index');
Route::get('{{ lcfirst($model) }}/show', [Modules\{{ $module }}\Http\Controllers\Api\{{ $model }}ApiController::class,'show'])->name('{{ lcfirst($model) }}.show');
Route::post('{{ lcfirst($model) }}/store', [Modules\{{ $module }}\Http\Controllers\Api\{{ $model }}ApiController::class,'store'])->name('{{ lcfirst($model) }}.store');
Route::post('{{ lcfirst($model) }}/update', [Modules\{{ $module }}\Http\Controllers\Api\{{ $model }}ApiController::class,'update'])->name('{{ lcfirst($model) }}.update');
Route::post('{{ lcfirst($model) }}/delete', [Modules\{{ $module }}\Http\Controllers\Api\{{ $model }}ApiController::class,'delete'])->name('{{ lcfirst($model) }}.delete');

