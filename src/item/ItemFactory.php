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

namespace pocketmine\item;

use function is_int;

class ItemFactory{
	private static ItemFactory $instance;
	private VanillaItemsIdentifier $ids;

	/** @var array|Item[] */
	private array $idList;
	/** @var array|Item[] */
	private array $vanillaItems;
	private ?Item $latestCalled = null;

	private function __construct(){
		$this->ids = new VanillaItemsIdentifier();
		$this->idList = $this->ids->getList();
		$this->vanillaItems = VanillaItems::getAll();
	}

	/**
	 * NOTE: string $name is uppercase (like APPLE)
	 */
	public function getItem(?string $name = null, ?int $id = null, ?int $count = 1) : Item{
		if(isset($name) && isset($this->vanillaItems[$name])){
			$item = $this->vanillaItems[$name];
		}elseif(isset($id) && isset($this->idList[$id])){
			$item = $this->idList[$id];
		}else{
			throw new \InvalidArgumentException("Item not found for the given name or id!");
		}

		if(is_int($count)){
			$item->setCount($count);
		}else{
			throw new \InvalidArgumentException("$count is not a valid integer value!");
		}

		$this->latestCalled = $item;

		return $item;
	}

	public function getLatestCalled() : ?Item{
		return $this->latestCalled;
	}

	public static function getInstance() : ItemFactory{
		if (!isset(self::$instance)){
			self::$instance = new self();
		}

		return self::$instance;
	}
}
