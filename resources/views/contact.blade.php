@extends('layouts.frontend')

@section('content')

<section class="py-24 bg-white dark:bg-gray-950 min-h-screen transition-colors duration-300">

    <div class="max-w-2xl mx-auto px-6">

        {{-- Heading --}}
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                Contact Me
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mt-3">
                Let's build something amazing together.
            </p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl
                        bg-green-50 dark:bg-green-900/20
                        border border-green-200 dark:border-green-700
                        text-green-700 dark:text-green-400
                        flex items-center gap-2 text-sm"
                 data-alert>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Error messages --}}
        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl
                        bg-red-50 dark:bg-red-900/20
                        border border-red-200 dark:border-red-700
                        text-red-700 dark:text-red-400 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white dark:bg-gray-900
                    shadow-xl dark:shadow-gray-900/50
                    rounded-2xl p-8 md:p-10
                    border border-gray-200 dark:border-gray-700
                    transition-colors duration-300"
             data-aos="fade-up" data-aos-delay="100">

            <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">
                        Name
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="Your full name"
                           class="w-full rounded-xl
                                  border border-gray-300 dark:border-gray-600
                                  bg-white dark:bg-gray-800
                                  text-gray-900 dark:text-gray-100
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  px-4 py-3
                                  focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400
                                  focus:border-indigo-500 dark:focus:border-indigo-400
                                  outline-none transition duration-200">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">
                        Email
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="your@email.com"
                           class="w-full rounded-xl
                                  border border-gray-300 dark:border-gray-600
                                  bg-white dark:bg-gray-800
                                  text-gray-900 dark:text-gray-100
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  px-4 py-3
                                  focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400
                                  focus:border-indigo-500 dark:focus:border-indigo-400
                                  outline-none transition duration-200">
                </div>

                {{-- Message --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-800 dark:text-gray-200">
                        Message
                    </label>
                    <textarea name="message"
                              rows="6"
                              required
                              placeholder="Tell me about your project or just say hi..."
                              class="w-full rounded-xl
                                     border border-gray-300 dark:border-gray-600
                                     bg-white dark:bg-gray-800
                                     text-gray-900 dark:text-gray-100
                                     placeholder-gray-400 dark:placeholder-gray-500
                                     px-4 py-3
                                     focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400
                                     focus:border-indigo-500 dark:focus:border-indigo-400
                                     outline-none transition duration-200 resize-none">{{ old('message') }}</textarea>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                            class="w-full px-8 py-3.5 bg-indigo-600 text-white font-semibold rounded-xl
                                   shadow-md hover:bg-indigo-700 hover:shadow-lg
                                   transition duration-300 hover:-translate-y-0.5">
                        Send Message →
                    </button>
                </div>

            </form>

        </div>

        {{-- Contact info --}}
        <div class="mt-10 flex justify-center gap-8 text-sm text-gray-500 dark:text-gray-400"
             data-aos="fade-up" data-aos-delay="200">
            <a href="mailto:kushal.upr@gmail.com"
               class="flex items-center gap-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                <i class="fas fa-envelope"></i>
                kushal.upr@gmail.com
            </a>
            <a href="https://github.com/Ghimire-Kushal"
               target="_blank"
               class="flex items-center gap-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                <i class="fab fa-github"></i>
                GitHub
            </a>
        </div>

    </div>

</section>

@endsection
