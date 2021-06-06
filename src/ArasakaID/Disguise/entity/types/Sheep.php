<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Sheep extends Entity {

    public static function getNetworkTypeId(): string {
        return EntityIds::SHEEP;
    }
    public function getName(): string {
        return "Sheep";
    }
    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(1.3, 0.9);
    }

}
