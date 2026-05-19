@extends('layouts.frontend')

@section('content')

<section class="py-20 sm:py-28 bg-gray-50 dark:bg-gray-950 min-h-screen transition-colors duration-300">
    <div class="max-w-6xl mx-auto px-5 sm:px-6">

        {{-- Page Title --}}
        <div class="text-center mb-10 sm:mb-16" data-aos="fade-up">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                My Projects
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-3 sm:mt-4 text-base sm:text-lg">
                A collection of my recent work
            </p>
        </div>

        {{-- Project Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">

            @forelse($projects as $i => $project)
                <div class="group bg-white dark:bg-gray-900
                            border border-gray-100 dark:border-gray-700
                            rounded-2xl shadow-sm hover:shadow-2xl dark:hover:shadow-gray-900/60
                            hover:-translate-y-1.5 transition duration-500 overflow-hidden"
                     data-aos="fade-up" data-aos-delay="{{ $i * 50 }}">

                    {{-- Image --}}
                    @if(!empty($project->image))
                        <img src="{{ $project->image }}"
                             alt="{{ $project->title }}"
                             class="w-full h-52 object-cover group-hover:scale-105 transition duration-500"
                             loading="lazy"
                             onerror="this.src='https://via.placeholder.com/400x300?text=No+Image';">
                    @else
                        <div class="w-full h-52 bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <span class="text-gray-400 dark:text-gray-600 text-sm">No Image</span>
                        </div>
                    @endif

                    <div class="p-4 sm:p-6">

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

                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($project->description, 120) }}
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
                               class="inline-flex items-center gap-1
                                      text-indigo-600 dark:text-indigo-400 font-medium text-sm
                                      hover:gap-2 transition-all duration-200">
                                View Details →
                            </a>
                        </div>

                    </div>
                </div>

            @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No projects available yet.</p>
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        @if(method_exists($projects, 'links'))
            <div class="mt-16 flex justify-center">
                {{ $projects->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
