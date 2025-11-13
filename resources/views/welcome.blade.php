{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html class="light" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - EasyPark</title>

  {{-- Tailwind via CDN (works out of the box). If you’re using Vite, swap this for @vite(['resources/css/app.css','resources/js/app.js']) --}}
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#4A90E2",
            "background-light": "#F4F6F8",
            "background-dark": "#101822",
            "text-light": "#333333",
            "text-dark": "#F4F6F8",
            "neutral-light": "#ffffff",
            "neutral-dark": "#18222e",
            "border-light": "#cfd9e8",
            "border-dark": "#334155",
            "placeholder-light": "#4b6c9b",
            "placeholder-dark": "#94a3b8",
          },
          fontFamily: { "display": ["Inter", "sans-serif"] },
          borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
        },
      },
    }
  </script>
</head>
<body class="font-display">
<div class="relative flex min-h-screen w-full flex-col bg-background-light dark:bg-background-dark overflow-x-hidden">
  <div class="layout-container flex h-full grow flex-col">
    <div class="flex h-full min-h-screen flex-1">
      <div class="flex flex-1 flex-col justify-center items-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">

          <div class="flex flex-col items-center mb-8">
            <svg class="h-10 w-auto text-primary" fill="currentColor" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M22 0C9.849 0 0 9.85 0 22s9.849 22 22 22 22-9.85 22-22S34.151 0 22 0zm10.353 23.993H26.01v10.342h-8.016V23.993h-6.342v-6.006h6.342v-5.65c0-4.99 2.502-7.794 7.66-7.794h5.025v6.006h-3.66c-2.001 0-2.164.834-2.164 2.33v4.77h5.824l-.824 6.005z"></path>
            </svg>
            <p class="mt-2 text-2xl font-bold text-text-light dark:text-text-dark">EasyPark</p>
          </div>

          <h1 class="text-text-light dark:text-text-dark tracking-tight text-3xl font-bold text-center">Log in to your Account</h1>

          <div class="mt-8">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
              @csrf

              {{-- Email --}}
              <label class="flex flex-col">
                <p class="text-text-light dark:text-text-dark text-base font-medium leading-normal pb-2">Email Address</p>
                <input
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-text-light dark:text-text-dark focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-border-light dark:border-border-dark bg-neutral-light dark:bg-neutral-dark h-12 placeholder:text-placeholder-light dark:placeholder:text-placeholder-dark p-[15px] text-base"
                  placeholder="you@example.com"
                  type="email"
                  name="email"
                  value="{{ old('email') }}"
                  autocomplete="email"
                  required
                />
                @error('email')
                  <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
              </label>

              {{-- Password --}}
              <label class="flex flex-col">
                <p class="text-text-light dark:text-text-dark text-base font-medium leading-normal pb-2">Password</p>
                <div class="flex w-full flex-1 items-stretch rounded-lg">
                  <input
                    id="password"
                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-text-light dark:text-text-dark focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-border-light dark:border-border-dark bg-neutral-light dark:bg-neutral-dark h-12 placeholder:text-placeholder-light dark:placeholder:text-placeholder-dark p-[15px] rounded-r-none border-r-0 pr-2 text-base"
                    placeholder="Enter your password"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    required
                  />
                  <button
                    type="button"
                    id="togglePassword"
                    class="text-placeholder-light dark:text-placeholder-dark flex border border-border-light dark:border-border-dark bg-neutral-light dark:bg-neutral-dark items-center justify-center pr-[15px] rounded-r-lg border-l-0"
                    aria-label="Toggle password visibility"
                  >
                    <span class="material-symbols-outlined">visibility</span>
                  </button>
                </div>
                @error('password')
                  <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
              </label>

              {{-- Remember / Forgot --}}
              <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-text-light dark:text-text-dark">
                  <input type="checkbox" name="remember" class="rounded border-border-light dark:border-border-dark text-primary focus:ring-primary/50">
                  Remember me
                </label>

                @if (Route::has('password.request'))
                  <a class="text-sm font-medium text-primary hover:text-primary/80" href="{{ route('password.request') }}">Forgot Password?</a>
                @endif
              </div>

              {{-- Submit --}}
              <div>
                <button type="submit" class="flex w-full justify-center items-center h-12 px-6 py-3 rounded-lg bg-primary text-white text-base font-semibold leading-normal shadow-sm hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary/50">
                  Login
                </button>
              </div>

              {{-- Global auth error (e.g., invalid credentials) --}}
              @if ($errors->has('auth'))
                <p class="text-sm text-red-600">{{ $errors->first('auth') }}</p>
              @endif
            </form>

            <div class="mt-6 text-center text-sm text-placeholder-light dark:text-placeholder-dark">
              Don't have an account?
              @if (Route::has('register'))
                <a class="font-semibold text-primary hover:text-primary/80" href="{{ route('register') }}">Sign Up</a>
              @else
                <a class="font-semibold text-primary hover:text-primary/80" href="#">Sign Up</a>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- Right-side image --}}
      <div class="relative hidden w-0 flex-1 lg:block">
        <div
          class="absolute inset-0 h-full w-full bg-center bg-no-repeat bg-cover"
          data-alt="Abstract image of a modern, well-lit underground parking garage with clean lines and a minimalist aesthetic."
          style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCLaEFaMpLzSQssIgFtRmLwg9Z0bknl9c-i3hau_XGkDppFmnxmGQrQbSyMYEHWdl0kdApHjWm6R8kv7nU_RFaebBj-dHQtpdKfrbAYkBtWyeP7UxrzWk1MHoXvlmzgj5VMUS-ztgg4ztXjsojlNhy2dNbeTflYm1J-_B96c4aZ_IuTk3bmZm1T4qdffuX7MzI7N7uoDsKKJdr-imAzShvNuwaXb5KxaoDy7MViyLHrNKJKr-youGsmvVrfd61puJjBhCWo6MXlVIs");'>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Toggle password visibility
  (function () {
    const btn = document.getElementById('togglePassword');
    const input = document.getElementById('password');
    if (btn && input) {
      btn.addEventListener('click', function () {
        const isPw = input.getAttribute('type') === 'password';
        input.setAttribute('type', isPw ? 'text' : 'password');
        const icon = this.querySelector('.material-symbols-outlined');
        if (icon) icon.textContent = isPw ? 'visibility_off' : 'visibility';
      });
    }
    // Optional: respect system dark mode
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      document.documentElement.classList.add('dark');
      document.documentElement.classList.remove('light');
    }
  })();
</script>
</body>
</html>
