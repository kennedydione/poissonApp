{{-- resources/views/senpoisson.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sama-dieun</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

   {{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-white" href="{{ route('home') }}">sama-dieun</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Exemple onglet actif -->
                <li class="nav-item">
                    <a class="nav-link active bg-white text-primary rounded px-3" href="#">Qui sommes nous</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('fish.index') }}">Poissons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Fruits de Mer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Produits transformés</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Livraison</a>
                </li>
            </ul>
            <div class="d-flex">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Se connecter</a>
                    <a href="{{ route('register') }}" class="btn btn-danger me-2">S'inscrire</a>
                @endguest
                
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light me-2">Dashboard</a>
                        <a href="{{ route('admin.supervision') }}" class="btn btn-info me-2">Supervision</a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-warning me-2">Utilisateurs</a>
                        <a href="{{ route('admin.fish.index') }}" class="btn btn-primary me-2">Poissons</a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-success me-2">Commandes</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light me-2">Mon Profil</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Se déconnecter</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

    {{-- Bannière --}}
    <div class="jumbotron text-center bg-light py-5">
        <h1 class="display-5">N°1 de la distribution de produits halieutiques au Sénégal</h1>
        <p class="lead">Un service de qualité, des produits d'exception, une livraison express en 3h.</p>
        <form class="d-flex justify-content-center mt-3" action="{{ route('fish.index') }}" method="GET">
            <input type="text" name="search" class="form-control w-25 me-2" placeholder="Rechercher un produit">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>
    </div>

    {{-- Produits --}}
    <div class="container my-5">
        <div class="text-center mb-4">
            <a href="{{ route('fish.index') }}" class="btn btn-primary btn-lg">Voir tous nos poissons</a>
        </div>
        
        @php
        $fish = \App\Models\Fish::take(6)->get();
        @endphp
        
        @if($fish->count() > 0)
        <div class="row">
            @foreach($fish as $f)
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    @if($f->image && file_exists(public_path('images/' . $f->image)))
                        <img src="{{ asset('images/' . $f->image) }}" alt="{{ $f->name }}" class="rounded-3 shadow-sm w-100" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/thiof.jpg') }}" alt="{{ $f->name }}" class="rounded-3 shadow-sm w-100" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $f->name }}</h5>
                        <p class="card-text">{{ number_format($f->price_per_kg, 0, ',', ' ') }} CFA / kg</p>
                        <p class="card-text text-muted small">{{ $f->quantity_available }} kg disponible</p>
                        <a href="{{ route('fish.show', $f->id) }}" class="btn btn-sm btn-primary">Commander</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center text-muted py-5">
            <p>Aucun poisson disponible pour le moment.</p>
        </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3">
        <p>Dakar, Joal, Yarah...</p>
        <p>Tel: 77-190-70-71 | Email: dioneibrahima0109@gmail.com</p>
        <p>&copy; {{ date('Y') }} sama-dieun - Tous droits réservés</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
