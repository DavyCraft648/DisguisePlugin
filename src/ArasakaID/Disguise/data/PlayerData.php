<?php

namespace ArasakaID\Disguise\data;

use pocketmine\entity\Entity as PMEntity;
use pocketmine\player\Player;

class PlayerData {

    /** @var int[] */
    private static $entityId = [];
    /** @var Player[] */
    private static $fakePlayer = [];
    /** @var Player */
    private $player;

    public function __construct(Player $player) {
        $this->player = $player;
    }

    /**
     * @param int $id
     * @param Player|null $target
     */
    public function setEntityId(int $id, ?Player $target = null) {
        self::$entityId[$this->player->getName()] = $id;
        self::$fakePlayer[$this->player->getName()] = $target;
    }

    public function getFakePlayer(): ?Player {
        return self::$fakePlayer[$this->player->getName()] ?? null;
    }

    public function resetEntity() {
        $entity = $this->player->getWorld()->getEntity($this->getEntityId());
        $this->player->setInvisible(false);
        if ($entity !== null) {
            if ($entity instanceof \ArasakaID\Disguise\entity\Player) {
                $this->player->setNameTag($entity->getNameTag());
                $this->player->setSkin($entity->getSkin());
                $this->player->sendSkin();
            }
            if (!$entity->isFlaggedForDespawn()) {
                $entity->flagForDespawn();
            }
        }

        unset(self::$entityId[$this->player->getName()]);
    }

    public function getEntityId(): int {
        return self::$entityId[$this->player->getName()];
    }

    public function getEntity(): PMEntity {
        return $this->player->getWorld()->getEntity($this->getEntityId());
    }

    public function isRegistered(): bool {
        if (isset(self::$entityId[$this->player->getName()])) {
            return true;
        }

        return false;
    }

}
