THE PROTECT IS DEAD FOR AN INDEFINITE PERIOD!

<p align="center">
	<a href="https://pmmp.io">
		<!--[if IE]>
			<img src="https://github.com/pmmp/PocketMine-MP/blob/stable/.github/readme/pocketmine.png" alt="The PocketMine-MP logo" title="PocketMine" loading="eager" />
		<![endif]-->
		<picture>
			<source srcset="https://i.ibb.co/bdP8jPv/bm-mp-3.png" media="(prefers-color-scheme: dark)">
			<img src="https://i.ibb.co/bdP8jPv/bm-mp-3.png" loading="eager" />
		</picture>
	</a><br>
	<b>A highly customisable, rich and open source server software for Minecraft: Bedrock Edition written in PHP</b>
	<b>It's a fork of Pocketmine-MP. </b>
</p>

<p align="center">
	<a href="https://github.com/nxpinhum5326/BloodMine-MP/actions/workflows/main.yml"><img src="https://github.com/nxpinhum5326/BloodMine-MP/workflows/CI/badge.svg" alt="CI" /></a>
	<a href="https://discord.gg/j7TX2vyWqH"><img src="https://img.shields.io/discord/1180620664110067712?label=discord&color=7289DA&logo=discord" alt="Discord" /></a>
	<!--<a href="https://github.com/pmmp/PocketMine-MP/releases/latest"><img alt="GitHub release (latest SemVer)" src="https://img.shields.io/github/v/release/pmmp/PocketMine-MP?label=release&sort=semver"></a>-->
	<br>
	<!--<a href="https://github.com/pmmp/PocketMine-MP/releases"><img alt="GitHub all releases" src="https://img.shields.io/github/downloads/pmmp/PocketMine-MP/total?label=downloads%40total"></a>
	<a href="https://github.com/pmmp/PocketMine-MP/releases/latest"><img alt="GitHub release (latest by SemVer)" src="https://img.shields.io/github/downloads/pmmp/PocketMine-MP/latest/total?sort=semver"></a>-->
</p>

## Getting Started
#### How to download and run?
##### Windows.
- Download latest phar and ```start.cmd``` from [releases](https://github.com/nxpinhum5326/BloodMine-MP/releases)
- Download latest binaries from [pm-binaries](https://github.com/pmmp/PHP-Binaries/releases).
- Then create a server folder and put them(needs ```start.cmd``` file from project).
- Go into ```bin``` folder; If you have installed ```vc_redist.64.exe``` before, skip this step or run ```vc_redist.x64.exe```.
- Finally, click on ```start.cmd``` to start the server, and that's it.

##### Linux & MacOS
- ```cd``` to wherever you want to put the server (e.g. ```cd /home/scher```)
- Make a folder for your server using ```mkdir``` (e.g. ```mkdir myserver```). If you’re updating an existing server, ```cd``` directly to your server’s folder instead.
- Run ```rm -rf ./bin ./BloodMine-MP.phar ./start.sh.``` This deletes any outdated server files (don’t worry, your data won’t be harmed).
- Find the right PHP version for your OS and download latest binaries from [pm-binaries](https://github.com/pmmp/PHP-Binaries/releases). You can see a list of available ones here.
- Run ```curl -L <link to your chosen PHP binary> | tar -xz.``` Now you should have a folder called ```bin```. **Make sure you get the right version for your chosen version of PocketMine-MP (see below).**
- Download latest phar from and ```start.sh``` here [releases](https://github.com/nxpinhum5326/BloodMine-MP/releases).
- Run ```curl -LO <link to BloodMine-MP.phar>```.
- Run ```curl -LO <link to start.sh>```.
- Run ```chmod +x ./start.sh```, and that's it. Now you should be able to run the server by running ```./start.sh```.

## Helpful resources
- [Documentation]()
- [Plugins supported by our team](https://github.com/willbeadded)

## Developing Plugins
 * [Developer documentation]() - General documentation for plugin developers

## How to contribute?
 * By creating a [pull request](https://github.com/nxpinhum5326/BloodMine-MP/pulls)

nxpinhum5326/BloodMine-MP & blood-pixel are not affiliated with Mojang. All brands and trademarks belong to their respective owners. BloodMine-MP is not a Mojang-approved software, nor is it associated with Mojang.
