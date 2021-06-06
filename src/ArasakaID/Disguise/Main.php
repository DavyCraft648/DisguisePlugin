<?php

namespace ArasakaID\Disguise;

use ArasakaID\Disguise\command\DisguiseCommand;
use ArasakaID\Disguise\entity\FallingBlock;
use ArasakaID\Disguise\entity\ItemEntity;
use ArasakaID\Disguise\entity\Player;
use ArasakaID\Disguise\entity\types\Chicken;
use ArasakaID\Disguise\entity\types\Cow;
use ArasakaID\Disguise\entity\types\Creeper;
use ArasakaID\Disguise\entity\types\Pig;
use ArasakaID\Disguise\entity\types\Sheep;
use ArasakaID\Disguise\entity\types\Skeleton;
use ArasakaID\Disguise\entity\types\Villager;
use ArasakaID\Disguise\entity\types\Wolf;
use ArasakaID\Disguise\entity\types\Zombie;
use pocketmine\block\BlockFactory;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\world\World;

class Main extends PluginBase {

    /** @var Main */
    private static $instance;

    public static function getInstance(): Main {
        return self::$instance;
    }

    public function onEnable(): void {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register($this->getName(), new DisguiseCommand($this));
        $this->registerEntities();
        $this->checkConfig();
    }

    private function registerEntities(): void {
        /** @var EntityFactory $factory */
        $factory = EntityFactory::getInstance();
        $factory->register(FallingBlock::class, function(World $world, CompoundTag $nbt): FallingBlock {
            return new FallingBlock(null, FallingBlock::parseBlockNBT(BlockFactory::getInstance(), $nbt), false, EntityDataHelper::parseLocation($nbt, $world), $nbt);
        }, ['disguise:falling_block'], EntityLegacyIds::FALLING_BLOCK);

        $factory->register(ItemEntity::class, function(World $world, CompoundTag $nbt): ItemEntity {
            $itemTag = $nbt->getCompoundTag("Item");
            if ($itemTag === null) {
                throw new \UnexpectedValueException("Expected \"Item\" NBT tag not found");
            }

            $item = Item::nbtDeserialize($itemTag);
            if ($item->isNull()) {
                throw new \UnexpectedValueException("Item is invalid");
            }

            return new ItemEntity(null, $item, EntityDataHelper::parseLocation($nbt, $world), $nbt);
        }, ['disguise:item'], EntityLegacyIds::ITEM);

        $factory->register(Player::class, function(World $world, CompoundTag $nbt): Player {
            return new Player(null, Player::parseSkinNBT($nbt), EntityDataHelper::parseLocation($nbt, $world), $nbt);
        }, ['disguise:player']);

        if ($this->getConfig()->get("disguise-entity")) {
            $factory->register(Chicken::class, function(World $world, CompoundTag $nbt): Chicken {
                return new Chicken(null, EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['disguise:chicken']);

            $factory->register(Cow::class, function(World $world, CompoundTag $nbt): Cow {
                return new Cow(null, EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['disguise:cow']);

            $factory->register(Creeper::class, function(World $world, CompoundTag $nbt): Creeper {
                return new Creeper(null, EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['disguise:creeper']);

            $factory->register(Pig::class, function(World $world, CompoundTag $nbt): Pig {
                return new Pig(null, EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['disguise:pig']);

            $factory->register(Sheep::class, function(World $world, CompoundTag $nbt): Sheep {
                return new Sheep(null, EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['disguise:sheep']);

            $factory->register(Skeleton::class, function(World $world, CompoundTag $nbt): Skeleton {
                return new Skeleton(null, EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['disguise:skeleton']);

            $factory->register(Villager::class, function(World $world, CompoundTag $nbt): Villager {
                return new Villager(null, EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['disguise:villager']);

            $factory->register(Wolf::class, function(World $world, CompoundTag $nbt): Wolf {
                return new Wolf(null, EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['disguise:wolf']);

            $factory->register(Zombie::class, function(World $world, CompoundTag $nbt): Zombie {
                return new Zombie(null, EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, ['disguise:zombie']);
        }
    }

    private function checkConfig(): void {
        if ($this->getConfig()->get("config-version") !== 1.2) {
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config-old.yml");
            $this->reloadConfig();
        }
    }

}
