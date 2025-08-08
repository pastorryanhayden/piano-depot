@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Import Pianos</h1>
        <a href="{{ route('admin.pianos.index') }}" class="btn btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('import_errors') && count(session('import_errors')) > 0)
        <div class="alert alert-warning mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
            <div>
                <strong>Import completed with errors:</strong>
                <ul class="list-disc list-inside mt-2 max-h-32 overflow-y-auto">
                    @foreach(session('import_errors') as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Import Form -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Upload CSV File</h2>
                    <p class="text-gray-600 mb-4">
                        Upload a CSV file to bulk import piano data. Make sure your CSV follows the correct format.
                    </p>

                    <form method="POST" action="{{ route('admin.pianos.import') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">CSV File <span class="text-red-500">*</span></span>
                            </label>
                            <input type="file" 
                                   name="csv_file" 
                                   accept=".csv,.txt" 
                                   class="file-input file-input-bordered @error('csv_file') file-input-error @enderror" 
                                   required>
                            <label class="label">
                                <span class="label-text-alt">Max size: 2MB. Accepted formats: .csv, .txt</span>
                            </label>
                            @error('csv_file')
                                <label class="label">
                                    <span class="label-text-alt text-red-500">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="{{ route('admin.pianos.index') }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Import Pianos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Instructions & Template -->
        <div class="space-y-6">
            <!-- CSV Format Instructions -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">CSV Format</h2>
                    <div class="text-sm space-y-2">
                        <p class="font-medium">Required columns (in order):</p>
                        <ol class="list-decimal list-inside space-y-1 text-xs">
                            <li><strong>Brand</strong> (required)</li>
                            <li><strong>Model</strong> (required)</li>
                            <li><strong>Year</strong> (optional)</li>
                            <li><strong>Price</strong> (required)</li>
                            <li><strong>Condition</strong> (new/used/restored)</li>
                            <li><strong>Description</strong> (optional)</li>
                            <li><strong>Specifications</strong> (separated by ";")</li>
                            <li><strong>Is Available</strong> (Yes/No)</li>
                            <li><strong>Is Featured</strong> (Yes/No)</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Download Template -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Template</h2>
                    <p class="text-sm text-gray-600 mb-4">
                        Download a sample CSV template to see the correct format.
                    </p>
                    <a href="data:text/csv;charset=utf-8,Brand,Model,Year,Price,Condition,Description,Specifications,Is Available,Is Featured%0AYamaha,U3,2020,15000,new,Professional upright piano,Height: 131cm; Width: 153cm; Weight: 240kg,Yes,No%0AKawai,K-300,2018,12000,used,Excellent condition used piano,Height: 122cm; Width: 149cm; Weight: 220kg,Yes,Yes" 
                       download="piano_import_template.csv" 
                       class="btn btn-outline w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Download Template
                    </a>
                </div>
            </div>

            <!-- Export Current Data -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Export Data</h2>
                    <p class="text-sm text-gray-600 mb-4">
                        Export your current piano inventory to see the format or for backup purposes.
                    </p>
                    <a href="{{ route('admin.pianos.export') }}" class="btn btn-info w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Export All Pianos
                    </a>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Important Notes</h2>
                    <div class="text-sm space-y-2">
                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-xs">
                                <p><strong>Tips:</strong></p>
                                <ul class="list-disc list-inside mt-1 space-y-1">
                                    <li>Make sure your CSV has headers</li>
                                    <li>Use semicolon (;) to separate multiple specifications</li>
                                    <li>Leave fields empty if not applicable</li>
                                    <li>Images cannot be imported via CSV</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection