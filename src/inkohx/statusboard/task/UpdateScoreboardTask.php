<?php


namespace inkohx\statusboard\task;


use inkohx\statusboard\Main;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use Miste\scoreboardspe\API\{
    Scoreboard, ScoreboardDisplaySlot, ScoreboardSort, ScoreboardAction
};
use metowa1227\moneysystem\api\core\API;

class UpdateScoreboardTask extends Task
{
    /* @var Scoreboard */
    private $scoreboard;

    /* @var Player */
    private $player;

    public function __construct(Scoreboard $scoreboard, Player $player)
    {
        $this->scoreboard = $scoreboard;
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        $scoreboard = $this->scoreboard;
        $ping = $this->player->getPing();
        $c = ($ping < 150 ? "§a" : ($ping < 250 ? "§6" : "§4"));
        $x = floor($this->player->getX());
        $y = floor($this->player->getY());
        $z = floor($this->player->getZ());
        $data = date("G:i");
        $money = API::getInstance()->get($this->player);
        
        $scoreboard->setLine(1,"Name: {$this->player->getName()}");
        $scoreboard->setLine(2,"X:{$x} Y:{$y} Z: {$z}");
        $scoreboard->setLine(3, "Time: {$data}");
        $scoreboard->setLine(4, "Money: {$money}");
        $scoreboard->setLine(5, "Ping: {$c}{$ping}");
    }
}
