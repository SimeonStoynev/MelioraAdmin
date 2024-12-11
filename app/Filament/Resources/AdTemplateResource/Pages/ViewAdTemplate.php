<?php

namespace App\Filament\Resources\AdTemplateResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\AdTemplateResource;

class ViewAdTemplate extends ViewRecord
{
    protected static string $resource = AdTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
