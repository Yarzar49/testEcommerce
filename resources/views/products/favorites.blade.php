@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Favorite Products</h2>

        @if($favorites && count($favorites) > 0)
            <ul>
                @foreach($favorites as $favorite)
                    <li>{{ $favorite->product->name }}</li>
                @endforeach
            </ul>
        @else
            <p>No favorite products yet.</p>
        @endif
    </div>
@endsection
