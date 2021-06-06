<?php

namespace ArasakaID\Disguise\entity;

use ArasakaID\Disguise\data\PlayerData;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

abstract class Entity extends \pocketmine\entity\Entity {

    /** @var Player|null */
    private $player;

    public function __construct(?Player $player, Location $location = null, ?CompoundTag $nbt = null) {
        $this->player = $player;
        parent::__construct($player->location ?? $location, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool {
        if ($this->player === null) {
            return parent::entityBaseTick($tickDiff);
        }

        $playerData = new PlayerData($this->player);
        if (!$playerData->isRegistered() || $playerData->getEntityId() != $this->id) {
            return false;
        }

        $this->location = $this->player->location;
        $this->player->setInvisible();

        return true;
    }

    abstract public function getName(): string;

}
