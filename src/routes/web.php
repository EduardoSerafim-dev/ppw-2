<?php

use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StudioController;
use App\Models\Person;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });


Route::get('/', [HomeController::class, 'index']);
// Rota GET com retorno JSON
// Route::get('/ping', function () {
//     return response()->json(['status' => 'ok', 'versao' => '1.0']);
// });

// Rota POST
// Route::post('/dados', function () {
//     return response()->json(['mensagem' => 'Dados recebidos!']);
// });

// // Parâmetro obrigatório
// Route::get('/produtos/{id}', function (int $id) {
// return response()->json(['id' => $id, 'nome' => 'Produto ' . $id]);
// });

// Parâmetro opcional (com valor padrão)
// Route::get('/categorias/{slug?}', function (string $slug = 'todas') {
//     return response()->json(['categoria' => $slug]);
// });

// Restrição: aceita apenas números inteiros
// Route::get('/usuarios/{id}', function (int $id) {
//     return response()->json(['usuario_id' => $id]);
// })->whereNumber('id');

// // Agrupando rotas com prefixo e nome compartilhado
// Route::prefix('admin')->name('admin.')->group(function () {

// // URL: /admin/usuarios | nome: admin.usuarios
// Route::get('/usuarios', function () {
// return response()->json(['area' => 'admin']);
// })->name('usuarios');

// // URL: /admin/relatorios | nome: admin.relatorios
// Route::get('/relatorios', function () {
// return response()->json(['relatorio' => 'mensal']);
// })->name('relatorios');
// });


//==================================ATIVIDADE ===========================================

// Route::get('/produtos', function () {
// return response()->json([

//     ['id' => '1', 'Nome' => 'Tablet', 'Preço' => 'R$ 200'],
//     ['id' => '2', 'Nome' => 'Celular', 'Preço' => 'R$ 1500'],
//     ['id' => '3', 'Nome' => 'TV', 'Preço' => 'R$ 2450']

//     ]);
// });

// Route::get('/produtos/{id}', function (int $id) {
// return response()->json(['id' => $id, 'Nome' => 'Produto ' . $id]);
// });


// Route::get('/produtos/{id}/avaliacoes', function (int $id) {
//     return response()->json(['id' => $id, 'Nome' => 'Produto ' . $id, 'Avaliações' => 'Muito bom, Excelente, Confiável...']);
// });

// Route::post('/produtos', function () {
//     return response()->json(['Mensagem' => 'Produto criado com sucesso'], 201);
// });

// Route::delete('/produtos/{id}', function () {
//     return response()->json(['Mensagem' => 'Produto removido'], 200);
// });



// ======================Ligando rotas ao Controller===================================

// Route::get('/produtos', [ProdutoController::class, 'index']);
// Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
// Route::post('/produtos', [ProdutoController::class, 'store']);
// Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
// Route::put('/produtos/{id}', [ProdutoController::class, 'update']);

//Cria todas as rotas como acima, de acordo com o padrão REST, exceto as informadas.


// Grupo de rotas protegidas ==========================================================

Route::middleware(['auth', 'admin'])->group(function () {


    Route::resource('filmes', MovieController::class);

    Route::resource('estudios', StudioController::class);

    Route::resource('generos', GenreController::class);

    Route::get('/pessoas/buscar', [PersonController::class, 'buscar']);
    Route::resource('pessoas', PersonController::class);

    Route::resource('avaliacoes', ReviewController::class)->except(['create', 'store']);
    Route::get('/avaliacoes/create/{id_filme}', [ReviewController::class, 'create']);

    Route::delete(
        '/imagens/{imagem}/filme/{filme}',
        [ImageController::class, 'destroyFromFilme']
    );

    Route::get('/admin', function () {
        return view('admin');
    });
});

Route::post('/avaliacoes/{id_filme}', [ReviewController::class, 'store'])->middleware('auth');


// Rotas públicas — sem middleware ==================================================

Route::get('/filmes-p/{id}', [MovieController::class, 'show_public']);
Route::get('/pessoas-p/{id}', [PersonController::class, 'show_public']);

Route::get('/filmes/{id}/avaliacoes', [ReviewController::class, 'index']);

require __DIR__ . '/auth.php';
