<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <title>{{ config('app.name', 'Laravel') }}</title>

   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
   <main class="relative isolate overflow-hidden">
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.18),_transparent_32%),radial-gradient(circle_at_bottom_right,_rgba(16,185,129,0.14),_transparent_28%),linear-gradient(180deg,_#020617_0%,_#0f172a_100%)]"></div>
      <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-sky-400/60 to-transparent"></div>

      <section class="relative mx-auto flex min-h-screen w-full max-w-6xl items-center px-6 py-16 lg:px-10">
         <div class="grid w-full gap-12 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div class="max-w-2xl">
               <p class="mb-4 inline-flex items-center rounded-full border border-sky-400/30 bg-sky-400/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-sky-200">
                  Country Explorer
               </p>
               <h1 class="text-4xl font-semibold tracking-tight text-white sm:text-6xl">
                  Explore countries, save favourites, and keep notes in one place.
               </h1>
               <p class="mt-6 max-w-xl text-base leading-7 text-slate-300 sm:text-lg">
                  Search the Rest Countries API, bookmark countries you care about, and capture personal notes without leaving the app.
               </p>

               <div class="mt-8 flex flex-wrap gap-3">
                  @auth
                  <a href="{{ url('/dashboard') }}" class="rounded-full bg-sky-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-300">
                     Go to dashboard
                  </a>
                  @else
                  <a href="{{ route('login') }}" class="rounded-full bg-sky-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-300">
                     Log in
                  </a>
                  @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="rounded-full border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-white/25 hover:bg-white/10">
                     Register
                  </a>
                  @endif
                  @endauth
               </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/40 backdrop-blur">
               <div class="grid gap-4">
                  <div class="rounded-2xl border border-white/10 bg-slate-900/80 p-4">
                     <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Search</p>
                     <p class="mt-2 text-lg font-medium text-white">Find a country by name</p>
                     <p class="mt-1 text-sm text-slate-300">Fast lookups with API caching and graceful fallback.</p>
                  </div>
                  <div class="rounded-2xl border border-white/10 bg-slate-900/80 p-4">
                     <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Save</p>
                     <p class="mt-2 text-lg font-medium text-white">Track favourites per user</p>
                     <p class="mt-1 text-sm text-slate-300">Unique country codes, notes, and user-scoped records.</p>
                  </div>
                  <div class="rounded-2xl border border-white/10 bg-slate-900/80 p-4">
                     <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Manage</p>
                     <p class="mt-2 text-lg font-medium text-white">Update notes and remove entries cleanly</p>
                     <p class="mt-1 text-sm text-slate-300">Built around simple services and repositories.</p>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </main>
</body>

</html>