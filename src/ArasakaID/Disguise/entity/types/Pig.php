<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Pig extends Entity {

    public static function getNetworkTypeId(): string {
        return EntityIds::PIG;
    }
    public function getName(): string {
        return "Pig";
    }
    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(0.9, 0.9);
    }

}
