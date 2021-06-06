<?php

namespace ArasakaID\Disguise\entity;

use ArasakaID\Disguise\data\PlayerData;
use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player as PMPlayer;
use pocketmine\entity\Human;

class Player extends Human {

    /** @var null|PMPlayer */
    private $player;

    public function __construct(?PMPlayer $player, Skin $skin, Location $location = null, ?CompoundTag $nbt = null) {
        $this->player = $player;
        parent::__construct($player->location ?? $location, $skin, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool {
        if ($this->player === null) {
            if (!$this->isFlaggedForDespawn()) {
                $this->flagForDespawn();
            }
            return false;
        }

        $playerData = new PlayerData($this->player);
        if (!$playerData->isRegistered() || $playerData->getEntityId() != $this->id) {
            if (!$this->isFlaggedForDespawn()) {
                $this->flagForDespawn();
            }
            return false;
        }

        $this->setInvisible();
        return true;
    }

}
