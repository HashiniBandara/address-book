@extends('user.profile.layout')

@section('content')
    {{-- @extends('user.user_dashboard')
@section('user') --}}

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Profile Information') }}
            </h2>
        </div>
        <div class="card-body">
            <p class="mt-1 text-sm text-gray-600">
                {{ __("Update your account's profile information and email address.") }}
            </p>
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('user.profile.update') }}" class="mt-6 space-y-6"
                enctype="multipart/form-data">

                {{-- <form method="post" action="{{ route('superadmin.profile.update') }}" class="mt-6 space-y-6"> --}}
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label class="form-label">{{ __('Profile Photo') }}</label>
                    @if ($user->profile_image)
                        <div class="mb-2">
                            {{-- <img src="{{ asset('images/' . $user->profile_image) }}" alt="Profile Photo" class="img-thumbnail" width="20%"> --}}
                            <img src="{{ asset($user->profile_image) }}" alt="Profile Photo" class="img-thumbnail"
                                width="20%">
                        </div>
                        <div>
                            <p class="text-muted">{{ __('Current Profile Image') }}</p>
                        </div>
                    @else
                        <p class="text-muted">{{ __('Profile Image currently not available') }}</p>
                    @endif

                    <input id="profile_image" name="profile_image" type="file" class="form-control">
                    <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
                </div>


                {{-- <div class="mb-3">
                <label for="profile_photo" class="form-label">{{ __('Profile Photo') }}</label>
                <input id="profile_photo" name="profile_photo" type="file" class="form-control">
                <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
            </div> --}}


                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" name="name" type="text" class="form-control"
                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" name="email" type="email" class="form-control bg-gray-200" readonly
                        value="{{ old('email', $user->email) }}" required autocomplete="username">
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-sm text-gray-800">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification" class="btn btn-link p-0">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-success">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-4">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-success">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Profile Information') }}
            </h2>
        </div>
        <div class="card-body">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Update Password') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                    <input id="current_password" name="current_password" type="password" class="form-control"
                        autocomplete="current-password">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('New Password') }}</label>
                    <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control"
                        autocomplete="new-password">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="d-flex align-items-center gap-4">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-success">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>

@endsection
