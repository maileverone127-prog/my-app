@extends('layouts.frontend')

@section('content')

{{-- ================================================================
     HERO
================================================================ --}}
<section class="relative overflow-hidden bg-white dark:bg-gray-950 py-20 sm:py-28 transition-colors duration-300">

    {{-- Subtle background gradient blob --}}
    <div class="absolute -top-24 -right-24 w-72 sm:w-96 h-72 sm:h-96 rounded-full bg-indigo-100 dark:bg-indigo-900/20 blur-3xl opacity-60 pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-64 sm:w-80 h-64 sm:h-80 rounded-full bg-purple-100 dark:bg-purple-900/20 blur-3xl opacity-50 pointer-events-none"></div>

    <div class="relative max-w-5xl mx-auto px-5 sm:px-6 text-center">

        <div class="inline-flex items-center px-4 sm:px-5 py-2 rounded-full
                    bg-indigo-50 dark:bg-indigo-900/30
                    text-indigo-600 dark:text-indigo-300
                    text-xs sm:text-sm font-medium shadow-sm border border-indigo-100 dark:border-indigo-800">
            🚀 Building Scalable Web Applications
        </div>

        <h1 class="mt-6 sm:mt-8 text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 dark:text-white tracking-tight"
            data-aos="fade-up" data-aos-delay="100">
            Kushal Ghimire
        </h1>

        <h2 class="mt-3 sm:mt-4 text-base sm:text-xl md:text-2xl text-indigo-600 dark:text-indigo-400 font-semibold leading-snug"
            data-aos="fade-up" data-aos-delay="150">
            Laravel Developer &nbsp;·&nbsp; Backend Specialist &nbsp;·&nbsp; Vibe Coder
        </h2>

        <p class="mt-5 sm:mt-6 text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed"
           data-aos="fade-up" data-aos-delay="200">
            I design and develop high-performance Laravel applications with
            clean architecture, secure authentication systems, and modern UI.
        </p>

        {{-- CTA Buttons + Social --}}
        <div class="mt-8 sm:mt-10 flex flex-col items-center gap-5 sm:gap-6" data-aos="fade-up" data-aos-delay="250">

            <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4 w-full sm:w-auto">
                <a href="#projects"
                   class="w-full sm:w-auto px-7 sm:px-8 py-3 rounded-xl bg-indigo-600 text-white font-semibold
                          shadow-lg hover:bg-indigo-700 hover:shadow-xl
                          transition duration-300 hover:-translate-y-0.5 text-center">
                    View My Work →
                </a>
                <a href="{{ route('resume.download') }}"
                   class="w-full sm:w-auto px-7 sm:px-8 py-3 rounded-xl
                          border border-gray-300 dark:border-gray-600
                          text-gray-800 dark:text-gray-200
                          font-medium text-center
                          hover:border-indigo-600 dark:hover:border-indigo-400
                          hover:text-indigo-600 dark:hover:text-indigo-400
                          transition duration-300">
                    Download Resume
                </a>
            </div>

            {{-- Social icons --}}
            <div class="flex items-center gap-7 sm:gap-8 text-2xl sm:text-3xl text-gray-500 dark:text-gray-400">

                <a href="https://github.com/Ghimire-Kushal"
                   target="_blank"
                   class="hover:text-gray-900 dark:hover:text-white transition duration-200 hover:scale-110 transform">
                    <i class="fab fa-github"></i>
                </a>

                <a href="https://www.linkedin.com/in/kushal-ghimire-9448093b1/"
                   target="_blank"
                   class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-200 hover:scale-110 transform">
                    <i class="fab fa-linkedin"></i>
                </a>

                <a href="mailto:kushal.upr@gmail.com"
                   class="hover:text-red-500 dark:hover:text-red-400 transition duration-200 hover:scale-110 transform">
                    <i class="fas fa-envelope"></i>
                </a>

            </div>

        </div>

    </div>
</section>

{{-- ================================================================
     PROJECTS
================================================================ --}}
<section id="projects" class="py-16 sm:py-24 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    <div class="max-w-6xl mx-auto px-5 sm:px-6">

        <div class="text-center mb-10 sm:mb-14" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                Featured Projects
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mt-3">
                Real-world applications built with Laravel
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">

            @forelse($projects as $i => $project)

                <div class="group bg-white dark:bg-gray-800
                            border border-gray-100 dark:border-gray-700
                            rounded-2xl shadow-md hover:shadow-xl dark:shadow-gray-900/50
                            hover:-translate-y-1.5 transition duration-300
                            overflow-hidden flex flex-col"
                     data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">

                    {{-- Image --}}
                    @if(!empty($project->image))
                        @if(\Illuminate\Support\Str::startsWith($project->image, ['http://', 'https://']))
                            <img src="{{ $project->image }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-52 object-cover group-hover:scale-105 transition duration-500"
                                 loading="lazy"
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-52 bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500\'>No Image</div>'">
                        @else
                            <img src="{{ asset('storage/'.$project->image) }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-52 object-cover group-hover:scale-105 transition duration-500"
                                 loading="lazy">
                        @endif
                    @else
                        <div class="w-full h-52 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-400 dark:text-gray-500 text-sm">No Image</span>
                        </div>
                    @endif

                    <div class="p-6 flex flex-col flex-1">

                        <div class="flex items-start justify-between gap-2 mb-1">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">
                                {{ $project->title }}
                            </h3>
                            @php
                                $statusStyles = [
                                    'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400',
                                    'ongoing'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                                    'planned'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400',
                                ];
                                $statusLabel = ucfirst($project->status ?? 'completed');
                                $statusClass = $statusStyles[$project->status ?? 'completed'] ?? $statusStyles['completed'];
                            @endphp
                            <span class="flex-shrink-0 text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 flex-1 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($project->description, 110) }}
                        </p>

                        <div class="mt-6 flex flex-wrap gap-2 items-center">

                            @if(!empty($project->link))
                                <a href="{{ $project->link }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg
                                          bg-indigo-600 text-white text-sm font-semibold
                                          hover:bg-indigo-700 transition duration-200 shadow-sm hover:shadow-md">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    Live Demo
                                </a>
                            @endif

                            <a href="{{ route('projects.show', $project->slug) }}"
                               class="inline-flex items-center gap-1 text-sm text-indigo-600 dark:text-indigo-400 font-medium hover:underline transition">
                                Details →
                            </a>

                            @if(!empty($project->github_link))
                                <a href="{{ $project->github_link }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition">
                                    <i class="fab fa-github text-base"></i>
                                    GitHub
                                </a>
                            @endif

                        </div>

                    </div>
                </div>

            @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No projects added yet.</p>
                </div>
            @endforelse

        </div>

    </div>

</section>

{{-- ================================================================
     FOOTER
================================================================ --}}
<footer class="bg-gray-900 dark:bg-gray-950 text-gray-400 py-10 text-center text-sm border-t border-gray-800 dark:border-gray-800 transition-colors duration-300">
    © {{ date('Y') }} Kushal Ghimire. All rights reserved.
</footer>

@endsection
