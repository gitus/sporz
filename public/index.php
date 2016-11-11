<?php

require_once '../vendor/autoload.php'; // Autoload our dependencies with Composer
require_once '../config/config.php'; // config APP

use Pragma\View\View;
use Pragma\Router\Router;

use App\Models\Game;

use App\Helpers\Redirect;

$view = View::getInstance();
$view->set_tpl_path(APP_PATH.'/Views/');
$view->setLayout('layout.tpl.php');

$app = Router::getInstance();

//define your routes here
$app->get('/', function () use ($app) {
    //HOME PAGE
    View::getInstance()->assign('joinableGames', Game::getNonStartedGame());
    View::getInstance()->assign('router', $app);
    View::getInstance()->render('index.tpl.php');
});

$app->group('/game', function () use ($app) {
    $app->post('', function () use ($app) {
        $game = new Game();
        $game->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

        $game->created = $game->updated = date('c');

        $game->save();

        Redirect::to($app->url_for('game-detail', ['gameid' => $game->id]));
    })->alias('game-creation');
    $app->get('/add', function ()  use ($app) {
        $view = View::getInstance();

        $game = new Game();

        $view->assign('game', $game);

        $view->assign('form-action', $app->url_for('game-creation'));
        $view->render('game/form.tpl.php');
    });
    $app->group('/:gameid', function () use ($app) {
        $app->get('', function ($gameId) use ($app) {
            $view = View::getInstance();

            $game = new Game();
            $game->open($gameId);

            $view->assign('game', $game);

            $view->assign('edit-link', $app->url_for('game-edit', ['gameid' => $game->id]));

            $view->render('game/detail.tpl.php');
        })->alias('game-detail');
        $app->get('/edit', function ($gameId) use ($app) {
            $view = View::getInstance();

            $game = new Game();
            $game->open($gameId);

            $view->assign('game', $game);

            $view->assign('form-action', $app->url_for('game-save', ['gameid' => $game->id]));
            $view->render('game/form.tpl.php');
        })->alias('game-edit');
        $app->post('', function ($gameId) use ($app) {
            $game = new Game();
            $game->open($gameId);

            $game->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

            $game->updated = date('c');

            $game->save();

            Redirect::to($app->url_for('game-detail', ['gameid' => $game->id]));
        })->alias('game-save');
    });
});

$app->get('/:keyId', function () {
    //si keyId existe, displayGame
    //$player=new Player();
    //$player->open("keyId");
    //$game=new Game();
    //$game=open($player->game_id);
    //en fonction de $game->phase, $template=xyz
    //View::getInstance()->render($template);
});
$app->post('/:keyId/cure', function () {
    //si $game->phase dit que c'est aux médecins de jouer et que $player->role=="medic" alors getPlayer($POST[name])->cure() et $game->nextPhase();
});
$app->post('/createGame', function () {
    //si possible de créer un joueur avec POST[name] alors créer une partie et rediriger vers /:keyId
});
$app->post('/joinGame', function () {
    //si possible de créer un joueur avec POST[name] alors joinGame et redirige vers /:keyId
});

try {
    $app->run();
    $view->compute();
} catch (Pragma\Router\RouterException $e) {
    var_dump($e);
}
