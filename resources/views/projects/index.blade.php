@extends('layouts.frontend')

@section('content')

<section class="py-28 bg-gray-50 dark:bg-gray-950 min-h-screen transition-colors duration-300">
    <div class="max-w-6xl mx-auto px-6">

        {{-- Page Title --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                My Projects
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-4 text-lg">
                A collection of my recent work
            </p>
        </div>

        {{-- Project Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

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

                    <div class="p-6">

                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">
                            {{ $project->title }}
                        </h3>

                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($project->description, 120) }}
                        </p>

                        <a href="{{ route('projects.show', $project->slug) }}"
                           class="inline-flex items-center gap-1 mt-6
                                  text-indigo-600 dark:text-indigo-400 font-medium
                                  hover:gap-2 transition-all duration-200">
                            View Details →
                        </a>

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
