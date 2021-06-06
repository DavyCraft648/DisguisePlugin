<?php

namespace ArasakaID\Disguise\entity;

use ArasakaID\Disguise\data\PlayerData;
use pocketmine\entity\Location;
use pocketmine\entity\object\ItemEntity as PMItemEntity;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

class ItemEntity extends PMItemEntity {

    /** @var null|Player */
    private $player;

    public function __construct(?Player $player, Item $item, Location $location = null, ?CompoundTag $nbt = null) {
        $this->player = $player;
        parent::__construct($player->location ?? $location, $item, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool {
        if ($this->player === null) {
            return parent::entityBaseTick($tickDiff);
        }

        $playerData = new PlayerData($this->player);
        if (!$playerData->isRegistered() || $playerData->getEntityId() != $this->id) {
            return false;
        }

        $this->setPosition($this->player->location);
        $this->player->setInvisible();
        return true;
    }

}
