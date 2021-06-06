<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Villager extends Entity {

    public static function getNetworkTypeId(): string {
        return EntityIds::VILLAGER;
    }
    public function getName(): string {
        return "Villager";
    }
    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(1.9, 0.6);
    }

}
