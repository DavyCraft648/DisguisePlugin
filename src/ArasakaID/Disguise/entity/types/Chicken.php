<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Chicken extends Entity {

    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.8, 0.6);
    }

    public static function getNetworkTypeId(): string {
        return EntityIds::CHICKEN;
    }

    public function getName(): string {
        return "Chicken";
    }

}
