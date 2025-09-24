<?php

namespace App\Filament\Resources\FooterContactResource\Pages;

use App\Filament\Resources\FooterContactResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\FooterContact;

class CreateFooterContact extends CreateRecord
{
    protected static string $resource = FooterContactResource::class;

    protected function handleRecordCreation(array $data): FooterContact
    {
        $label    = $data['label']     ?? 'GET IN TOUCH';
        $isActive = $data['is_active'] ?? true;

        $items = [];

        if (!empty($data['address'])) {
            $items[] = [
                'label'     => $label,
                'type'      => 'address',
                'value'     => $data['address'],
                'is_active' => $isActive,
            ];
        }

        if (!empty($data['phone'])) {
            $items[] = [
                'label'     => $label,
                'type'      => 'phone',
                'value'     => $data['phone'],
                'is_active' => $isActive,
            ];
        }

        if (!empty($data['email'])) {
            $items[] = [
                'label'     => $label,
                'type'      => 'email',
                'value'     => $data['email'],
                'is_active' => $isActive,
            ];
        }

        if (!empty($data['socials']) && is_array($data['socials'])) {
            foreach ($data['socials'] as $social) {
                // hanya tambah kalau link ada
                if (!empty($social['link'])) {
                    $items[] = [
                        'label'     => 'FOLLOW US',
                        'type'      => 'social',
                        'value'     => $social['link'],
                        'icon'      => $social['icon'] ?? null,
                        'is_active' => $isActive,
                    ];
                }
            }
        }

        // Insert semua row
        foreach ($items as $item) {
            FooterContact::create($item);
        }

        // Kembalikan salah satu record (agar Filament tidak error setelah create)
        return new FooterContact(); // dummy object supaya page bisa redirect
    }

    protected function getRedirectUrl(): string
    {
        // setelah create langsung balik ke index
        return static::getResource()::getUrl('index');
    }

    protected function getCreatedNotificationRedirectUrl(): ?string
    {
        // setelah create langsung balik ke index
        return static::getResource()::getUrl('index');
    }
}
