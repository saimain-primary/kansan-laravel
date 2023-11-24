<?php

namespace App\Filament\Resources\TalkToAdminResource\Pages;

use App\Filament\Resources\TalkToAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTalkToAdmin extends EditRecord
{
    protected static string $resource = TalkToAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
