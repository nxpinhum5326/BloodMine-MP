<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\block\VanillaBlocks;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

use function mt_rand;

class Sheep extends Living{

	public static function getNetworkTypeId() : string{ return EntityIds::SHEEP; }

	protected function getInitialSizeInfo() : EntitySizeInfo{
		return new EntitySizeInfo(1.12, 1.45);
	}

	public function getName() : string{
		return "Sheep";
	}

	public function getDrops() : array{
		return [
			VanillaBlocks::WOOL()->asItem()->setCount(mt_rand(0, 15))
		];
	}

}
