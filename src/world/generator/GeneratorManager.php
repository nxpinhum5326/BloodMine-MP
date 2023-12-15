<?php

declare(strict_types=1);

namespace pocketmine\world\generator;

use pocketmine\utils\SingletonTrait;
use pocketmine\utils\Utils;
use pocketmine\world\generator\end\End;
use pocketmine\world\generator\hell\Nether;
use pocketmine\world\generator\normal\Normal;
use function array_keys;
use function strtolower;

final class GeneratorManager{
	use SingletonTrait;

	/**
	 * @var GeneratorManagerEntry[] name => classname mapping
	 * @phpstan-var array<string, GeneratorManagerEntry>
	 */
	private array $list = [];

	public function __construct(){
		$this->addGenerator(Flat::class, "flat", function(string $preset) : ?InvalidGeneratorOptionsException{
			if($preset === ""){
				return null;
			}
			try{
				FlatGeneratorOptions::parsePreset($preset);
				return null;
			}catch(InvalidGeneratorOptionsException $e){
				return $e;
			}
		});
		$this->addGenerator(Normal::class, "normal", fn() => null);
		$this->addAlias("normal", "default");
		$this->addGenerator(Nether::class, "nether", fn() => null);
		$this->addAlias("nether", "hell");
		$this->addGenerator(End::class, "end", fn() => null);
		$this->addAlias("end", "ender");
	}

	/**
	 * @param string   $class           Fully qualified name of class that extends \pocketmine\world\generator\Generator
	 * @param string   $name            Alias for this generator type that can be written in configs
	 * @param \Closure $presetValidator Callback to validate generator options for new worlds
	 * @param bool     $overwrite       Whether to force overwriting any existing registered generator with the same name
	 *
	 * @phpstan-param \Closure(string) : ?InvalidGeneratorOptionsException $presetValidator
	 *
	 * @phpstan-param class-string<Generator> $class
	 *
	 * @throws \InvalidArgumentException
	 */
	public function addGenerator(string $class, string $name, \Closure $presetValidator, bool $overwrite = false) : void{
		Utils::testValidInstance($class, Generator::class);

		$name = strtolower($name);
		if(!$overwrite && isset($this->list[$name])){
			throw new \InvalidArgumentException("Alias \"$name\" is already assigned");
		}

		$this->list[$name] = new GeneratorManagerEntry($class, $presetValidator);
	}

	/**
	 * Aliases an already-registered generator name to another name. Useful if you want to map a generator name to an
	 * existing generator without having to replicate the parameters.
	 */
	public function addAlias(string $name, string $alias) : void{
		$name = strtolower($name);
		$alias = strtolower($alias);
		if(!isset($this->list[$name])){
			throw new \InvalidArgumentException("Alias \"$name\" is not assigned");
		}
		if(isset($this->list[$alias])){
			throw new \InvalidArgumentException("Alias \"$alias\" is already assigned");
		}
		$this->list[$alias] = $this->list[$name];
	}

	/**
	 * Returns a list of names for registered generators.
	 *
	 * @return string[]
	 */
	public function getGeneratorList() : array{
		return array_keys($this->list);
	}

	/**
	 * Returns the generator entry of a registered Generator matching the given name, or null if not found.
	 */
	public function getGenerator(string $name) : ?GeneratorManagerEntry{
		return $this->list[strtolower($name)] ?? null;
	}

	/**
	 * Returns the registered name of the given Generator class.
	 *
	 * @param string $class Fully qualified name of class that extends \pocketmine\world\generator\Generator
	 * @phpstan-param class-string<Generator> $class
	 *
	 * @throws \InvalidArgumentException if the class type cannot be matched to a known alias
	 */
	public function getGeneratorName(string $class) : string{
		Utils::testValidInstance($class, Generator::class);
		foreach(Utils::stringifyKeys($this->list) as $name => $c){
			if($c->getGeneratorClass() === $class){
				return $name;
			}
		}

		throw new \InvalidArgumentException("Generator class $class is not registered");
	}
}
