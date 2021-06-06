<?php

namespace ArasakaID\Disguise;

use ArasakaID\Disguise\data\PlayerData;
use ArasakaID\Disguise\entity\FallingBlock;
use ArasakaID\Disguise\entity\ItemEntity;
use pocketmine\entity\Entity;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player as PMPlayer;
use pocketmine\utils\TextFormat;

class EventListener implements Listener {

    /** @var Main */
    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerToggleSneak(PlayerToggleSneakEvent $event): void {
        $player = $event->getPlayer();
        $playerData = new PlayerData($player);
        if ($this->plugin->getConfig()->get("disguise-block-sneak") && $playerData->isRegistered()) {
            $entity = $playerData->getEntity();
            if ($entity instanceof FallingBlock) {
                if ($event->isSneaking()) {
                    $floor = $player->getPosition()->floor();
                    /** @var Entity $target */
                    foreach ([$entity, $player] as $target) {
                        $target->teleport(new Vector3($floor->x + 0.5, $player->getWorld()->getHighestBlockAt($floor->x, $floor->z) + 1.2, $floor->z + 0.5));
                        $player->setImmobile();
                    }
                    $player->setImmobile();
                } elseif ($player->isImmobile()) {
                    $player->setImmobile(false);
                }
            }
        }
    }

    public function onInventoryPickupItem(InventoryPickupItemEvent $event): void {
        $item = $event->getItemEntity();
        if ($item instanceof ItemEntity) {
            $event->cancel();
        }
    }

    /**
     * @param PlayerChatEvent $event
     * @handleCancelled true
     */
    public function onPlayerChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $playerData = new PlayerData($player);
        if ($playerData->isRegistered()) {
            $target = $playerData->getFakePlayer();
            if ($target instanceof PMPlayer) {
                $event->cancel();
                if ($target->isOnline()) {
                    $target->chat($event->getMessage());
                } else {
                    $player->sendMessage(TextFormat::RED . "The player you disguised has offline!");
                }
            }
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event): void {
        $player = $event->getPlayer();
        $playerData = new PlayerData($player);
        if ($playerData->isRegistered()) {
            $playerData->resetEntity();
        }
    }

}
