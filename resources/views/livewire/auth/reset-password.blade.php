<div>
    @if (!$passwordReset)
        <div class="card card-primary">
            <div class="card-header">
                <h4>Reset Password</h4>
            </div>

            <div class="card-body">
                <p class="text-muted">Enter your new password below</p>

                <form wire:submit="resetPassword" class="needs-validation" novalidate="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" tabindex="1" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" tabindex="2" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model="password_confirmation" tabindex="3" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" wire:loading.attr="disabled" wire:loading.class="btn-secondary">
                            <span wire:loading.remove>Reset Password</span>
                            <span wire:loading>Resetting...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="card card-success">
            <div class="card-header">
                <h4>Password Reset Successfully!</h4>
            </div>

            <div class="card-body">
                <div class="text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Password Updated</h5>
                    <p class="text-muted">
                        Your password has been reset successfully. You can now login with your new password.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Go to Login
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
