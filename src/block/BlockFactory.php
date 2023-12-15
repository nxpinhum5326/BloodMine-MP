<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Item;
use function is_int;

class BlockFactory{
	private static BlockFactory $instance;

	/** @var array|Block[] */
	private array $vanillaBlocks;
	private ?Item $latestCalled = null;

	private function __construct(){
		$this->vanillaBlocks = VanillaBlocks::getAll();
	}

	/**
	 * NOTE: string $name is uppercase (like APPLE)
	 */
	public function getItem(?string $name = null, ?int $count = 1) : Item{
		if(isset($name) && isset($this->vanillaBlocks[$name])){
			$block = $this->vanillaBlocks[$name]->asItem();
		}else{
			throw new \InvalidArgumentException("Block not found for the given name or id!");
		}

		if(is_int($count)){
			$block->setCount($count);
		}else{
			throw new \InvalidArgumentException("$count is not a valid integer value!");
		}

		$this->latestCalled = $block;

		return $block;
	}

	public function getLatestCalled() : ?Item{
		return $this->latestCalled;
	}

	public static function getInstance() : BlockFactory{
		if (!isset(self::$instance)){
			self::$instance = new self();
		}

		return self::$instance;
	}
}
