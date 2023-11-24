<?php

namespace App\Filament\Resources\TalkToAdminResource\Pages;

use App\Filament\Resources\TalkToAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTalkToAdmins extends ListRecords
{
    protected static string $resource = TalkToAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
