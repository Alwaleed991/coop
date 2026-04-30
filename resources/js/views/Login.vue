<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-100 via-teal-50 to-sky-100 p-4 relative overflow-hidden">

    <!-- Ambient blobs -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-300 rounded-full mix-blend-multiply filter blur-3xl opacity-25 animate-pulse"></div>
    <div class="absolute -top-12 -right-24 w-80 h-80 bg-teal-300 rounded-full mix-blend-multiply filter blur-3xl opacity-25 animate-pulse" style="animation-delay:1.2s"></div>
    <div class="absolute -bottom-24 left-1/3 w-96 h-96 bg-sky-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay:2.4s"></div>

    <!-- Two-column layout wrapper -->
    <div class="relative z-10 flex items-center justify-center w-full max-w-5xl gap-6 lg:gap-14">

      <!-- Illustration — hidden on mobile -->
      <div class="hidden lg:flex flex-1 items-center justify-center">
        <div class="float-bob w-full max-w-md select-none pointer-events-none">
          <svg viewBox="0 0 460 560" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-xl">
            <defs>
              <radialGradient id="bgBlob" cx="50%" cy="60%" r="55%">
                <stop offset="0%" stop-color="#a7f3d0" stop-opacity="0.55"/>
                <stop offset="100%" stop-color="#d1fae5" stop-opacity="0.0"/>
              </radialGradient>
            </defs>

            <!-- Soft ambient backdrop -->
            <ellipse cx="230" cy="320" rx="200" ry="215" fill="url(#bgBlob)"/>

            <!-- Ground shadow -->
            <ellipse cx="226" cy="534" rx="112" ry="18" fill="#6ee7b7" opacity="0.38"/>

            <!-- ===== LEGS ===== -->
            <rect x="163" y="392" width="46" height="118" rx="23" fill="#0f766e"/>
            <rect x="252" y="392" width="46" height="118" rx="23" fill="#0f766e"/>

            <!-- Feet -->
            <ellipse cx="186" cy="509" rx="36" ry="16" fill="#115e59"/>
            <ellipse cx="275" cy="509" rx="36" ry="16" fill="#115e59"/>

            <!-- ===== TORSO ===== -->
            <rect x="126" y="248" width="208" height="158" rx="44" fill="#0d9488"/>
            <!-- Hoodie center seam -->
            <rect x="224" y="260" width="12" height="138" rx="6" fill="#0b8276" opacity="0.45"/>
            <!-- Hoodie collar shape -->
            <path d="M192 252 Q230 278 268 252" fill="#0a6e64" opacity="0.55"/>

            <!-- ===== LEFT ARM ===== -->
            <!-- Upper arm -->
            <rect x="72" y="254" width="72" height="44" rx="22" fill="#0d9488" transform="rotate(24 108 276)"/>
            <!-- Forearm -->
            <rect x="90" y="302" width="70" height="40" rx="20" fill="#0d9488" transform="rotate(-5 125 322)"/>
            <!-- Hand -->
            <circle cx="160" cy="330" r="23" fill="#fde68a"/>

            <!-- ===== RIGHT ARM ===== -->
            <!-- Upper arm -->
            <rect x="316" y="254" width="72" height="44" rx="22" fill="#0d9488" transform="rotate(-24 352 276)"/>
            <!-- Forearm -->
            <rect x="300" y="302" width="70" height="40" rx="20" fill="#0d9488" transform="rotate(5 335 322)"/>
            <!-- Hand -->
            <circle cx="300" cy="330" r="23" fill="#fde68a"/>

            <!-- ===== PHONE ===== -->
            <!-- Phone body -->
            <rect x="170" y="266" width="120" height="208" rx="18" fill="#134e4a"/>
            <!-- Camera bump -->
            <rect x="212" y="262" width="36" height="9" rx="4.5" fill="#0c3030" opacity="0.75"/>
            <!-- Screen -->
            <rect x="179" y="278" width="102" height="182" rx="12" fill="#0891b2"/>
            <!-- Screen top sheen -->
            <rect x="179" y="278" width="102" height="36" rx="12" fill="white" opacity="0.06"/>
            <!-- Home indicator -->
            <rect x="213" y="472" width="34" height="6" rx="3" fill="white" opacity="0.22"/>

            <!-- Screen UI — status bar -->
            <rect x="187" y="287" width="40" height="4" rx="2" fill="white" opacity="0.28"/>
            <circle cx="264" cy="289" r="4.5" fill="#34d399" opacity="0.9"/>
            <circle cx="253" cy="289" r="4.5" fill="#67e8f9" opacity="0.7"/>

            <!-- Profile header row -->
            <circle cx="197" cy="311" r="12" fill="#34d399"/>
            <circle cx="197" cy="311" r="8"  fill="#065f46"/>
            <rect x="214" y="305" width="52" height="5" rx="2.5" fill="white" opacity="0.55"/>
            <rect x="214" y="314" width="34" height="4" rx="2" fill="white" opacity="0.32"/>

            <!-- Post image block -->
            <rect x="185" y="332" width="90" height="64" rx="9" fill="#0e7490" opacity="0.65"/>
            <rect x="185" y="332" width="90" height="22" rx="9" fill="white" opacity="0.04"/>
            <!-- Photo icon hint -->
            <circle cx="210" cy="357" r="10" fill="white" opacity="0.12"/>
            <polygon points="220,348 238,364 202,364" fill="white" opacity="0.15"/>

            <!-- Engagement row -->
            <circle cx="192" cy="411" r="7" fill="#fb7185"/>
            <rect x="203" y="408" width="24" height="5" rx="2.5" fill="white" opacity="0.38"/>
            <circle cx="242" cy="411" r="7" fill="#67e8f9" opacity="0.85"/>
            <rect x="253" y="408" width="16" height="5" rx="2.5" fill="white" opacity="0.28"/>

            <!-- Second mini post -->
            <rect x="185" y="428" width="90" height="26" rx="7" fill="white" opacity="0.08"/>
            <circle cx="196" cy="441" r="8" fill="#6ee7b7"/>
            <rect x="209" y="437" width="52" height="4.5" rx="2.25" fill="white" opacity="0.42"/>
            <rect x="209" y="446" width="36" height="4.5" rx="2.25" fill="white" opacity="0.25"/>

            <!-- ===== NECK ===== -->
            <rect x="204" y="214" width="52" height="42" rx="21" fill="#fde68a"/>

            <!-- ===== HEAD ===== -->
            <!-- Ears -->
            <ellipse cx="138" cy="166" rx="17" ry="22" fill="#fde68a"/>
            <ellipse cx="322" cy="166" rx="17" ry="22" fill="#fde68a"/>
            <ellipse cx="138" cy="166" rx="9"  ry="14" fill="#fbbf24" opacity="0.32"/>
            <ellipse cx="322" cy="166" rx="9"  ry="14" fill="#fbbf24" opacity="0.32"/>

            <!-- Head -->
            <circle cx="230" cy="150" r="92" fill="#fde68a"/>

            <!-- Hair top mass -->
            <path d="M144 150 Q152 56 230 44 Q308 56 316 150 Q304 104 230 98 Q156 104 144 150Z" fill="#064e3b"/>
            <!-- Hair side curtains -->
            <path d="M144 150 Q142 122 148 100" stroke="#064e3b" stroke-width="14" fill="none" stroke-linecap="round"/>
            <path d="M316 150 Q318 122 312 100" stroke="#064e3b" stroke-width="14" fill="none" stroke-linecap="round"/>
            <!-- Subtle hair highlight -->
            <path d="M194 62 Q210 54 228 58" stroke="#0d9488" stroke-width="5" fill="none" stroke-linecap="round" opacity="0.38"/>

            <!-- Left eye -->
            <circle cx="198" cy="156" r="17" fill="white"/>
            <circle cx="200" cy="157" r="11" fill="#065f46"/>
            <circle cx="202" cy="155" r="6"  fill="#0a0a0a"/>
            <circle cx="205" cy="153" r="3.5" fill="white"/>
            <!-- Right eye -->
            <circle cx="262" cy="156" r="17" fill="white"/>
            <circle cx="264" cy="157" r="11" fill="#065f46"/>
            <circle cx="266" cy="155" r="6"  fill="#0a0a0a"/>
            <circle cx="269" cy="153" r="3.5" fill="white"/>

            <!-- Eyebrows — friendly arc -->
            <path d="M183 134 Q198 123 215 132" stroke="#064e3b" stroke-width="5.5" fill="none" stroke-linecap="round"/>
            <path d="M245 132 Q262 123 277 134" stroke="#064e3b" stroke-width="5.5" fill="none" stroke-linecap="round"/>

            <!-- Big smile -->
            <path d="M198 184 Q230 218 262 184" stroke="#d97706" stroke-width="5.5" fill="none" stroke-linecap="round"/>
            <!-- Teeth fill -->
            <path d="M200 185 Q230 214 260 185 Q230 207 200 185Z" fill="white" opacity="0.52"/>

            <!-- Cheeks -->
            <ellipse cx="178" cy="182" rx="22" ry="13" fill="#f97316" opacity="0.17"/>
            <ellipse cx="282" cy="182" rx="22" ry="13" fill="#f97316" opacity="0.17"/>

            <!-- ===== FLOATING DECORATIONS ===== -->

            <!-- Like / heart notification -->
            <rect x="326" y="78" width="122" height="44" rx="22" fill="#10b981"/>
            <text x="344" y="106" font-size="15" fill="white" font-family="system-ui,-apple-system,sans-serif" font-weight="700">❤️  +1.2K</text>
            <polygon points="334,122 328,142 358,122" fill="#10b981"/>

            <!-- Comment bubble (left) -->
            <rect x="10" y="182" width="104" height="46" rx="14" fill="#0d9488" opacity="0.88"/>
            <polygon points="14,228 7,248 42,228" fill="#0d9488" opacity="0.88"/>
            <rect x="22" y="195" width="76" height="5" rx="2.5" fill="white" opacity="0.55"/>
            <rect x="22" y="207" width="52" height="5" rx="2.5" fill="white" opacity="0.38"/>

            <!-- Follower badge (right) -->
            <rect x="336" y="312" width="108" height="38" rx="19" fill="#0d9488" opacity="0.72"/>
            <text x="352" y="336" font-size="13" fill="white" font-family="system-ui,-apple-system,sans-serif" font-weight="600">👥 3.5K</text>

            <!-- Star — top left -->
            <polygon points="56,100 60,113 74,113 63,121 67,134 56,126 45,134 49,121 38,113 52,113" fill="#34d399" opacity="0.72"/>
            <!-- Star — mid right -->
            <polygon points="414,196 417,205 427,205 419,211 422,220 414,215 406,220 409,211 401,205 411,205" fill="#6ee7b7" opacity="0.65"/>
            <!-- Star — bottom left -->
            <polygon points="50,420 52,427 60,427 54,431 56,438 50,434 44,438 46,431 40,427 48,427" fill="#a7f3d0" opacity="0.75"/>

            <!-- WiFi arcs — bottom right -->
            <path d="M392,436 Q406,422 420,436" stroke="#10b981" stroke-width="4.5" fill="none" stroke-linecap="round" opacity="0.88"/>
            <path d="M384,428 Q406,408 428,428" stroke="#34d399" stroke-width="4"   fill="none" stroke-linecap="round" opacity="0.62"/>
            <path d="M376,420 Q406,394 436,420" stroke="#6ee7b7" stroke-width="3.5" fill="none" stroke-linecap="round" opacity="0.42"/>
            <circle cx="406" cy="444" r="5" fill="#10b981"/>

            <!-- Dot cluster — left edge -->
            <circle cx="34"  cy="332" r="10" fill="#34d399" opacity="0.42"/>
            <circle cx="56"  cy="308" r="7"  fill="#6ee7b7" opacity="0.48"/>
            <circle cx="43"  cy="288" r="5"  fill="#a7f3d0" opacity="0.55"/>
          </svg>
        </div>
      </div>

      <!-- Glassmorphism card -->
      <div class="card-enter relative w-full max-w-md bg-white/60 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/60 px-8 py-10">

        <!-- Inner card glow ring -->
        <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-white/40 to-transparent pointer-events-none"></div>

        <!-- Logo -->
        <div class="flex flex-col items-center mb-8">
          <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 flex items-center justify-center shadow-xl shadow-emerald-200 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
          </div>
          <h1 class="text-2xl font-black tracking-tight bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-500 bg-clip-text text-transparent">
            Coop
          </h1>
          <p class="text-gray-400 text-sm mt-1 font-medium">Welcome back — sign in to continue</p>
        </div>

        <!-- Social login buttons -->
        <div class="space-y-2.5 mb-6">
          <!-- Google -->
          <button type="button" class="social-btn w-full flex items-center justify-center gap-3 py-2.5 px-4 rounded-2xl border border-gray-200/80 bg-white/80 hover:bg-white hover:shadow-md hover:scale-[1.015] active:scale-[0.99] transition-all duration-200 text-sm font-semibold text-gray-600 shadow-sm">
            <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24">
              <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
              <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
              <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
              <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Continue with Google
          </button>

          <!-- Facebook -->
          <button type="button" class="social-btn w-full flex items-center justify-center gap-3 py-2.5 px-4 rounded-2xl border border-gray-200/80 bg-white/80 hover:bg-white hover:shadow-md hover:scale-[1.015] active:scale-[0.99] transition-all duration-200 text-sm font-semibold text-gray-600 shadow-sm">
            <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="#1877F2">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            Continue with Facebook
          </button>

          <!-- Twitter / X -->
          <button type="button" class="social-btn w-full flex items-center justify-center gap-3 py-2.5 px-4 rounded-2xl border border-gray-200/80 bg-white/80 hover:bg-white hover:shadow-md hover:scale-[1.015] active:scale-[0.99] transition-all duration-200 text-sm font-semibold text-gray-600 shadow-sm">
            <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="#0F1419">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.74l7.73-8.835L1.254 2.25H8.08l4.259 5.631zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
            Continue with X (Twitter)
          </button>
        </div>

        <!-- Divider -->
        <div class="relative flex items-center mb-6">
          <div class="flex-grow h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
          <span class="mx-4 text-xs font-semibold text-gray-400 uppercase tracking-widest">or</span>
          <div class="flex-grow h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        </div>

        <!-- Login Form -->
        <form @submit.prevent="handleLogin" class="space-y-4">

          <!-- Email -->
          <div class="form-field">
            <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
              Email address
            </label>
            <div class="relative">
              <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </span>
              <input
                v-model="email"
                type="email"
                id="email"
                required
                placeholder="you@example.com"
                class="block w-full pl-10 pr-4 py-3 rounded-2xl bg-white/70 border border-gray-200 text-gray-900 placeholder:text-gray-300 text-sm focus:outline-none focus:border-teal-400 focus:ring-3 focus:ring-teal-400/20 focus:bg-white transition-all duration-300"
              />
            </div>
          </div>

          <!-- Password -->
          <div class="form-field">
            <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
              Password
            </label>
            <div class="relative">
              <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </span>
              <input
                v-model="password"
                type="password"
                id="password"
                required
                placeholder="••••••••"
                class="block w-full pl-10 pr-4 py-3 rounded-2xl bg-white/70 border border-gray-200 text-gray-900 placeholder:text-gray-300 text-sm focus:outline-none focus:border-teal-400 focus:ring-3 focus:ring-teal-400/20 focus:bg-white transition-all duration-300"
              />
            </div>
          </div>

          <!-- Error -->
          <div v-if="error" class="flex items-start gap-2.5 rounded-2xl bg-red-50 border border-red-100 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm text-red-600 font-medium">{{ error }}</p>
          </div>

          <!-- Submit -->
          <button
            type="submit"
            :disabled="loading"
            class="group relative w-full flex items-center justify-center gap-2 py-3.5 px-4 mt-2 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 text-white text-sm font-bold shadow-xl shadow-emerald-200 hover:shadow-emerald-300 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed disabled:scale-100 disabled:shadow-none overflow-hidden"
          >
            <span class="absolute inset-0 bg-white/10 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-500 skew-x-12"></span>
            <svg v-if="loading" class="animate-spin w-4 h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span>{{ loading ? 'Signing in...' : 'Sign in' }}</span>
          </button>
        </form>

        <!-- Register link -->
        <p class="mt-7 text-center text-sm text-gray-400">
          Don't have an account?
          <router-link
            :to="{ name: 'register' }"
            class="font-bold bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent hover:opacity-80 transition-opacity duration-200 ml-1"
          >
            Sign up free
          </router-link>
        </p>
      </div>

    </div><!-- end two-column wrapper -->
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: '',
      error: '',
      loading: false,
    }
  },
  methods: {
    async handleLogin() {
      this.error = ''
      this.loading = true
// if your page was loaded from: http://localhost:8000/login When the browser sees: fetch('/api/v1/login') it automatically converts it to: http://localhost:8000/api/v1/login So the browser adds the host and port automatically. Example If the current page is: http://localhost:8000/login and you run: fetch('/api/v1/login') the browser sends the request to: http://localhost:8000/api/v1/login
      try {
        const response = await fetch('/api/v1/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        })

        const data = await response.json()

        if (response.ok) {
          localStorage.setItem('token', data.token)

          localStorage.setItem('user', JSON.stringify(data.user))

          this.$router.push({ name: 'home' })
        } else {
          this.error = data.message
        }
      } catch (err) {
        this.error = 'Network error. Please check the backend and try again.'
        console.error('Login error:', err)
      } finally {
        this.loading = false
      }
    },
  },
}
</script>

<style scoped>
/* Card entrance */
.card-enter {
  animation: cardEnter 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
}
@keyframes cardEnter {
  from { opacity: 0; transform: translateY(28px) scale(0.97); }
  to   { opacity: 1; transform: translateY(0)    scale(1);    }
}

/* Illustration gentle float */
.float-bob {
  animation: floatBob 4s ease-in-out infinite;
}
@keyframes floatBob {
  0%, 100% { transform: translateY(0px);   }
  50%       { transform: translateY(-18px); }
}

/* Staggered form fields */
.form-field:nth-child(1) { animation: fieldIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.2s  both; }
.form-field:nth-child(2) { animation: fieldIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.32s both; }
@keyframes fieldIn {
  from { opacity: 0; transform: translateX(-12px); }
  to   { opacity: 1; transform: translateX(0);     }
}

/* Social button stagger */
.social-btn:nth-child(1) { animation: fieldIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.1s  both; }
.social-btn:nth-child(2) { animation: fieldIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.18s both; }
.social-btn:nth-child(3) { animation: fieldIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) 0.26s both; }
</style>
