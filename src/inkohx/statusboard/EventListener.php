<?php


namespace inkohx\statusboard;


use inkohx\statusboard\task\UpdateScoreboardTask;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use Miste\scoreboardspe\API\{
    Scoreboard, ScoreboardDisplaySlot, ScoreboardSort, ScoreboardAction
};
use pocketmine\utils\TextFormat;
use metowa1227\moneysystem\api\core\API;

class EventListener implements Listener
{
    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $ping = $player->getPing();
        $c = ($ping < 150 ? "§a" : ($ping < 250 ? "§6" : "§4"));
        $x = floor($player->getX());
        $y = floor($player->getY());
        $z = floor($player->getZ());
        $data = date("G:i");
        $money = API::getInstance()->get($player);
        
        $scoreboard = new Scoreboard(Main::$instance->getServer()->getPluginManager()->getPlugin("ScoreboardsPE")->getPlugin(), TextFormat::GREEN . "Komugi LIFE", ScoreboardAction::CREATE);
        $scoreboard->create(ScoreboardDisplaySlot::SIDEBAR, ScoreboardSort::DESCENDING);
        $scoreboard->addDisplay($player);
        $scoreboard->setLine(1,"Name: {$player->getName()}");
        $scoreboard->setLine(2,"X:{$x} Y:{$y} Z: {$z}");
        $scoreboard->setLine(3, "Time: {$data}");
        $scoreboard->setLine(4, "Money: {$money}");
        $scoreboard->setLine(5, "Ping: {$c}{$ping}");
        
        Main::$instance->getScheduler()->scheduleRepeatingTask(new UpdateScoreboardTask($scoreboard, $player), 40);
    }
}
