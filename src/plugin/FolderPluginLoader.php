<?php

declare(strict_types=1);

namespace pocketmine\plugin;

use pocketmine\thread\ThreadSafeClassLoader;

use function is_dir;
use function is_file;
use function file_get_contents;

class FolderPluginLoader implements PluginLoader{
	private ThreadSafeClassLoader $loader;

	public function __construct(ThreadSafeClassLoader $loader){
		$this->loader = $loader;
	}

	public function canLoadPlugin(string $path) : bool{
		return is_dir($path) && is_file("$path/plugin.yml");
	}

	public function loadPlugin(string $path) : void{
		$description = $this->getPluginDescription($path);

		if($description !== null){
			$this->loader->addPath($description->getSrcNamespacePrefix(), "$path/src");
		}
	}

	public function getPluginDescription(string $path) : ?PluginDescription{
		if($this->canLoadPlugin($path)){
			return new PluginDescription(file_get_contents("$path/plugin.yml"));
		}

		return null;
	}

	public function getAccessProtocol() : string{
		return "";
	}
}