<div>
    @if(!$emailSent)
        <div class="card card-primary">
            <div class="card-header">
                <h4>Forgot Password</h4>
            </div>

            <div class="card-body">
                <p class="text-muted">We will send a link to reset your password</p>
                
                <form wire:submit="sendResetLink" class="needs-validation" novalidate="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               wire:model="email" tabindex="1" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="2" 
                                wire:loading.attr="disabled" wire:loading.class="btn-secondary">
                            <span wire:loading.remove>Send Reset Link</span>
                            <span wire:loading>Sending...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="card card-success">
            <div class="card-header">
                <h4>Reset Link Sent!</h4>
            </div>

            <div class="card-body">
                <div class="text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Check Your Email</h5>
                    <p class="text-muted">
                        We have sent a password reset link to your email address. 
                        Please check your inbox and follow the instructions to reset your password.
                    </p>
                    <button wire:click="$set('emailSent', false)" class="btn btn-primary">
                        Send Another Link
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-5 text-muted text-center">
        <a href="{{ route('login') }}">Back to Login</a>
    </div>
</div>
