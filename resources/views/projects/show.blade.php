<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('projects.index') }}"
                class="hover:text-gray-700 hover:border-gray-300">{{ __('Project') }}</a> / {{ $RS_Row->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <header>
                <h2 class="text-3xl text-gray-900">
                    {{ $RS_Row->slug . ' ' . __('Issues') }}
                </h2>
            </header>

            @if ($RS_Row->statuses->count() > 0)
                <ul class="lg:gap-4 sm:gap-8 grid grid-cols-12 col-span-10 col-start-2 gap-3">
                    @foreach ($RS_Row->statuses as $RS_Row_Status)
                        <li
                            class="card bg-white shadow-sm sm:rounded-lg p-4 group mb-6 md:md-0 col-span-12 sm:col-span-6 lg:col-span-3 group-link-underline">
                            <h3 class="bg-gray-200 text-lg mb-2 py-1 px-2 font-bold">
                                {{ $RS_Row_Status->name }}
                                <span class="issue_count">{{ $RS_Row_Status->projectIssues->count() == 0 ? __('0 issue') : ($RS_Row_Status->projectIssues->count() == 1 ? __('1 issue') : $RS_Row_Status->projectIssues->count() . __(' issues')) }}</span>
                            </h3>

                            <div class="issue-sortable issue_list">
                                @if ($RS_Row_Status->projectIssues->count() > 0)
                                    @foreach ($RS_Row_Status->projectIssues as $RS_Row_ProIssue)
                                        <div class="issue-draggable issue_list_item bg-gray-100 mb-1 p-2 border">
                                            <p>{{ $RS_Row_ProIssue->title }} {{ $RS_Row_Status->id }}</p>
                                            <p class="text-gray-500">{{ $RS_Row_ProIssue->slug }}</p>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="issue_list_item create_issue_main">
                                    <div class="create_issue_tile">{{ __('+ Create issue') }}</div>
                                    <div class="create_issue_form">
                                        <x-textarea data-project-id="{{ $RS_Row->id }}"
                                            data-project-slug="{{ $RS_Row->slug }}"
                                            data-status-id="{{ $RS_Row_Status->id }}" id="issue_title"
                                            class="issue_title mt-1 block w-full"></x-textarea>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>