<?php

namespace App\Filament\Candidate\Resources\JobApplications\Pages;

use App\Filament\Candidate\Resources\JobApplications\JobApplicationResource;
use App\Models\JobApplication;
use App\Services\ApplicationService;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewJobApplication extends ViewRecord
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('upload_document')
                ->label('Upload Document')
                ->icon('heroicon-o-document-plus')
                ->form([
                    TextInput::make('name')
                        ->label('Document Name')
                        ->required()
                        ->placeholder('e.g., Resume, Cover Letter'),
                    FileUpload::make('file')
                        ->label('File')
                        ->disk('public')
                        ->directory('application-documents')
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                        ->maxSize(5120) // 5MB
                        ->required(),
                ])
                ->action(function (array $data, JobApplication $record, ApplicationService $service) {
                    $documents = $record->documents ?? [];
                    // Handle file upload correctly - FileUpload returns the path
                    $documents[] = [
                        'name' => $data['name'],
                        'path' => $data['file'],
                        'uploaded_at' => now()->toIso8601String(),
                    ];
                    
                    $service->uploadDocuments($record, $documents);
                    
                    Notification::make()
                        ->title('Document Uploaded')
                        ->success()
                        ->send();
                    
                    // $this->refresh();
                }),
        ];
    }
}
