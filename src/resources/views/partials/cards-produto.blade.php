<div class='col-md-4'>
    <div class='card h-100 shadow-sm'>
        <div class='card-body'>
            <h5 class='card-title'>{{ $produto->nome}}</h5>
            <p class='card-text text-muted'>
                R$ {{ number_format($produto->preco, 2, ',', '.') }}
            </p>
        </div>
        <div class='card-footer'>
            <div class="d-flex">
                <a href='/produtos/{{ $produto->id }}' class='btn btn-primary btn-sm'>
                    Ver detalhes
                </a>
                <a href='/produtos/{{ $produto->id }}/edit' class='btn btn-success btn-sm'>
                    Editar
                </a>
                <form action="/produtos/{{ $produto->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>