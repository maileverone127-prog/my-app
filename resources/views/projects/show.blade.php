@extends('layouts.frontend')

@section('content')

@php use Illuminate\Support\Str; @endphp

<div class="bg-gray-50 dark:bg-gray-950 py-14 sm:py-20 px-5 sm:px-6 min-h-screen transition-colors duration-300">

    <div class="max-w-6xl mx-auto">

        {{-- Back link --}}
        <a href="{{ route('projects.index') }}"
           class="inline-flex items-center gap-2 text-sm text-indigo-600 dark:text-indigo-400
                  hover:text-indigo-800 dark:hover:text-indigo-300
                  mb-10 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Projects
        </a>

        {{-- Title --}}
        <div class="text-center mb-10 sm:mb-14" data-aos="fade-up">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 dark:text-white">
                {{ $project->title }}
            </h1>
            @php
                $statusStyles = [
                    'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400',
                    'ongoing'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                    'planned'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400',
                ];
                $statusLabel = ucfirst($project->status ?? 'completed');
                $statusClass = $statusStyles[$project->status ?? 'completed'] ?? $statusStyles['completed'];
            @endphp
            <span class="inline-block mt-4 text-sm font-semibold px-4 py-1 rounded-full {{ $statusClass }}">
                {{ $statusLabel }}
            </span>
            <div class="w-20 h-1 bg-indigo-600 dark:bg-indigo-400 mx-auto mt-5 rounded-full"></div>
        </div>

        {{-- Card --}}
        <div class="bg-white dark:bg-gray-900
                    rounded-2xl sm:rounded-3xl shadow-xl dark:shadow-gray-900/50
                    border border-gray-100 dark:border-gray-700
                    p-5 sm:p-8 md:p-12 transition-colors duration-300"
             data-aos="fade-up" data-aos-delay="100">

            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">

                {{-- Project Image --}}
                <div class="overflow-hidden rounded-2xl shadow-lg dark:shadow-gray-900/50">

                    @if(!empty($project->image))

                        @if(Str::startsWith($project->image, ['http://', 'https://']))
                            <img src="{{ $project->image }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-56 sm:h-72 md:h-[380px] object-cover hover:scale-105 transition duration-500">
                        @else
                            <img src="{{ asset('storage/'.$project->image) }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-56 sm:h-72 md:h-[380px] object-cover hover:scale-105 transition duration-500">
                        @endif

                    @else
                        <div class="w-full h-56 sm:h-72 md:h-[380px] flex items-center justify-center
                                    bg-gray-100 dark:bg-gray-800">
                            <span class="text-gray-400 dark:text-gray-600">No Image Available</span>
                        </div>
                    @endif

                </div>

                {{-- Content --}}
                <div>

                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4 sm:mb-5">
                        Project Overview
                    </h2>

                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm sm:text-base mb-6 sm:mb-8">
                        {{ $project->description }}
                    </p>

                    <div class="flex flex-wrap gap-3">

                        @if($project->link)
                            <a href="{{ $project->link }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 px-6 py-3
                                      bg-indigo-600 text-white rounded-xl shadow-md
                                      hover:bg-indigo-700 hover:shadow-lg
                                      transition duration-300 hover:-translate-y-0.5 font-medium">
                                Visit Live Project →
                            </a>
                        @endif

                        @if(!empty($project->github_link))
                            <a href="{{ $project->github_link }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 px-6 py-3
                                      border border-gray-300 dark:border-gray-600
                                      text-gray-700 dark:text-gray-300
                                      rounded-xl hover:border-indigo-500 dark:hover:border-indigo-400
                                      hover:text-indigo-600 dark:hover:text-indigo-400
                                      transition duration-300 font-medium">
                                <i class="fab fa-github"></i>
                                GitHub
                            </a>
                        @endif

                    </div>

                </div>

            </div>

        </div>

        {{-- Related Projects --}}
        @if(isset($relatedProjects) && $relatedProjects->count())
        <div class="mt-14 sm:mt-20">

            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-6 sm:mb-8 text-center"
                data-aos="fade-up">
                Other Projects
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                @foreach($relatedProjects as $i => $related)
                    <a href="{{ route('projects.show', $related->slug) }}"
                       class="group bg-white dark:bg-gray-900
                              border border-gray-100 dark:border-gray-700
                              rounded-2xl overflow-hidden shadow-sm
                              hover:shadow-lg dark:hover:shadow-gray-900/50
                              hover:-translate-y-1 transition duration-300 block"
                       data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">

                        @if(!empty($related->image))
                            <img src="{{ $related->image }}"
                                 alt="{{ $related->title }}"
                                 class="w-full h-44 object-cover group-hover:scale-105 transition duration-500"
                                 loading="lazy">
                        @else
                            <div class="w-full h-44 bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <span class="text-gray-400 dark:text-gray-600 text-sm">No Image</span>
                            </div>
                        @endif

                        <div class="p-5">
                            <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">
                                {{ Str::limit($related->title, 40) }}
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                                {{ Str::limit($related->description, 70) }}
                            </p>
                        </div>

                    </a>
                @endforeach
            </div>

        </div>
        @endif

    </div>

</div>

@endsection
