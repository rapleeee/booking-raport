@extends('layouts.admin')
@section('title', 'Profil Admin')
@section('header', 'Pengaturan Profil')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 sm:rounded-2xl">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 sm:rounded-2xl">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 sm:rounded-2xl">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
