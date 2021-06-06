<?php

namespace ArasakaID\Disguise\command;

use ArasakaID\Disguise\data\PlayerData;
use ArasakaID\Disguise\entity\FallingBlock;
use ArasakaID\Disguise\entity\ItemEntity;
use ArasakaID\Disguise\entity\types\Chicken;
use ArasakaID\Disguise\entity\types\Cow;
use ArasakaID\Disguise\entity\types\Creeper;
use ArasakaID\Disguise\entity\types\Pig;
use ArasakaID\Disguise\entity\Player as DisguisePlayer;
use ArasakaID\Disguise\entity\types\Sheep;
use ArasakaID\Disguise\entity\types\Skeleton;
use ArasakaID\Disguise\entity\types\Villager;
use ArasakaID\Disguise\entity\types\Wolf;
use ArasakaID\Disguise\entity\types\Zombie;
use ArasakaID\Disguise\Main;
use InvalidArgumentException;
use pocketmine\block\Air;
use pocketmine\block\BlockFactory;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;

class DisguiseCommand extends Command implements PluginOwned {

    /** @var Main */
    private $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("disguise", "Disguised as whatever you want!");
        $this->plugin = $plugin;
        $this->setPermission("disguise.command.use");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$this->testPermission($sender) || !($sender instanceof Player)) return;

        $playerData = new PlayerData($sender);
        if ($playerData->isRegistered()) {
            $playerData->resetEntity();
        }

        if (count($args) == 0) {
            $sender->sendMessage(TextFormat::RED . "Usage: /disguise help");
            return;
        }

        switch ($args[0]) {
            case "block":
                if (!$sender->hasPermission("disguise.command.use.block")) break;
                if (!isset($args[1])) {
                    $sender->sendMessage(TextFormat::RED . "Usage: /disguise block <blockName/BlockID>");
                    return;
                }

                try {
                    $block = LegacyStringToItemParser::getInstance()->parse($args[1])->getBlock();
                } catch (InvalidArgumentException $e) {
                    $sender->sendMessage(TextFormat::RED . "Item block \"$args[1]\" not found!");
                    return;
                }
                if ($block instanceof Air) {
                    $sender->sendMessage(TextFormat::RED . "Item must be an Item block!");
                    return;
                }

                $entity = new FallingBlock($sender,
                    BlockFactory::getInstance()->get($block->getId(), $block->getMeta()),
                    $this->plugin->getConfig()->get("disguise-block-sneak"));
                $entity->setImmobile(); #Don't fall while flying!!!!
                $entity->spawnToAll();
                $playerData->setEntityId($entity->getId());

                $sender->sendMessage(str_replace('{BlockName}', $block->getName(), $this->plugin->getConfig()->get("disguise-as-block")));
                return;

            case "item":
                if (!$sender->hasPermission("disguise.command.use.item")) break;
                if (!isset($args[1])) {
                    $sender->sendMessage(TextFormat::RED . "Usage: /disguise item <blockName/BlockID>");
                    return;
                }

                try {
                    $item = LegacyStringToItemParser::getInstance()->parse($args[1]);
                } catch (InvalidArgumentException $e) {
                    $sender->sendMessage(TextFormat::RED . "Item \"$args[1]\" not found!");
                    return;
                }

                $itemEntity = new ItemEntity($sender, $item);
                $itemEntity->setImmobile();#Don't fall while flying!!!!
                $itemEntity->spawnToAll();
                $playerData->setEntityId($itemEntity->getId());

                $sender->sendMessage(str_replace('{ItemName}', $item->getName(), $this->plugin->getConfig()->get("disguise-as-item")));
                return;

            case "entity":
                if (!$this->plugin->getConfig()->get("disguise-entity")) {
                    $sender->sendMessage(TextFormat::RED . "Disguise entity is disable!");
                    return;
                }

                if (!isset($args[1])) {
                    $entities = ["Chicken", "Cow", "Creeper", "Pig", "Sheep", "Skeleton", "Villager", "Wolf", "Zombie"];
                    $sender->sendMessage(TextFormat::RED . "Usage: /disguise entity <" . implode("/", $entities) . ">");
                    return;
                }

                switch ($args[1]) {
                    case "chicken":
                        if (!$sender->hasPermission("disguise.command.use.chicken")) break;

                        $entity = new Chicken($sender);
                        $entity->spawnToAll();
                        $playerData->setEntityId($entity->getId());

                        $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                        return;

                    case "cow":
                        if (!$sender->hasPermission("disguise.command.use.cow")) break;

                        $entity = new Cow($sender);
                        $entity->spawnToAll();
                        $playerData->setEntityId($entity->getId());

                        $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                        return;

                    case "creeper":
                        if (!$sender->hasPermission("disguise.command.use.creeper")) break;

                        $entity = new Creeper($sender);
                        $entity->spawnToAll();
                        $playerData->setEntityId($entity->getId());

                        $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                        return;

                    case "pig":
                        if (!$sender->hasPermission("disguise.command.use.pig")) break;

                        $entity = new Pig($sender);
                        $entity->spawnToAll();
                        $playerData->setEntityId($entity->getId());

                        $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                        return;

                    case "sheep":
                        if (!$sender->hasPermission("disguise.command.use.sheep")) break;

                        $entity = new Sheep($sender);
                        $entity->spawnToAll();
                        $playerData->setEntityId($entity->getId());

                        $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                        return;

                    case "skeleton":
                        if (!$sender->hasPermission("disguise.command.use.skeleton")) break;

                        $entity = new Skeleton($sender);
                        $entity->spawnToAll();
                        $playerData->setEntityId($entity->getId());

                        $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                        return;

                    case "villager":
                        if (!$sender->hasPermission("disguise.command.use.villager")) break;

                        $entity = new Villager($sender);
                        $entity->spawnToAll();
                        $playerData->setEntityId($entity->getId());

                        $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                        return;

                    case "wolf":
                        if (!$sender->hasPermission("disguise.command.use.wolf")) break;

                        $entity = new Wolf($sender);
                        $entity->spawnToAll();
                        $playerData->setEntityId($entity->getId());

                        $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                        return;

                    case "zombie":
                        if (!$sender->hasPermission("disguise.command.use.zombie")) break;

                        $entity = new Zombie($sender);
                        $entity->spawnToAll();
                        $playerData->setEntityId($entity->getId());

                        $sender->sendMessage(str_replace('{EntityName}', $entity->getName(), $this->plugin->getConfig()->get("disguise-as-entity")));
                        return;
                }
                break;

            case "player":
                if (!$sender->hasPermission("disguise.command.use.player")) break;
                if (!isset($args[1])) {
                    $sender->sendMessage(TextFormat::RED . "Usage: /disguise player <playerName>");
                    return;
                }

                $target = $sender->getServer()->getPlayerExact($args[1]);
                if ($target === null) {
                    $sender->sendMessage(TextFormat::RED . "The player is not online in this server!");
                    return;
                }

                $entity = new DisguisePlayer($sender, $sender->getSkin());
                $entity->setNameTag($sender->getNameTag());
                $entity->setScale(0.1);
                $entity->setInvisible();
                $entity->setImmobile();
                $entity->spawnToAll();
                $playerData->setEntityId($entity->getId(), $target);

                $sender->setInvisible(false);
                $sender->setSkin($target->getSkin());
                $sender->sendSkin();
                $sender->setNameTag($target->getNameTag());

                $sender->sendMessage(str_replace('{TargetName}', $target->getName(), $this->plugin->getConfig()->get("disguise-as-player")));
                return;

            case "help":
                $sender->sendMessage(TextFormat::RED . "Usage: /disguise <block/item/player/entity/clear> <args>");
                return;
        }
        $sender->sendMessage(TextFormat::RED . "You don't have permission to do this command!");
    }

    public function getOwningPlugin(): Plugin {
        return $this->plugin;
    }

}
