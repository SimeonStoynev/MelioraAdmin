<?php

namespace App\Filament\Resources\AdTemplateResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\AdTemplateResource;

class EditAdTemplate extends EditRecord
{
    protected static string $resource = AdTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
