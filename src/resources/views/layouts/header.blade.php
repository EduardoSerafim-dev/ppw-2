<nav style="background-color: #a0d6fa;" data-bs-theme="light" class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">CineReview</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-outline-dark mx-1 mb-1" aria-current="page" href="/">
                        Início
                    </a>
                </li>
                {{-- @isset($generos)
                    <li class="nav-item dropdown">
                        <a class="btn btn-outline-dark dropdown-toggle mx-1 mb-1" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Gêneros
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($generos as $genero)
                                <li><a class="dropdown-item" href="#">{{ $genero->nome }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endisset --}}
                @auth
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="btn btn-outline-dark mx-1 mb-1" aria-current="page" href="/filmes">
                                Filmes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-dark mx-1 mb-1" aria-current="page" href="/pessoas">
                                Pessoas
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
            {{-- <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Procurar" aria-label="Procurar" />
                <button class="btn btn-outline-dark"><i class="bi bi-search"></i></button>
            </form> --}}
            <form action="{{ route('pesquisa') }}" method="GET" class="d-flex" role="search">
                <input type="search" name="busca" class="form-control w-100 " value="{{ request('busca') }}"
                    placeholder="Procurar" aria-label="Procurar" />
                <button type="submit" class="btn btn-outline-dark mx-1"><i class="bi bi-search"></i></button>
            </form>
            @auth
                @include('partials.menu-perfil-autenticado')
            @endauth
            @guest
                @include('partials.menu-perfil-nao-autenticado')
            @endguest
        </div>
    </div>
</nav>
