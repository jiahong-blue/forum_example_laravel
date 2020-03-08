@extends('layouts.app')

@section('content')
    <div id="app">
        <navbar-component></navbar-component>
        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
@endsection