<?php

namespace ArasakaID\Disguise\entity\types;

use ArasakaID\Disguise\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Cow extends Entity {

    public static function getNetworkTypeId(): string {
        return EntityIds::COW;
    }
    public function getName(): string {
        return "Cow";
    }
    protected function getInitialSizeInfo(): EntitySizeInfo {
        return new EntitySizeInfo(1.3, 0.9);
    }

}
