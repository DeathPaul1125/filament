<?php

namespace App\Filament\Resources\EquipoResource\Pages;

use App\Filament\Resources\EquipoResource;
use App\Models\Equipo;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListEquipos extends ListRecords
{
    protected static string $resource = EquipoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Action::make('consumeapi')
            ->label('Consumir api')
            ->color('success')
            ->action('consumeapi'),
        ];
    }
    public function consumeapi()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.lansweeper.com/api/v2/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"query":"query getAssetResources {\\r\\n  site(id: \\"1a1044af-2e6b-4f32-a53a-28fd86383763\\") {\\r\\n    assetResources(\\r\\n      fields: [\\r\\n                \\"assetBasicInfo.domain\\",\\r\\n                \\"assetBasicInfo.name\\",\\r\\n                \\"assetBasicInfo.userDomain\\",\\r\\n                \\"assetBasicInfo.userName\\",\\r\\n                \\"assetBasicInfo.firstSeen\\",\\r\\n                \\"assetBasicInfo.fqdn\\",\\r\\n                \\"assetBasicInfo.ipAddress\\",\\r\\n                \\"assetBasicInfo.lastSeen\\",\\r\\n                \\"assetBasicInfo.type\\",\\r\\n                \\"assetBasicInfo.lastIpScan\\",\\r\\n                \\"assetBasicInfo.lastWorkGroupScan\\",\\r\\n                \\"assetBasicInfo.assetUnique\\",\\r\\n                \\"assetCustom.manufacturer\\"\\r\\n                \\"assetCustom.serialNumber\\"\\r\\n                \\"softwares.installDate\\"\\r\\n                \\"softwares.lastChanged\\"\\r\\n                \\"softwares.operatingSystem\\"\\r\\n                \\"softwares.installType\\"\\r\\n                \\"softwares.type\\"\\r\\n                \\"softwares.name\\"\\r\\n                \\"softwares.publisher\\"\\r\\n                \\"softwares.version\\"\\r\\n                \\"softwares.shortVersion\\"\\r\\n                \\"softwares.category\\"\\r\\n                \\"softwares.cpe\\"\\r\\n                \\"softwares.marketVersion\\"\\r\\n                \\"softwares.edition\\"\\r\\n               ]\\r\\n    ) {\\r\\n      total\\r\\n      items\\r\\n    }\\r\\n  }\\r\\n}","variables":{}}',
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json',
              'Authorization: Token lsp_eyJwYXQiOiJ0TmdXdXVFeVlDYXZMeGRicGVULyIsInNpdGVfcmVnaW9uIjp7IjFhMTA0NGFmLTJlNmItNGYzMi1hNTNhLTI4ZmQ4NjM4Mzc2MyI6ImV1In1901947633033'
            ),
          ));

        $json = curl_exec($curl);

        curl_close($curl);
        // Decodificar el JSON
        $data = json_decode($json, true);

        $items = $data['data']['site']['assetResources']['items'];
        // Extraer assetBasicInfo y assetCustom de cada elemento
        foreach ($items as $item) {
            $equipo = new Equipo();
            $assetBasicInfo = $item['assetBasicInfo'];

            if (isset($item['assetCustom'])) {
                $assetCustom = $item['assetCustom'];

                if (empty($assetCustom)) {
                    $equipo->marca = $assetCustom['manufacturer'];
                    $equipo->serie = $assetCustom['serialNumber'];
                    $equipo->modelo = $assetCustom['model'];
                } else {
                    $equipo->marca = ($assetCustom['manufacturer'] ?? "NULL");
                    $equipo->serie = ($assetCustom['serialNumber'] ?? "NULL");
                    $equipo->modelo = ($assetCustom['model'] ?? "NULL");
                }
            } else {
                $equipo->marca = "NULL";
                $equipo->serie = "NULL";
                $equipo->modelo = "NULL";
            }

            $equipo->ip = ($assetBasicInfo['ipAddress'] ?? "NULL");
            $equipo->usuario = ($assetBasicInfo['userName'] ?? "NULL");
            $equipo->dominio = ($assetBasicInfo['domain'] ?? "NULL");
            $equipo->so = ($assetBasicInfo['type'] ?? "NULL");
            $equipo->soversion = "NULL";
            $equipo->location = "NULL";
            $equipo->save();
        }
    }
}
