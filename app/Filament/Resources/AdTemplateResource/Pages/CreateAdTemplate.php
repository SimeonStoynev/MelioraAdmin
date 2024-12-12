<?php

namespace App\Filament\Resources\AdTemplateResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\AdTemplateResource;

class CreateAdTemplate extends CreateRecord
{
    protected static string $resource = AdTemplateResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Ad Template created successfully.';
    }
}
