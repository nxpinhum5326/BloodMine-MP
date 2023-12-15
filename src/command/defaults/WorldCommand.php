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

namespace pocketmine\command\defaults;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;
use SplFileInfo;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\generator\GeneratorManager;
use pocketmine\world\WorldCreationOptions;

class WorldCommand extends VanillaCommand{

	public function __construct(){
		parent::__construct(
			"world",
			KnownTranslationFactory::pocketmine_command_world_description(),
			"/world <create:load:teleport:delete>"
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_WORLD);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		$server = $sender->getServer();

		if(count($args) >= 2){
			$worldName = $args[1];

			switch(strtolower($args[0])){
				case "teleport":
					if($sender instanceof Player){
						if($server->getWorldManager()->isWorldGenerated($worldName)){
							if(!$server->getWorldManager()->isWorldLoaded($worldName)) $server->getWorldManager()->loadWorld($worldName);
							$world = $server->getWorldManager()->getWorldByName($worldName);
							$sender->teleport($world->getSpawnLocation());
						} else {
							$sender->sendMessage("The world with the given name was not created!");
						}
					}

					return true;

				case "load":
					if($server->getWorldManager()->isWorldGenerated($worldName)){
						if(!$server->getWorldManager()->isWorldLoaded($worldName)){
							$server->getWorldManager()->loadWorld($worldName);
							$sender->sendMessage("The world has been loaded with the given name.");
						} else {
							$sender->sendMessage("The world with given name was loaded already!");
						}
					} else {
						$sender->sendMessage("The world with the given name was not created!");
					}

					return true;

				case "create":
					$worldSeed = mt_rand();
					$worldGenerator = $args[2] ?? "normal";
					$generator = GeneratorManager::getInstance()->getGenerator($worldGenerator);

					$server->getWorldManager()->generateWorld($worldName, WorldCreationOptions::create()->setSeed($worldSeed)->setGeneratorClass($generator->getGeneratorClass()));
					$sender->sendMessage("The world has been created with the given name.");

					return true;

				case "delete":
					$this->removeWorld($worldName);
					$sender->sendMessage($worldName . " has been removed.");

					return true;
			}
		}

		throw new InvalidCommandSyntaxException();
	}

	//multiworld
	private function removeWorld(string $worldName) : void{
		if(Server::getInstance()->getWorldManager()->isWorldLoaded($worldName)){
			$world = Server::getInstance()->getWorldManager()->getWorldByName($worldName);

			if(count($world->getPlayers()) > 0){
				foreach($world->getPlayers() as $worldPlayer){
					$worldPlayer->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSpawnLocation());
				}
			}

			Server::getInstance()->getWorldManager()->unloadWorld($world, true);

			$worldPath = Server::getInstance()->getDataPath() . "/worlds/$worldName";
			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($worldPath, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
			/** @var SplFileInfo $fileInfo */
			foreach($files as $fileInfo){
				if($filePath = $fileInfo->getRealPath()){
					if($fileInfo->isFile()){
						@unlink($filePath);
					} else {
						@rmdir($filePath);
					}
				}
			}

			@rmdir($worldPath);
		}
	}
}