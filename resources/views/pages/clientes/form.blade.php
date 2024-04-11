@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
		<form-client :client-prop="{{ isset($client) ? json_encode($client) : json_encode([]) }}" />
@endsection

			