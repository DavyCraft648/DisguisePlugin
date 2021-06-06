<?php

namespace ArasakaID\Disguise\entity;

use ArasakaID\Disguise\data\PlayerData;
use pocketmine\block\Block;
use pocketmine\entity\Location;
use pocketmine\entity\object\FallingBlock as PMFallingBlock;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

class FallingBlock extends PMFallingBlock {

    /** @var null|Player */
    private $player;
    /** @var bool */
    private $blockSneak;

    public function __construct(?Player $player, Block $block, bool $blockSneak = false, Location $location = null, ?CompoundTag $nbt = null) {
        $this->player = $player;
        $this->blockSneak = $blockSneak;
        parent::__construct($player->location ?? $location, $block, $nbt);
    }

    public function entityBaseTick(int $tickDiff = 1): bool {
        if ($this->player === null) {
            return parent::entityBaseTick($tickDiff);
        }

        $playerData = new PlayerData($this->player);
        if (!$playerData->isRegistered() || $playerData->getEntityId() != $this->id) {
            return false;
        }

        if ($this->player->isSneaking() && $this->blockSneak) {
            return false;
        }

        $this->setPosition($this->player->location);
        $this->player->setInvisible();
        return true;
    }

}
